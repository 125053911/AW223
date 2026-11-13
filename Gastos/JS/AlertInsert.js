/* const parametros= new URLSearchParams(window.location.search)
const gasto= parametros.get("gasto")

if (gasto === "exito") {
    alert("Exito. Tu mensaje fue guardado.");
} else if (gasto === "error") {
    alert("Algo fallo. Intentalo nuevamente.");
}

if (gasto != null) {
    window.history.replaceState({}, document.title, window.location.pathname);
} */

    // Valida el formulario de libro (registrar y editar) antes de enviarlo
function validarLibro(form) {
    const concepto      = form.concepto.value.trim();
    const monto       = form.monto.value.trim();
    const categoria = form.categoria.value.trim();

    if (concepto === "" || monto === "") {
        alert("El concepto y el monto son obligatorios.");
        return false;               // false = NO se envía el formulario
    }
    if (categoria === "") {
        alert("La categoría es obligatoria.");
        return false;
    }
   /*  if (isNaN(monto) || monto < 1) {
        alert("El monto debe ser al menos 1.");
        return false;
    } */
    return true;
}

// Valida el formulario de préstamo
/* function validarPrestamo(form) {
    const alumno = form.nombre_alumno.value.trim();
    const correo = form.correo_alumno.value.trim();

    if (form.id_libro.value === "") {
        alert("Selecciona un libro.");
        return false;
    }
    if (alumno === "" || correo === "") {
        alert("El nombre y el correo del alumno son obligatorios.");
        return false;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
        alert("El correo no tiene un formato válido.");
        return false;
    }
    return true;
} */