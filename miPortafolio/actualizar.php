<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página de edición.");
}

$id      = (int) ($_POST["id"] ?? 0);
$nombre  = trim($_POST["txtnombre"] ?? "");
$email   = trim($_POST["txtemail"] ?? "");
$mensaje = trim($_POST["txtmensaje"] ?? "");

// Validación en el servidor: no se permiten vacíos
if ($nombre === "" || $email === "" || $mensaje === "") {
    header("Location: editar.php?id=$id&estadophp=vacio");
    exit;
}

$stmt = $conexion->prepare(
    "UPDATE mensajes SET nombre = ?, email = ?, mensaje = ? WHERE id = ?"
);
$stmt->bind_param("sssi", $nombre, $email, $mensaje, $id);

$estado = $stmt->execute() ? "actualizado" : "error";

$stmt->close();
$conexion->close();

// Redirige al home para mostrar el alert de confirmación
header("Location: index.php?estadophp=$estado");
exit;