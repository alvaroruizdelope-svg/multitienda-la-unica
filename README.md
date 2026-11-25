# Multitienda La Única

Tema de WordPress para la tienda de Multitienda La Única, desarrollado por AV CODE STUDIO. El tema aporta el diseño. WooCommerce gestiona el catálogo, el carrito, los clientes y los pedidos.

## Estructura

- `multitienda-la-unica/` es la carpeta del tema instalable.
- `style.css` identifica el tema y `functions.php` registra sus recursos e integración con WooCommerce.
- `front-page.php` contiene la portada. `header.php` y `footer.php` definen la cabecera y el pie. Las demás plantillas cubren las páginas y entradas de WordPress.
- `assets/css/`, `assets/js/` y `assets/images/` contienen estilos, navegación móvil e imágenes.
- `inc/demo-importer.php` añade el importador al escritorio. `demo/`, dentro del tema, contiene el CSV y las seis ilustraciones.

## Instalación en XAMPP

1. Abre el repositorio en GitHub y selecciona **Code → Download ZIP**. Descomprime el archivo. Si los cambios se entregan mediante una pull request, fusiónala en `main` antes de descargar.
2. Copia la carpeta interior `multitienda-la-unica`, la que contiene `style.css`, en `C:\xampp\htdocs\wordpress-la-unica\wp-content\themes\`. Comprueba que `style.css` quede directamente dentro de `themes\multitienda-la-unica\`.
3. El ZIP incluye el logotipo original en `multitienda-la-unica/assets/images/logo-la-unica.png`. Al copiar la carpeta completa del tema, la cabecera lo carga automáticamente.
4. Arranca Apache y MariaDB desde XAMPP. Abre el escritorio del WordPress existente, entra en **Apariencia → Temas** y activa **Multitienda La Única**.
5. Comprueba en **Plugins** que WooCommerce esté activo y que sus páginas de tienda, carrito, finalizar compra y mi cuenta estén asignadas. En **Ajustes → Generales**, selecciona **Español** como idioma del sitio.
6. El menú principal funciona al activar el tema. Para personalizarlo, asigna un menú a la ubicación **Menú principal** en **Apariencia → Menús**. Cuando estén listas las páginas de contacto y políticas, añade sus enlaces al **Menú de información y políticas**.

## Comprobación

1. Abre la dirección habitual de tu tienda local. Comprueba que la portada, el logotipo y los enlaces de cabecera cargan.
2. Si el catálogo está vacío, verifica los mensajes de categorías, ofertas y destacados. Cuando haya contenido de prueba, comprueba que un producto con rebaja activa salga en ofertas y que otro marcado con la estrella de WooCommerce aparezca en destacados.
3. Busca un producto, abre su ficha, añádelo al carrito y cambia su cantidad. Comprueba que el contador se actualiza y que puedes abrir el carrito, la finalización de compra y Mi cuenta. No hace falta completar un pedido.
4. Prueba la navegación con teclado y en 320, 390, 768, 1024 y 1440 píxeles de ancho, usando el modo adaptable del navegador si lo necesitas.

## Actualizaciones

Descarga la versión nueva y reemplaza la carpeta del tema por la del ZIP. Guarda primero una copia de la carpeta instalada. Reactiva el tema si WordPress lo solicita y repite las comprobaciones. Los productos y pedidos siguen en tu instalación de WordPress.

## Demostración de la fase 2

Después de copiar la carpeta completa y activar el tema en tu WordPress local de XAMPP:

1. Abre **WooCommerce → Demostración La Única** con una cuenta de administración de la tienda.
2. Pulsa **Importar productos de demostración**. WordPress incorpora las imágenes a la biblioteca y WooCommerce crea los productos, las categorías y el atributo global **Origen** según haga falta. El resumen indica cuántos productos se han creado u omitido y si hubo algún error.
3. Abre la portada y comprueba **Compra por origen**, **Ofertas destacadas** y **Productos destacados**. Busca `LUNICA-DEMO-` en **Productos** para revisar las seis fichas.

En una instalación nueva, la importación crea seis artículos visibles con **[DEMO]** en el nombre. Las ilustraciones, los precios y las existencias son de prueba. **Origen** es una clasificación comercial editable en **Productos → Atributos**. Los slugs `origen`, `espana` y `colombia` enlazan el atributo con la portada. Si los archivos de origen devuelven un 404 tras importar, vuelve a guardar **Ajustes → Enlaces permanentes**.

La activación y las actualizaciones del tema no ejecutan el importador. Si vuelves a pulsar el botón, el importador omite los SKU existentes y crea solo los que falten. El CSV y las imágenes ya viajan dentro de la carpeta del tema, por lo que basta con copiar esa carpeta.
