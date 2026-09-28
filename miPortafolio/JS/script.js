  /* a) CAMBIAR EL HTML DESDE JS
   Cambia el texto de bienvenida al presionar el botón */

const mensajeBienvenida = document.getElementById("mensaje-bienvenida");
const botonMensaje = document.getElementById("btn-mensaje");

const mensajes = [
    "¡Hola! Bienvenido a mi Portafolio ahora con JS",
    "Gracias por visitar mi sitio web",
    "Aquí encontrarás mis proyectos y habilidades",
    "Bienvenido a mi sitio web personal."
];

let indiceMensaje = -1;

botonMensaje.addEventListener("click", function () {
    indiceMensaje = (indiceMensaje + 1) % mensajes.length;
    mensajeBienvenida.textContent = mensajes[indiceMensaje];
});


   /* b) CAMBIAR EL CSS DESDE JS
   Cambia color y tipografía de las cajas de habilidades */

const habilidades = document.querySelectorAll(".lista-habilidades li");
const botonColor = document.getElementById("btn-color");
const botonFuente = document.getElementById("btn-fuente");

const colores = ["#ffc6eb", "#c6e2ff", "#d4f7c5", "#fff3b0", "#e0c6ff"];
const fuentes = [
    "Arial, Helvetica, sans-serif",
    "'Courier New', monospace",
    "Georgia, serif",
    "'Trebuchet MS', sans-serif",
    "'Comic Sans MS', cursive"
];

let indiceColor = 0;
let indiceFuente = 0;

botonColor.addEventListener("click", function () {
    indiceColor = (indiceColor + 1) % colores.length;

    habilidades.forEach(function (habilidad) {
        habilidad.style.backgroundColor = colores[indiceColor];
    });
});

botonFuente.addEventListener("click", function () {
    indiceFuente = (indiceFuente + 1) % fuentes.length;

    habilidades.forEach(function (habilidad) {
        habilidad.style.fontFamily = fuentes[indiceFuente];
    });
});


   /* c) VALIDACIÓN DEL FORMULARIO
   Nombre y correo obligatorios, con mensajes personalizados */

const formulario = document.getElementById("formulario");
const campoNombre = document.getElementById("nombre");
const campoCorreo = document.getElementById("email");

formulario.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const nombre = campoNombre.value.trim();
    const correo = campoCorreo.value.trim();

    if (nombre === "") {
        alert("Por favor, escribe tu nombre");
        campoNombre.focus();
        return;
    }

    if (correo === "") {
        alert("El correo es obligatorio");
        campoCorreo.focus();
        return;
    }

    const formatoCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!formatoCorreo.test(correo)) {
        alert("Escribe un correo válido, por ejemplo: ejemplo@correo.com");
        campoCorreo.focus();
        return;
    }

    alert("Formulario enviado correctamente");
    formulario.reset();
});