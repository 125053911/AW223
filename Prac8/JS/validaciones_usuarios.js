// Valida el formulario de usuario antes de enviarlo
function validarUsuario(form) {
    const nombre  = form.nombre.value.trim();
    const paterno = form.apellido_paterno.value.trim();
    const correo  = form.correo.value.trim();
    const clave   = form.contrasena.value;

    if (nombre === "" || paterno === "" || correo === "" || clave === "") {
        alert("Nombre, apellido paterno, correo y contraseña son obligatorios.");
        return false;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
        alert("El correo no tiene un formato válido.");
        return false;
    }
    if (clave.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres.");
        return false;
    }
    if (form.id_rol.value === "") {
        alert("Selecciona un rol.");
        return false;
    }
    return true;
}

// Valida el formulario de equipo antes de enviarlo
function validarEquipo(form) {
    if (form.nombre_equipo.value.trim() === "" || form.descripcion.value.trim() === "") {
        alert("El nombre y la descripción del equipo son obligatorios.");
        return false;
    }
    return true;
}