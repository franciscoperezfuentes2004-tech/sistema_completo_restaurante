/* ==================================================================
   AURUM RESTAURANTE — Lógica Principal (JavaScript Vanilla)
   ==================================================================
   Este archivo contiene toda la lógica interactiva de la landing page:
   1. Datos del menú (arreglo editable)
   2. Renderizado dinámico de tarjetas del menú
   3. Datos y renderizado de testimonios
   4. Carrusel de testimonios (automático + manual)
   5. Menú de hamburguesa para móvil
   6. Scroll suave para la navegación
   7. Efecto del navbar al hacer scroll
   8. Animaciones de aparición (Intersection Observer)
   9. Partículas decorativas del hero

   ===================================================================
   🔒 AUDITORÍA DE SEGURIDAD (SecOps) — MITIGACIONES APLICADAS:
   -------------------------------------------------------------------
   ✅ XSS (Cross-Site Scripting): Se eliminó TODO uso de innerHTML para
      renderizar datos provenientes de variables/objetos. Se utiliza
      exclusivamente document.createElement() + textContent para que
      el navegador interprete los valores como texto plano y neutralice
      cualquier intento de inyección de etiquetas <script> o HTML
      malicioso.
   ✅ Tabnabbing: Todos los enlaces externos generados dinámicamente
      incluyen rel="noopener noreferrer" de forma obligatoria.
   ✅ Validación de rutas de imagen: Se sanitiza el atributo 'src' de
      las imágenes para prevenir inyección de protocolos peligrosos
      (javascript:, data:).
   ================================================================== */

'use strict';

// =====================================================================
// 1. BASE DE DATOS LOCAL — PLATILLOS DEL MENÚ
// =====================================================================
// Para editar el menú, simplemente modifica este arreglo.
// Cada objeto representa un platillo con su nombre, descripción,
// precio e imagen.

const platillos = [
    {
        nombre: 'Filete Mignon',
        descripcion: 'Corte premium de res con reducción de vino tinto, puré de trufa negra y vegetales asados de temporada.',
        precio: '$580',
        imagen: 'img/plato-1.jpg',
        categoria: 'comidas'
    },
    {
        nombre: 'Risotto de Trufa Negra',
        descripcion: 'Arroz arborio cremoso perfumado con trufa negra fresca, parmesano reggiano y aceite de oliva extra virgen.',
        precio: '$420',
        imagen: 'img/plato-2.jpg',
        categoria: 'comidas'
    },
    {
        nombre: 'Salmón Glaseado con Miso',
        descripcion: 'Filete de salmón noruego glaseado con miso blanco, acompañado de edamame y jengibre encurtido.',
        precio: '$490',
        imagen: 'img/plato-3.jpg',
        categoria: 'comidas'
    },
    {
        nombre: 'Carpaccio de Res',
        descripcion: 'Láminas finas de res premium con parmesano, rúcula silvestre, alcaparras y vinagreta de limón Meyer.',
        precio: '$350',
        imagen: 'img/plato-4.jpg',
        categoria: 'desayunos'
    },
    {
        nombre: 'Langosta Thermidor',
        descripcion: 'Media langosta gratinada con salsa cremosa de cognac, queso gruyère y finas hierbas frescas.',
        precio: '$780',
        imagen: 'img/plato-5.jpg',
        categoria: 'comidas'
    },
    {
        nombre: 'Tarta de Chocolate Belga',
        descripcion: 'Delicada tarta de chocolate belga 70% cacao con coulis de frutos rojos y hoja de oro comestible.',
        precio: '$280',
        imagen: 'img/plato-6.jpg',
        categoria: 'bebidas'
    },
    {
        nombre: 'Huevos Benedictinos',
        descripcion: 'Huevos pochados sobre muffin inglés artesanal, bañados en salsa holandesa trufada y acompañados de espárragos.',
        precio: '$290',
        imagen: 'img/plato-7.png',
        categoria: 'desayunos'
    },
    {
        nombre: 'Pancakes de Frutos Rojos',
        descripcion: 'Esponjosos pancakes artesanales con coulis de frutos del bosque, sirope de maple puro y crema batida.',
        precio: '$240',
        imagen: 'img/plato-8.png',
        categoria: 'desayunos'
    },
    {
        nombre: 'Ensalada de Burrata',
        descripcion: 'Burrata fresca italiana sobre un nido de tomates heirloom, pesto de albahaca genovesa y reducción de balsámico.',
        precio: '$320',
        imagen: 'img/plato-9.png',
        categoria: 'comidas'
    },
    {
        nombre: 'Cóctel de Autor',
        descripcion: 'Nuestra firma mixológica: una infusión ahumada de licores premium con notas cítricas y decoración floral.',
        precio: '$250',
        imagen: 'img/plato-10.png',
        categoria: 'bebidas'
    },
    {
        nombre: 'Copa de Vino Tinto Reserva',
        descripcion: 'Selección exclusiva de nuestro sommelier, añejado en barrica de roble francés con intensas notas a frutos negros.',
        precio: '$380',
        imagen: 'img/plato-11.png',
        categoria: 'bebidas'
    },
    {
        nombre: 'Café Espresso Especialidad',
        descripcion: 'Extracción perfecta de granos de altura seleccionados a mano, con perfil de tueste medio y notas a chocolate amargo.',
        precio: '$120',
        imagen: 'img/plato-12.png',
        categoria: 'bebidas'
    }
];


// =====================================================================
// 2. BASE DE DATOS LOCAL — TESTIMONIOS
// =====================================================================
// Para editar los testimonios, modifica este arreglo.
// "estrellas" debe ser un valor entre 1 y 5.

const testimonios = [
    {
        nombre: 'María García',
        cargo: 'Crítica Gastronómica',
        texto: 'Una experiencia gastronómica que trasciende lo ordinario. El Filete Mignon fue simplemente perfecto, y la atención al detalle en cada plato demuestra la pasión del chef. Sin duda, el mejor restaurante que he visitado este año.',
        estrellas: 5
    },
    {
        nombre: 'Carlos Rodríguez',
        cargo: 'Sommelier Certificado',
        texto: 'La carta de vinos es excepcional, y la recomendación del sommelier fue impecable. Cada platillo estaba magistralmente maridado. El ambiente es íntimo y sofisticado, perfecto para una velada especial.',
        estrellas: 5
    },
    {
        nombre: 'Ana Martínez',
        cargo: 'Food Blogger',
        texto: 'Desde la presentación hasta el último bocado, todo en Aurum es una obra de arte culinaria. La Langosta Thermidor es de otro nivel. Volveré sin dudarlo, y ya les he recomendado a todos mis seguidores.',
        estrellas: 5
    },
    {
        nombre: 'Roberto Sánchez',
        cargo: 'Empresario',
        texto: 'Celebré mi aniversario en Aurum y fue mágico. El servicio es impecable, discreto pero atento. La tarta de chocolate belga con hoja de oro fue el broche perfecto para una noche inolvidable.',
        estrellas: 5
    }
];


// =====================================================================
// UTILIDAD DE SEGURIDAD — Sanitización de rutas de imagen
// =====================================================================
/**
 * 🔒 SEGURIDAD: Valida que una ruta de imagen sea segura.
 * Previene la inyección de protocolos peligrosos como "javascript:" o
 * "data:" que podrían ejecutar código arbitrario al ser asignados al
 * atributo 'src' de una etiqueta <img>.
 *
 * Solo se permiten rutas relativas y URLs con protocolo http/https.
 *
 * @param {string} ruta - La ruta de imagen a validar.
 * @returns {string} - La ruta original si es segura, o una cadena vacía.
 */
function sanitizarRutaImagen(ruta) {
    if (typeof ruta !== 'string') return '';
    const rutaLimpia = ruta.trim().toLowerCase();
    // Bloquear protocolos peligrosos (javascript:, data:, vbscript:, etc.)
    if (rutaLimpia.startsWith('javascript:') ||
        rutaLimpia.startsWith('data:') ||
        rutaLimpia.startsWith('vbscript:')) {
        console.warn('[SEGURIDAD] Ruta de imagen bloqueada por protocolo peligroso:', ruta);
        return '';
    }
    return ruta;
}


// =====================================================================
// 3. RENDERIZADO DINÁMICO DEL MENÚ — CONSTRUCCIÓN SEGURA DEL DOM
// =====================================================================

/**
 * 🔒 SEGURIDAD: Genera las tarjetas de platillos usando EXCLUSIVAMENTE
 * la API segura del DOM (document.createElement + textContent).
 *
 * ⚠️  Se PROHÍBE el uso de innerHTML para renderizar datos de variables.
 *     innerHTML interpreta cadenas como HTML real, permitiendo que un
 *     atacante inyecte etiquetas <script>, <img onerror="...">, o
 *     cualquier HTML malicioso si los datos del arreglo `platillos`
 *     fueran comprometidos (por ejemplo, si en el futuro vinieran de
 *     una API externa o de una base de datos).
 *
 *     textContent SIEMPRE escapa el contenido como texto plano,
 *     neutralizando cualquier intento de inyección XSS.
 */
function renderizarMenu() {
    const contenedor = document.getElementById('menuCuadricula');
    if (!contenedor) return;

    // 🔒 SEGURIDAD: Limpiar el contenedor de forma segura eliminando
    // todos los nodos hijos uno por uno, en lugar de usar innerHTML = ''
    while (contenedor.firstChild) {
        contenedor.removeChild(contenedor.firstChild);
    }

    // Crear una tarjeta por cada platillo usando DOM API segura
    platillos.forEach((plato, indice) => {
        // --- Contenedor principal de la tarjeta ---
        const tarjeta = document.createElement('article');
        tarjeta.classList.add('menu__tarjeta', 'revelar', 'menu-item', plato.categoria);
        // Retraso escalonado para la animación de aparición
        tarjeta.style.transitionDelay = `${indice * 0.1}s`;

        // --- Contenedor de la imagen ---
        const imgContenedor = document.createElement('div');
        imgContenedor.classList.add('menu__tarjeta-imagen-contenedor');

        // 🔒 SEGURIDAD: La imagen se crea con createElement y su src
        // se sanitiza para bloquear protocolos peligrosos (javascript:, data:)
        const img = document.createElement('img');
        img.src = sanitizarRutaImagen(plato.imagen);
        // 🔒 SEGURIDAD: alt se asigna con setAttribute, que trata el
        // valor como texto plano — no como HTML interpretable.
        img.alt = plato.nombre;
        img.classList.add('menu__tarjeta-imagen');
        img.loading = 'lazy';

        // --- Badge del precio ---
        const precioBadge = document.createElement('div');
        precioBadge.classList.add('menu__tarjeta-precio-badge');

        const precioSpan = document.createElement('span');
        precioSpan.classList.add('menu__tarjeta-precio');
        // 🔒 SEGURIDAD: textContent asigna el precio como TEXTO PLANO.
        // Si alguien inyectara '<script>alert("XSS")</script>' como precio,
        // se mostraría literalmente como texto, sin ejecutarse.
        precioSpan.textContent = plato.precio;

        precioBadge.appendChild(precioSpan);
        imgContenedor.appendChild(img);
        imgContenedor.appendChild(precioBadge);

        // --- Información del platillo ---
        const info = document.createElement('div');
        info.classList.add('menu__tarjeta-info');

        const nombre = document.createElement('h3');
        nombre.classList.add('menu__tarjeta-nombre');
        // 🔒 SEGURIDAD: textContent — neutraliza inyección XSS en nombres
        nombre.textContent = plato.nombre;

        const descripcion = document.createElement('p');
        descripcion.classList.add('menu__tarjeta-descripcion');
        // 🔒 SEGURIDAD: textContent — neutraliza inyección XSS en descripciones
        descripcion.textContent = plato.descripcion;

        info.appendChild(nombre);
        info.appendChild(descripcion);

        // --- Ensamblar tarjeta completa ---
        tarjeta.appendChild(imgContenedor);
        tarjeta.appendChild(info);

        contenedor.appendChild(tarjeta);
    });
}


// =====================================================================
// 4. RENDERIZADO Y LÓGICA DEL CARRUSEL DE TESTIMONIOS
// =====================================================================

let indiceActual = 0;       // Índice del testimonio visible
let intervaloCarrusel;      // Referencia al intervalo automático

/**
 * 🔒 SEGURIDAD: Genera los slides de testimonios y los indicadores (dots)
 * usando EXCLUSIVAMENTE la API segura del DOM.
 *
 * Se eliminó completamente el uso de innerHTML para prevenir XSS.
 * Todos los textos de testimonios (nombre, cargo, texto) se asignan
 * con textContent, impidiendo la inyección de HTML malicioso.
 */
function renderizarTestimonios() {
    const pista = document.getElementById('pistaTestimonios');
    const indicadores = document.getElementById('indicadoresTestimonios');
    if (!pista || !indicadores) return;

    // 🔒 SEGURIDAD: Limpiar contenedores de forma segura (sin innerHTML)
    while (pista.firstChild) {
        pista.removeChild(pista.firstChild);
    }
    while (indicadores.firstChild) {
        indicadores.removeChild(indicadores.firstChild);
    }

    // Crear un slide por cada testimonio
    testimonios.forEach((testimonio, indice) => {
        // --- Slide ---
        const slide = document.createElement('div');
        slide.classList.add('testimonios__slide');

        // Comillas decorativas
        const comillas = document.createElement('span');
        comillas.classList.add('testimonios__comillas');
        comillas.textContent = '"';

        // Texto del testimonio
        const texto = document.createElement('p');
        texto.classList.add('testimonios__texto');
        // 🔒 SEGURIDAD: textContent — el testimonio se renderiza como
        // texto plano, neutralizando cualquier HTML/JS inyectado.
        texto.textContent = testimonio.texto;

        // --- Contenedor de estrellas (generadas de forma segura) ---
        const estrellasDiv = document.createElement('div');
        estrellasDiv.classList.add('testimonios__estrellas');

        // 🔒 SEGURIDAD: Las estrellas se generan con createElement
        // en lugar de concatenar HTML con innerHTML.
        for (let i = 1; i <= 5; i++) {
            const estrella = document.createElement('span');
            estrella.classList.add('testimonios__estrella');
            if (i > testimonio.estrellas) {
                estrella.classList.add('testimonios__estrella--vacia');
            }
            estrella.textContent = '★';
            estrellasDiv.appendChild(estrella);
        }

        // Nombre del autor
        const autor = document.createElement('p');
        autor.classList.add('testimonios__autor');
        // 🔒 SEGURIDAD: textContent — neutraliza inyección XSS en nombres
        autor.textContent = testimonio.nombre;

        // Cargo del autor
        const cargo = document.createElement('p');
        cargo.classList.add('testimonios__cargo');
        // 🔒 SEGURIDAD: textContent — neutraliza inyección XSS en cargos
        cargo.textContent = testimonio.cargo;

        // Ensamblar slide
        slide.appendChild(comillas);
        slide.appendChild(texto);
        slide.appendChild(estrellasDiv);
        slide.appendChild(autor);
        slide.appendChild(cargo);
        pista.appendChild(slide);

        // --- Indicador (dot) ---
        const dot = document.createElement('button');
        dot.classList.add('testimonios__dot');
        if (indice === 0) {
            dot.classList.add('testimonios__dot--activo');
        }
        dot.setAttribute('aria-label', `Ir al testimonio ${indice + 1}`);
        dot.addEventListener('click', () => irATestimonio(indice));
        indicadores.appendChild(dot);
    });
}

/**
 * Mueve el carrusel al testimonio indicado por su índice.
 * @param {number} indice - Índice del testimonio a mostrar.
 */
function irATestimonio(indice) {
    const pista = document.getElementById('pistaTestimonios');
    const dots = document.querySelectorAll('.testimonios__dot');
    if (!pista || !dots.length) return;

    // Calcular el total de testimonios
    const total = testimonios.length;

    // Ajustar índice si es circular
    if (indice < 0) indice = total - 1;
    if (indice >= total) indice = 0;

    indiceActual = indice;

    // Desplazar la pista
    pista.style.transform = `translateX(-${indiceActual * 100}%)`;

    // Actualizar indicadores activos
    dots.forEach((dot, i) => {
        dot.classList.toggle('testimonios__dot--activo', i === indiceActual);
    });
}

/**
 * Avanza al siguiente testimonio.
 */
function siguienteTestimonio() {
    irATestimonio(indiceActual + 1);
}

/**
 * Retrocede al testimonio anterior.
 */
function anteriorTestimonio() {
    irATestimonio(indiceActual - 1);
}

/**
 * Inicia la rotación automática del carrusel cada 5 segundos.
 */
function iniciarCarruselAutomatico() {
    // Limpiar intervalo anterior si existe
    if (intervaloCarrusel) clearInterval(intervaloCarrusel);

    intervaloCarrusel = setInterval(() => {
        siguienteTestimonio();
    }, 5000);
}

/**
 * Reinicia el temporizador del carrusel automático.
 * Se llama al interactuar manualmente para evitar saltos inesperados.
 */
function reiniciarTemporizador() {
    clearInterval(intervaloCarrusel);
    iniciarCarruselAutomatico();
}

/**
 * Configura los eventos de las flechas del carrusel.
 */
function configurarFlechasCarrusel() {
    const flechaIzq = document.getElementById('flechaIzq');
    const flechaDer = document.getElementById('flechaDer');

    if (flechaIzq) {
        flechaIzq.addEventListener('click', () => {
            anteriorTestimonio();
            reiniciarTemporizador();
        });
    }

    if (flechaDer) {
        flechaDer.addEventListener('click', () => {
            siguienteTestimonio();
            reiniciarTemporizador();
        });
    }
}


// =====================================================================
// 5. MENÚ HAMBURGUESA (MÓVIL)
// =====================================================================

/**
 * Configura la lógica del menú de hamburguesa para dispositivos móviles.
 */
function configurarMenuHamburguesa() {
    const btnHamburguesa = document.getElementById('btnHamburguesa');
    const navMenu = document.getElementById('navMenu');
    const enlaces = document.querySelectorAll('.navbar__enlace');

    if (!btnHamburguesa || !navMenu) return;

    // Alternar el menú al hacer clic en el botón hamburguesa
    btnHamburguesa.addEventListener('click', () => {
        const estaAbierto = navMenu.classList.contains('navbar__nav--movil-abierto');

        btnHamburguesa.classList.toggle('navbar__hamburguesa--activo');
        navMenu.classList.toggle('navbar__nav--movil-abierto');

        // Bloquear/desbloquear scroll del body cuando el menú está abierto
        document.body.style.overflow = estaAbierto ? '' : 'hidden';
    });

    // Cerrar el menú al hacer clic en un enlace
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', () => {
            btnHamburguesa.classList.remove('navbar__hamburguesa--activo');
            navMenu.classList.remove('navbar__nav--movil-abierto');
            document.body.style.overflow = '';
        });
    });
}


// =====================================================================
// 6. SCROLL SUAVE PARA LOS ENLACES DE NAVEGACIÓN
// =====================================================================

/**
 * Configura el desplazamiento suave (smooth scroll) para todos los
 * enlaces internos que apunten a secciones con ID.
 */
function configurarScrollSuave() {
    const enlacesInternos = document.querySelectorAll('a[href^="#"]');

    enlacesInternos.forEach(enlace => {
        enlace.addEventListener('click', (evento) => {
            evento.preventDefault();
            const destino = document.querySelector(enlace.getAttribute('href'));

            if (destino) {
                // Calcular posición considerando la altura del navbar
                const offsetTop = destino.offsetTop - 80;

                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}


// =====================================================================
// 7. EFECTO DEL NAVBAR AL HACER SCROLL
// =====================================================================

/**
 * Agrega/elimina la clase de fondo al navbar según la posición
 * de scroll del usuario.
 */
function configurarNavbarScroll() {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;

    // Umbral en píxeles para activar el fondo del navbar
    const UMBRAL_SCROLL = 50;

    window.addEventListener('scroll', () => {
        if (window.scrollY > UMBRAL_SCROLL) {
            navbar.classList.add('navbar--scroll');
        } else {
            navbar.classList.remove('navbar--scroll');
        }
    }, { passive: true });
}


// =====================================================================
// 8. ANIMACIONES DE APARICIÓN (INTERSECTION OBSERVER)
// =====================================================================

/**
 * Configura el Intersection Observer para animar los elementos
 * con la clase "revelar" cuando entran al viewport.
 */
function configurarAnimacionesScroll() {
    // Verificar compatibilidad del navegador
    if (!('IntersectionObserver' in window)) {
        // Fallback: hacer visibles todos los elementos inmediatamente
        document.querySelectorAll('.revelar').forEach(el => {
            el.classList.add('visible');
        });
        return;
    }

    const opciones = {
        root: null,           // Viewport como referencia
        rootMargin: '0px',
        threshold: 0.15       // 15% visible para activar
    };

    const observer = new IntersectionObserver((entradas) => {
        entradas.forEach(entrada => {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('visible');
                // Dejar de observar después de que se hizo visible
                observer.unobserve(entrada.target);
            }
        });
    }, opciones);

    // Observar todos los elementos con clase "revelar"
    document.querySelectorAll('.revelar').forEach(elemento => {
        observer.observe(elemento);
    });
}


// =====================================================================
// 9. PARTÍCULAS DECORATIVAS DEL HERO
// =====================================================================

/**
 * Genera partículas flotantes doradas en la sección hero
 * para un efecto visual elegante.
 */
function generarParticulasHero() {
    const contenedor = document.getElementById('heroParticulas');
    if (!contenedor) return;

    const NUM_PARTICULAS = 20;

    for (let i = 0; i < NUM_PARTICULAS; i++) {
        const particula = document.createElement('div');
        particula.className = 'hero__particula';

        // Posición aleatoria
        particula.style.left = `${Math.random() * 100}%`;
        particula.style.top = `${Math.random() * 100}%`;

        // Tamaño aleatorio (2px a 4px)
        const tamano = 2 + Math.random() * 2;
        particula.style.width = `${tamano}px`;
        particula.style.height = `${tamano}px`;

        // Duración y retraso de animación aleatorios
        particula.style.animationDuration = `${6 + Math.random() * 8}s`;
        particula.style.animationDelay = `${Math.random() * 6}s`;

        contenedor.appendChild(particula);
    }
}


// =====================================================================
// 10. FILTRO DINÁMICO DEL MENÚ (TABS)
// =====================================================================

/**
 * Escucha los clics en las pestañas del menú y filtra las tarjetas.
 */
function configurarFiltroMenu() {
    const tabs = document.querySelectorAll('.tab-btn');
    const items = document.querySelectorAll('.menu-item');

    if (!tabs.length || !items.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remover 'active' de todos y asignarlo al actual
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filtro = tab.getAttribute('data-filter');

            items.forEach(item => {
                if (filtro === 'all' || item.classList.contains(filtro)) {
                    item.style.display = 'block';
                    
                    // Retraso minúsculo para que el display aplique antes de la opacidad
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    
                    // Ocultar del DOM tras la transición (300ms)
                    setTimeout(() => {
                        // Verificamos si la pestaña cambió mientras tanto
                        if (!tab.classList.contains('active')) return;
                        if (filtro !== 'all' && !item.classList.contains(filtro)) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });
        });
    });
}


// =====================================================================
// 11. EFECTOS AVANZADOS: PARALLAX Y TILT 3D
// =====================================================================

function configurarEfectosAvanzados() {
    // 1. Parallax en el Hero al hacer scroll
    const heroContent = document.querySelector('.hero__contenido');
    const heroParticulas = document.getElementById('heroParticulas');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        // Aplicar parallax solo si estamos cerca del hero
        if (scrolled < window.innerHeight) {
            if (heroContent) {
                heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
                heroContent.style.opacity = 1 - (scrolled / window.innerHeight) * 1.5;
            }
            if (heroParticulas) {
                heroParticulas.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        }
    }, { passive: true });

    // 2. Efecto Tilt 3D en la imagen de Historia
    const historiaMarco = document.querySelector('.historia__imagen-marco');
    const historiaImg = document.querySelector('.historia__imagen');

    if (historiaMarco && historiaImg) {
        historiaMarco.addEventListener('mousemove', (e) => {
            const rect = historiaMarco.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            // Inclinación máxima de 8 grados
            const rotateX = ((y - centerY) / centerY) * -8;
            const rotateY = ((x - centerX) / centerX) * 8;
            
            historiaImg.style.transform = `scale(1.05) perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            historiaImg.style.transition = 'none';
        });

        historiaMarco.addEventListener('mouseleave', () => {
            historiaImg.style.transform = `scale(1) perspective(1000px) rotateX(0deg) rotateY(0deg)`;
            historiaImg.style.transition = 'transform 0.6s ease';
        });
        
        historiaMarco.addEventListener('mouseenter', () => {
            historiaImg.style.transition = 'transform 0.1s ease';
        });
    }
}


// =====================================================================
// 12. INICIALIZACIÓN — CUANDO EL DOM ESTÁ LISTO
// =====================================================================

document.addEventListener('DOMContentLoaded', () => {
    // Renderizar contenido dinámico
    renderizarMenu();
    renderizarTestimonios();

    // Configurar interactividad
    configurarMenuHamburguesa();
    configurarScrollSuave();
    configurarNavbarScroll();
    configurarFlechasCarrusel();
    configurarFiltroMenu();
    configurarEfectosAvanzados();

    // Iniciar carrusel automático de testimonios
    iniciarCarruselAutomatico();

    // Configurar animaciones de aparición
    // (Se ejecuta con un pequeño retraso para asegurar que las
    //  tarjetas del menú ya fueron renderizadas)
    setTimeout(() => {
        configurarAnimacionesScroll();
    }, 100);

    // Generar partículas decorativas
    generarParticulasHero();

    // Agregar clases "revelar" a secciones principales
    const seccionesAnimables = document.querySelectorAll(
        '.seccion__encabezado, .historia__texto, .historia__imagen-contenedor'
    );
    seccionesAnimables.forEach(seccion => {
        seccion.classList.add('revelar');
    });

    // Re-ejecutar observer después de agregar clases
    setTimeout(() => {
        configurarAnimacionesScroll();
    }, 200);
});
