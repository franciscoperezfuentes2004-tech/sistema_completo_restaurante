# 🌟 Plantilla Premium: Aurum Restaurante

¡Hola y bienvenido(a)! 🎉 Te felicitamos por haber adquirido la plantilla web **Aurum Restaurante**. Has dado un paso enorme para elevar la presencia digital de tu negocio gastronómico con un diseño ultra moderno, elegante y de primer nivel.

Esta plantilla está construida con tecnologías web nativas (HTML5, CSS3 y JavaScript Vanilla), lo que significa que es increíblemente rápida, 100% responsiva (Mobile-First) y muy fácil de editar.

> 💡 **Nota Importante:** ¡No necesitas bases de datos, PHP ni servidores complejos! Esta plantilla es completamente estática, lo que significa que puedes alojarla **completamente gratis** en plataformas modernas como Vercel o Netlify en cuestión de segundos.

---

## 🛠️ Guía de Personalización Detallada

Hemos diseñado esta plantilla para que actualizar tu información sea rápido y seguro. A continuación, te detallamos exactamente en qué archivo y en qué número de línea debes realizar los cambios principales.

### 🏷️ Nombre de la Página y SEO
* **Archivo:** `index.html`
* **Líneas aproximadas:** `8 - 11`

Para que tu restaurante aparezca correctamente en Google y en la pestaña del navegador, edita las siguientes etiquetas dentro de la sección `<head>`:

```html
<!-- ========== SEO & META ========== -->
<title>Aurum | Restaurante de Alta Cocina</title> <!-- Cambia "Aurum" por el nombre de tu restaurante -->
<meta name="description" content="Descubre Aurum, una experiencia..."> <!-- Escribe una breve descripción atractiva -->
<meta name="keywords" content="restaurante, alta cocina, gastronomía...">
<meta name="author" content="Tu Nombre o Restaurante">
```

### 📱 Enlace de Reserva a WhatsApp
* **Archivo:** `index.html`
* **Líneas aproximadas:** `45` (Botón Navbar) y `323` (Botón Flotante), y `274` (Footer)

Para que los clientes te contacten directamente a tu WhatsApp, reemplaza el enlace base por el tuyo. El formato correcto es `https://wa.me/` seguido de tu código de país y número (sin signos `+` ni espacios).

```html
<!-- Ejemplo del Botón en el Navbar -->
<a href="https://wa.me/5215512345678?text=Hola%2C%20me%20gustar%C3%ADa%20hacer%20una%20reservaci%C3%B3n" class="navbar__btn-reservar" target="_blank" rel="noopener noreferrer">
```
*Tip: El texto después de `?text=` es el mensaje predeterminado. Usa `%20` para los espacios.*

### 🗂️ Datos del Menú Destacado (Precios, Títulos y Descripciones)
* **Archivo:** `script.js`
* **Líneas aproximadas:** `25 - 62`

¡Olvídate de buscar entre cientos de líneas de HTML! Los datos de tus platillos están organizados limpiamente en un "arreglo" de JavaScript. Solo modifica los textos entre las comillas simples `''`.

```javascript
const platillos = [
    {
        nombre: 'Filete Mignon', // Cambia el nombre aquí
        descripcion: 'Corte premium de res con reducción de vino tinto...', // Cambia la descripción
        precio: '$580', // Cambia el precio
        imagen: 'img/plato-1.jpg' // Asegúrate de que esta ruta coincida con tu foto
    },
    // ... otros platillos
];
```

### 🖼️ Reemplazo de Imágenes
* **Carpeta:** `/img`

Para cambiar las fotos de los platillos, el interior del restaurante o el fondo del inicio (Hero), simplemente reemplaza los archivos dentro de la carpeta `img`. 
* **La forma más fácil:** Nombra tus nuevas fotos exactamente igual que las originales (ej. `plato-1.jpg`, `historia.jpg`) y arrástralas para sobreescribir las viejas.
* **Alternativa:** Guarda tus fotos con nombres nuevos (ej. `mi-pizza.jpg`) y actualiza la ruta `imagen: 'img/mi-pizza.jpg'` en el archivo `script.js` (como se muestra en el paso anterior).

### 🔗 Redes Sociales y Contacto
* **Archivo:** `index.html`
* **Líneas aproximadas:** `242 - 256` (Iconos de Redes) y `268 - 280` (Datos de contacto)

En el pie de página (Footer), reemplaza los enlaces de marcador de posición con las URLs reales de tus perfiles:

```html
<!-- Ejemplo: Instagram -->
<a href="https://www.instagram.com/tu_usuario_aqui/" class="footer__red" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
```

---

## 🔒 Apartado de Seguridad Integrada

Tu plantilla ya viene fortificada desde el primer día. Hemos incluido un archivo detallado llamado `SEGURIDAD.md` en la raíz de tu proyecto. 

Como adelanto, te informamos que el sistema está blindado nativamente contra vulnerabilidades **XSS (Cross-Site Scripting)**. Al renderizar el menú y los testimonios desde el archivo `script.js`, utilizamos métodos modernos y seguros del DOM (como `textContent`) en lugar del peligroso `innerHTML`, garantizando que cualquier dato inyectado maliciosamente sea tratado como texto inofensivo. Además, todos los enlaces externos están protegidos contra técnicas de suplantación como el *Tabnabbing*.

---

## 🌐 Cómo Subir la Web en 1 Minuto (Despliegue Gratuito)

Como esta es una web estática optimizada, no necesitas pagar un hosting tradicional. Puedes publicarla mundialmente de forma gratuita usando **Vercel**. ¡Sigue estos sencillos pasos!

1. Crea una cuenta gratuita en [Vercel](https://vercel.com/signup).
2. Una vez en tu panel principal (Dashboard), haz clic en el botón negro **"Add New..."** y selecciona **"Project"**.
3. No es necesario conectar GitHub. Simplemente busca la opción en pantalla que dice **"Drag and drop your project directory here"** (Arrastra y suelta el directorio de tu proyecto aquí).
4. Toma toda la carpeta de tu sitio web `Aurum Restaurante` desde tu computadora y **arrástrala** hacia ese recuadro.
5. Vercel procesará los archivos en un instante y publicará tu sitio.
6. ¡Listo! Vercel te dará un enlace seguro (HTTPS) que ya puedes compartir con todos tus clientes.

¡Mucho éxito con tu restaurante! 🥂 Si tienes dudas sobre cómo personalizar más a fondo la plantilla o necesitas escalar a un backend, no dudes en consultar a un especialista Frontend.
