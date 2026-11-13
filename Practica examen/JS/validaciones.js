// Valida el formulario de libro (registrar y editar) antes de enviarlo
function validarLibro(form) {
    const titulo      = form.titulo.value.trim();
    const autor       = form.autor.value.trim();
    const existencias = parseInt(form.existencias.value, 10);

    if (titulo === "" || autor === "") {
        alert("El título y el autor son obligatorios.");
        return false;               // false = NO se envía el formulario
    }
    if (form.id_categoria.value === "") {
        alert("Selecciona una categoría.");
        return false;
    }
    if (isNaN(existencias) || existencias < 1) {
        alert("Las existencias deben ser al menos 1.");
        return false;
    }
    return true;
}

// Valida el formulario de préstamo
function validarPrestamo(form) {
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
}