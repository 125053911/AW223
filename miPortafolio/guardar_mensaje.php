<?php
require_once("conexion.php");

// Evita que se abra el archivo directamente sin enviar el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página principal.");
}

$nombre  = trim($_POST["txtnombre"] ?? "");
$email   = trim($_POST["txtemail"] ?? "");
$mensaje = trim($_POST["txtmensaje"] ?? "");

$sqlInsert = "INSERT INTO mensajes (nombre, email, mensaje) VALUES (?, ?, ?)";

$stmt = $conexion->prepare($sqlInsert);
$stmt->bind_param("sss", $nombre, $email, $mensaje);

if ($stmt->execute()) {
    header("Location: index.php?estadophp=exito");
} else {
    header("Location: index.php?estadophp=error");
}

/* $stmt->close();
$conexion->close(); */
?>