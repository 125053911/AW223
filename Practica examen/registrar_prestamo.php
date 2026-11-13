<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página de préstamos.");
}

$idLibro = (int) ($_POST["id_libro"] ?? 0);
$alumno  = trim($_POST["nombre_alumno"] ?? "");
$correo  = trim($_POST["correo_alumno"] ?? "");

if ($idLibro <= 0 || $alumno === "" || $correo === "") {
    header("Location: prestamos.php?estadophp=campos_invalidos");
    exit;
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: prestamos.php?estadophp=correo_invalido");
    exit;
}

try {
    // Transacción: o se hacen las dos cosas (restar existencia + guardar préstamo) o ninguna
    $conexion->begin_transaction();

    // Resta 1 SOLO si todavía hay existencias (reto 14 y 15)
    $stmt = $conexion->prepare(
        "UPDATE libros SET existencias = existencias - 1
         WHERE id_libro = ? AND existencias > 0"
    );
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $filas = $stmt->affected_rows;      // 0 = no había existencias (o el libro no existe)
    $stmt->close();

    if ($filas === 0) {
        $conexion->rollback();
        $estado = "sin_existencias";
    } else {
        // El estado no se manda: la BD pone 'Prestado' por defecto
        $stmt = $conexion->prepare(
            "INSERT INTO prestamos (id_libro, nombre_alumno, correo_alumno)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iss", $idLibro, $alumno, $correo);
        $stmt->execute();
        $stmt->close();

        $conexion->commit();
        $estado = "prestamo_guardado";
    }
} catch (mysqli_sql_exception $e) {
    $conexion->rollback();
    $estado = "error";
}

$conexion->close();

header("Location: prestamos.php?estadophp=$estado");
exit;