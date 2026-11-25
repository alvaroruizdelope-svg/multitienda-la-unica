<?php
/**
 * Importación manual del catálogo de demostración incluido en el tema.
 *
 * @package Multitienda_La_Unica
 */

defined( 'ABSPATH' ) || exit;

function la_unica_can_import_demo() {
	return function_exists( 'wc_get_product_id_by_sku' )
		&& current_user_can( 'manage_woocommerce' )
		&& current_user_can( 'publish_products' )
		&& current_user_can( 'manage_product_terms' )
		&& current_user_can( 'upload_files' );
}

function la_unica_demo_menu() {
	if ( la_unica_can_import_demo() ) {
		add_submenu_page(
			'woocommerce',
			__( 'Productos de demostración', 'multitienda-la-unica' ),
			__( 'Demostración La Única', 'multitienda-la-unica' ),
			'manage_woocommerce',
			'la-unica-demo',
			'la_unica_demo_page'
		);
	}
}
add_action( 'admin_menu', 'la_unica_demo_menu' );

function la_unica_demo_page() {
	if ( ! la_unica_can_import_demo() ) {
		wp_die( esc_html__( 'No tienes permisos para importar esta demostración.', 'multitienda-la-unica' ) );
	}

	$result_key = 'la_unica_demo_result_' . get_current_user_id();
	$result     = get_transient( $result_key );
	if ( is_array( $result ) ) {
		delete_transient( $result_key );
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Productos de demostración de Multitienda La Única', 'multitienda-la-unica' ); ?></h1>
		<p><?php esc_html_e( 'Importa seis productos de prueba con sus imágenes, categorías y origen comercial. Los artículos nuevos serán visibles en el catálogo y llevarán la marca [DEMO]. Usa esta opción en tu instalación de demostración.', 'multitienda-la-unica' ); ?></p>
		<p><?php esc_html_e( 'Los productos con un SKU existente se omiten. La activación y las actualizaciones del tema no ejecutan la importación.', 'multitienda-la-unica' ); ?></p>
		<?php if ( is_array( $result ) ) : ?>
			<div class="notice <?php echo $result['errors'] ? 'notice-warning' : 'notice-success'; ?>">
				<p><?php
					/* translators: 1: created product count, 2: skipped product count. */
					echo esc_html( sprintf( __( 'Productos creados: %1$d. Productos existentes omitidos: %2$d.', 'multitienda-la-unica' ), $result['created'], $result['skipped'] ) );
				?></p>
				<?php if ( $result['errors'] ) : ?>
					<ul>
						<?php foreach ( $result['errors'] as $message ) : ?>
							<li><?php echo esc_html( $message ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="la_unica_import_demo">
			<?php wp_nonce_field( 'la_unica_import_demo' ); ?>
			<?php submit_button( __( 'Importar productos de demostración', 'multitienda-la-unica' ) ); ?>
		</form>
	</div>
	<?php
}

function la_unica_handle_demo_import() {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! la_unica_can_import_demo() ) {
		wp_die( esc_html__( 'No tienes permisos para importar esta demostración.', 'multitienda-la-unica' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'la_unica_import_demo' );

	global $wpdb;
	$result = array( 'created' => 0, 'skipped' => 0, 'errors' => array() );
	$lock   = 'la_unica_demo_' . md5( DB_NAME . ':' . $wpdb->prefix );

	// El bloqueo pertenece a la conexión y MySQL/MariaDB lo libera si se interrumpe la petición.
	if ( '1' === (string) $wpdb->get_var( $wpdb->prepare( 'SELECT GET_LOCK(%s, 0)', $lock ) ) ) {
		try {
			la_unica_import_demo_products( $result );
		} catch ( Exception $error ) {
			$result['errors'][] = $error->getMessage();
		} finally {
			$wpdb->get_var( $wpdb->prepare( 'SELECT RELEASE_LOCK(%s)', $lock ) );
		}
	} else {
		$result['errors'][] = __( 'No se pudo iniciar la importación. Si hay otra importación en curso, espera a que termine y vuelve a intentarlo.', 'multitienda-la-unica' );
	}

	set_transient( 'la_unica_demo_result_' . get_current_user_id(), $result, 5 * MINUTE_IN_SECONDS );
	wp_safe_redirect( admin_url( 'admin.php?page=la-unica-demo' ) );
	exit;
}
add_action( 'admin_post_la_unica_import_demo', 'la_unica_handle_demo_import' );

function la_unica_import_demo_products( &$result ) {
	$directory = get_theme_file_path( '/demo' );
	$file      = fopen( $directory . '/productos-demostracion.csv', 'rb' );
	if ( ! $file ) {
		throw new RuntimeException( __( 'Falta el CSV de demostración en la carpeta del tema.', 'multitienda-la-unica' ) );
	}

	$pending = array();
	try {
		$headers = fgetcsv( $file, 0, ',', '"', '' );
		if ( ! $headers ) {
			throw new RuntimeException( __( 'El CSV de demostración no contiene encabezados.', 'multitienda-la-unica' ) );
		}
		while ( false !== ( $values = fgetcsv( $file, 0, ',', '"', '' ) ) ) {
			if ( count( $headers ) !== count( $values ) ) {
				throw new RuntimeException( __( 'Hay una fila incompleta en el CSV de demostración.', 'multitienda-la-unica' ) );
			}
			$row = array_combine( $headers, $values );
			if ( ! preg_match( '/^LUNICA-DEMO-[A-Z-]+$/D', $row['SKU'] ?? '' ) ) {
				throw new RuntimeException( __( 'Hay un SKU incorrecto en el CSV de demostración.', 'multitienda-la-unica' ) );
			}
			if ( wc_get_product_id_by_sku( $row['SKU'] ) ) {
				++$result['skipped'];
				continue;
			}
			$pending[] = $row;
		}
	} finally {
		fclose( $file );
	}

	if ( ! $pending ) {
		return;
	}

	$attribute_id = wc_attribute_taxonomy_id_by_name( 'origen' );
	if ( ! $attribute_id ) {
		$attribute_id = la_unica_demo_check( wc_create_attribute( array(
			'name'         => 'Origen',
			'slug'         => 'origen',
			'type'         => 'select',
			'has_archives' => true,
		) ) );
		// WooCommerce registrará el atributo completo en el siguiente init.
		if ( ! taxonomy_exists( 'pa_origen' ) ) {
			la_unica_demo_check( register_taxonomy( 'pa_origen', 'product', array( 'public' => false ) ) );
		}
	}

	foreach ( $pending as $row ) {
		try {
			la_unica_create_demo_product( $row, $directory, $attribute_id );
			++$result['created'];
		} catch ( Exception $error ) {
			$result['errors'][] = $row['SKU'] . ' — ' . $error->getMessage();
		}
	}
}

function la_unica_demo_check( $value ) {
	if ( is_wp_error( $value ) ) {
		throw new RuntimeException( $value->get_error_message() );
	}
	return $value;
}

function la_unica_demo_term( $name, $taxonomy, $parent = 0, $slug = '' ) {
	$term = $slug ? get_term_by( 'slug', $slug, $taxonomy ) : term_exists( $name, $taxonomy, $parent );
	if ( $term ) {
		return (int) ( $slug ? $term->term_id : $term['term_id'] );
	}
	$args = array( 'parent' => $parent );
	if ( $slug ) {
		$args['slug'] = $slug;
	}
	$created = wp_insert_term( $name, $taxonomy, $args );
	if ( is_wp_error( $created ) && 'term_exists' === $created->get_error_code() && ! $slug ) {
		return (int) $created->get_error_data();
	}
	return (int) la_unica_demo_check( $created )['term_id'];
}

function la_unica_create_demo_product( $row, $directory, $attribute_id ) {
	$origin = new WC_Product_Attribute();
	$origin->set_id( $attribute_id );
	$origin->set_name( 'pa_origen' );
	$origin->set_visible( true );
	$origin->set_options( array( la_unica_demo_term( $row['Attribute 1 value(s)'], 'pa_origen', 0, sanitize_title( $row['Attribute 1 value(s)'] ) ) ) );

	$category_id = 0;
	foreach ( explode( ' > ', $row['Categories'] ) as $category ) {
		$category_id = la_unica_demo_term( $category, 'product_cat', $category_id );
	}

	$product = new WC_Product_Simple();
	$product->set_sku( $row['SKU'] );
	$product->set_name( $row['Name'] );
	$product->set_status( 'publish' );
	$product->set_short_description( $row['Short description'] );
	$product->set_regular_price( $row['Regular price'] );
	$product->set_sale_price( $row['Sale price'] );
	$product->set_featured( '1' === $row['Is featured?'] );
	$product->set_manage_stock( true );
	$product->set_stock_quantity( (int) $row['Stock'] );
	$product->set_category_ids( array( $category_id ) );
	$product->set_attributes( array( $origin ) );
	$product->set_image_id( la_unica_demo_image( $directory, $row['Images'] ) );
	if ( ! $product->save() ) {
		throw new RuntimeException( __( 'WooCommerce no pudo guardar el producto.', 'multitienda-la-unica' ) );
	}
}

function la_unica_demo_image( $directory, $name ) {
	if ( ! preg_match( '/^la-unica-demo-[a-z-]+\.jpg$/D', $name ) ) {
		throw new RuntimeException( __( 'El nombre de la imagen de demostración no es válido.', 'multitienda-la-unica' ) );
	}
	$attachments = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'meta_key'       => '_la_unica_demo_image',
		'meta_value'     => $name,
	) );
	if ( $attachments && wp_attachment_is_image( $attachments[0] ) && is_file( get_attached_file( $attachments[0] ) ) ) {
		return (int) $attachments[0];
	}

	$file  = $directory . '/images/' . $name;
	$bytes = is_readable( $file ) ? file_get_contents( $file ) : false;
	if ( false === $bytes || 'image/jpeg' !== wp_get_image_mime( $file ) ) {
		throw new RuntimeException( __( 'Falta una imagen JPG válida en la carpeta del tema.', 'multitienda-la-unica' ) );
	}
	$upload = wp_upload_bits( $name, null, $bytes );
	if ( $upload['error'] ) {
		throw new RuntimeException( $upload['error'] );
	}

	$id = wp_insert_attachment( array(
		'post_title'     => pathinfo( $name, PATHINFO_FILENAME ),
		'post_mime_type' => 'image/jpeg',
		'post_status'    => 'inherit',
		'meta_input'     => array( '_la_unica_demo_image' => $name ),
	), $upload['file'], 0, true );
	if ( is_wp_error( $id ) || ! $id ) {
		wp_delete_file( $upload['file'] );
		la_unica_demo_check( $id );
		throw new RuntimeException( __( 'WordPress no pudo guardar la imagen en la biblioteca de medios.', 'multitienda-la-unica' ) );
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	return $id;
}
