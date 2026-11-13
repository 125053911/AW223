<?php
require_once "conexion.php";

$id = (int) ($_GET["id_libro"] ?? 0);

try {
    $stmt = $conexion->prepare("DELETE FROM libros WHERE id_libro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $estado = "libro_borrado";
} catch (mysqli_sql_exception $e) {
    // 1451 = no se puede borrar: otra tabla (prestamos) apunta a este libro
    $estado = ($e->getCode() === 1451) ? "libro_con_prestamos" : "error";
}

$conexion->close();

header("Location: libros.php?estadophp=$estado");
exit;