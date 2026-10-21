<?php
require_once "conexion.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $conexion->prepare("DELETE FROM mensajes WHERE id = ?");
$stmt->bind_param("i", $id);

$estado = $stmt->execute() ? "borrado" : "error";

$stmt->close();
$conexion->close();

// Regresa al admin para mostrar el alert
header("Location: admin.php?estadophp=$estado");
exit;