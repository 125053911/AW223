const parametros = new URLSearchParams(window.location.search);
const estado = parametros.get("estadophp");

const mensajes = {
    libro_guardado:      "Éxito. El libro fue registrado.",
    libro_actualizado:   "Libro actualizado.",
    libro_borrado:       "Libro borrado.",
    libro_con_prestamos: "No se puede borrar: el libro tiene préstamos registrados.",
    prestamo_guardado:   "Éxito. El préstamo fue registrado.",
    prestamo_devuelto:   "El libro fue marcado como devuelto.",
    sin_existencias:     "Sin existencias.",
    campos_invalidos:    "Revisa los datos. Todos los campos son obligatorios.",
    correo_invalido:     "El correo no tiene un formato válido.",
    categoria_invalida:  "La categoría seleccionada no existe.",
    error:               "Algo falló. Inténtalo nuevamente."
};

if (estado !== null && mensajes[estado]) {
    alert(mensajes[estado]);
}

// Limpia el parámetro de la URL para que el aviso no se repita al recargar
if (estado !== null) {
    window.history.replaceState({}, document.title, window.location.pathname);
}