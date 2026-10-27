<?php
require_once "conexion.php";

// Evita que se abra el archivo directamente sin enviar el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página de usuarios.");
}

$nombre  = trim($_POST["nombre"] ?? "");
$paterno = trim($_POST["apellido_paterno"] ?? "");
$materno = trim($_POST["apellido_materno"] ?? "");
$materno = $materno === "" ? null : $materno;
$correo  = trim($_POST["correo"] ?? "");
$clave   = $_POST["contrasena"] ?? "";
$idRol   = (int) ($_POST["id_rol"] ?? 0);

// Validación en el servidor
if ($nombre === "" || $paterno === "" || $correo === "" || strlen($clave) < 6 || $idRol <= 0) {
    header("Location: usuarios.php?estadophp=campos_invalidos");
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: usuarios.php?estadophp=correo_invalido");
    exit;
}

// La contraseña se guarda cifrada, nunca en texto plano
$hash = password_hash($clave, PASSWORD_DEFAULT);

try {
    $stmt = $conexion->prepare(
        "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, contrasena, id_rol)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssssi", $nombre, $paterno, $materno, $correo, $hash, $idRol);
    $stmt->execute();
    $stmt->close();
    $estado = "usuario_guardado";
} catch (mysqli_sql_exception $e) {
    // 1062 = correo repetido (UNIQUE). 1452 = el rol no existe (llave foránea).
    if ($e->getCode() === 1062) {
        $estado = "correo_duplicado";
    } elseif ($e->getCode() === 1452) {
        $estado = "rol_invalido";
    } else {
        $estado = "error";
    }
}

$conexion->close();

header("Location: usuarios.php?estadophp=$estado");
exit;