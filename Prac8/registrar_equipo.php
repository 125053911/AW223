<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página de usuarios.");
}

$nombre      = trim($_POST["nombre_equipo"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$ubicacion   = trim($_POST["ubicacion"] ?? "");
$ubicacion   = $ubicacion === "" ? null : $ubicacion;

// Validación en el servidor
if ($nombre === "" || $descripcion === "") {
    header("Location: usuarios.php?estadophp=campos_invalidos");
    exit;
}

try {
    $stmt = $conexion->prepare(
        "INSERT INTO equipos (nombre_equipo, descripcion, ubicacion)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $nombre, $descripcion, $ubicacion);
    $stmt->execute();
    $stmt->close();
    $estado = "equipo_guardado";
} catch (mysqli_sql_exception $e) {
    $estado = "error";
}

$conexion->close();

header("Location: usuarios.php?estadophp=$estado");
exit;