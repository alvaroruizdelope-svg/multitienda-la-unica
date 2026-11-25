# Multitienda La Única

Tema de WordPress para la tienda de Multitienda La Única, desarrollado por AV CODE STUDIO. El tema aporta el diseño. WooCommerce gestiona el catálogo, el carrito, los clientes y los pedidos.

## Estructura

- `multitienda-la-unica/` es la carpeta del tema instalable.
- `style.css` identifica el tema y `functions.php` registra sus recursos e integración con WooCommerce.
- `front-page.php` contiene la portada. `header.php` y `footer.php` definen la cabecera y el pie. Las demás plantillas cubren las páginas y entradas de WordPress.
- `assets/css/`, `assets/js/` y `assets/images/` contienen estilos, navegación móvil e imágenes.

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

La carpeta `demo/` contiene el CSV y seis ilustraciones originales en formato JPG. La lata de cola lleva un diseño genérico. Los artículos se identifican con **[DEMO]** en el nombre y usan SKU que empiezan por `LUNICA-DEMO-`. Las imágenes, precios y existencias son de prueba.

Arranca Apache y MariaDB en XAMPP y entra en el escritorio de tu WordPress local (`http://localhost/wordpress-la-unica/wp-admin/`). Configura el atributo **Origen** y sube las imágenes a la biblioteca de medios antes de importar el CSV. El CSV deja los productos publicados y visibles en esa instalación para poder enseñar el catálogo, las ofertas y los destacados.

### Configurar el atributo Origen

1. Abre **Productos → Atributos**. Crea el atributo **Origen**, con slug `origen`, y marca **¿Activar archivos?**. Si ya existe con ese slug, edítalo o reutilízalo.
2. Pulsa **Configurar términos** y añade **España** con slug `espana` y **Colombia** con slug `colombia`. Reutiliza los términos si ya existen. Conserva los slugs para que la portada pueda encontrarlos.
3. El atributo representa una clasificación comercial del catálogo. No certifica el país de fabricación. Para cambiar la clasificación de un artículo, edita sus atributos en la ficha de producto.
4. La sección **Compra por origen** aparece en la portada cuando existe alguno de los términos. Con los archivos activos, las tarjetas llevan a los archivos de productos de cada término. Si un archivo devuelve un 404 tras activar la opción, guarda de nuevo **Ajustes → Enlaces permanentes**. También puedes usar el atributo en el bloque nativo **Filtro por atributo** si tu plantilla de catálogo admite bloques.

### Importar los seis productos

1. En el escritorio, entra en **Medios → Añadir nuevo archivo** y sube los seis JPG de `demo/images/`. Conserva los nombres de archivo originales. El CSV enlaza las imágenes por nombre en la biblioteca de medios. Si ya las subiste, reutilízalas para evitar sufijos como `-1`. No incluyas el logotipo en esta subida.
2. Ve a **Productos → Todos los productos → Importar** y selecciona `demo/productos-demostracion.csv`. Deja desmarcada la casilla **Actualizar productos existentes**. El importador omite los SKU que ya existen.
3. Pulsa **Continuar** y comprueba que WooCommerce ha asignado las columnas. Verifica **Images** y los cuatro campos **Attribute 1**, en especial **Attribute 1 global**. El CSV usa comas y está en UTF-8.
4. Ejecuta el importador. En una primera importación, comprueba que se han creado seis productos. En **Productos**, busca `LUNICA-DEMO-` y abre una ficha para revisar foto, precio, stock, categoría y atributo **Origen**.
5. En la portada, entra en **Productos españoles** y **Productos colombianos**. De los artículos de prueba, cada grupo debe contener tres. Revisa también **Compra por categorías**, **Ofertas destacadas** y **Productos destacados**.

La carpeta que se copia a `themes/` sigue siendo solo `multitienda-la-unica/`. Conserva `demo/` en la carpeta descomprimida para subir los archivos desde el escritorio de WordPress.
