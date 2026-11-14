// Muestra un alert según el resultado (?estado=...) y limpia la URL
const parametros = new URLSearchParams(window.location.search);
const estado = parametros.get("estado");

const mensajes = {
    guardado: "Éxito. El gasto fue registrado.",
    actualizado: "Éxito. El gasto fue actualizado.",
    campos_invalidos: "Revisa los campos: todos son obligatorios y el monto debe ser mayor que 0.",
    error: "Algo falló. Inténtalo nuevamente."
};

if (estado !== null) {
    if (mensajes[estado]) {
        alert(mensajes[estado]);
    }
    window.history.replaceState({}, document.title, window.location.pathname);
}

// Valida el formulario de gasto (registrar y editar) antes de enviarlo
function validarGasto(form) {
    const concepto  = form.elements["concepto-gasto"].value.trim();
    const monto     = form.elements["monto-gasto"].value.trim();
    const categoria = form.elements["categoria-gasto"].value.trim();

    if (concepto === "" || monto === "") {
        alert("El concepto y el monto son obligatorios.");
        return false;               // false = NO se envía el formulario
    }
    if (categoria === "") {
        alert("La categoría es obligatoria.");
        return false;
    }
    if (isNaN(monto) || Number(monto) <= 0) {
        alert("El monto debe ser mayor que 0.");
        return false;
    }
    return true;
}
