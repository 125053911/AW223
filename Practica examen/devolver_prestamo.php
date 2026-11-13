<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página de préstamos.");
}

$idPrestamo = (int) ($_POST["id_prestamo"] ?? 0);

try {
    $conexion->begin_transaction();

    // 1) Buscar el préstamo (sólo si sigue 'Prestado') para saber qué libro es
    $stmt = $conexion->prepare(
        "SELECT id_libro FROM prestamos
         WHERE id_prestamo = ? AND estado = 'Prestado' FOR UPDATE"
    );
    $stmt->bind_param("i", $idPrestamo);
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($fila === null) {
        $conexion->rollback();
        $estado = "error";
    } else {
        // 2) Cambiar el estado a Devuelto
        $stmt = $conexion->prepare(
            "UPDATE prestamos SET estado = 'Devuelto' WHERE id_prestamo = ?"
        );
        $stmt->bind_param("i", $idPrestamo);
        $stmt->execute();
        $stmt->close();

        // 3) Sumar 1 a las existencias del libro (reto 14)
        $stmt = $conexion->prepare(
            "UPDATE libros SET existencias = existencias + 1 WHERE id_libro = ?"
        );
        $idLibro = (int) $fila["id_libro"];
        $stmt->bind_param("i", $idLibro);
        $stmt->execute();
        $stmt->close();

        $conexion->commit();
        $estado = "prestamo_devuelto";
    }
} catch (mysqli_sql_exception $e) {
    $conexion->rollback();
    $estado = "error";
}

$conexion->close();

header("Location: prestamos.php?estadophp=$estado");
exit;