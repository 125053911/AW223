<?php

require_once("conexion.php");

$nombre = $_POST["txtnombre"];
$email = $_POST["txtemail"];
$mensaje = $_POST["txtmensaje"];

/* Preparando la sentencia  */
$sqlInset = "INSERT INTO mensajes (nombre, email, mensaje) VALUES (?, ?, ?)";

/* Declaramos el statement y que necesita una conexión */
$stmt = $conexion->prepare($sqlInset);

/* Le damos los parametros al statement  */
$stmt->bind_param("sss", $nombre, $email, $mensaje);

if ($stmt->execute()) {
    echo "Mensaje guardado.";
} else {
    echo "Error al guardar el mensaje: ";
}