const parametros= new URLSearchParams(window.location.search)
const estado= parametros.get("estadophp")

if (estado === "exito") {
    alert("Exito. Tu mensaje fue guardado.");
} else if (estado === "actualizado") {
    alert("Exito. El mensaje fue actualizado.");
} else if (estado === "borrado") {
    alert("El mensaje fue borrado.");
} else if (estado === "error") {
    alert("Algo fallo. Intentalo nuevamente.");
}

if (estado != null) {
    window.history.replaceState({}, document.title, window.location.pathname);
}