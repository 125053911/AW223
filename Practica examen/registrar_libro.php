<?php
require_once "conexion.php";

// Evita abrir el archivo directo sin enviar el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página de libros.");
}

$titulo      = trim($_POST["titulo"] ?? "");
$autor       = trim($_POST["autor"] ?? "");
$idCategoria = (int) ($_POST["id_categoria"] ?? 0);
$existencias = (int) ($_POST["existencias"] ?? 0);

// Validación en el servidor (la de JS se puede saltar)
if ($titulo === "" || $autor === "" || $idCategoria <= 0 || $existencias < 1) {
    header("Location: libros.php?estadophp=campos_invalidos");
    exit;
}

try {
    $stmt = $conexion->prepare(
        "INSERT INTO libros (titulo, autor, id_categoria, existencias)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssii", $titulo, $autor, $idCategoria, $existencias);
    $stmt->execute();
    $stmt->close();
    $estado = "libro_guardado";
} catch (mysqli_sql_exception $e) {
    // 1452 = la categoría no existe (llave foránea)
    $estado = ($e->getCode() === 1452) ? "categoria_invalida" : "error";
}

$conexion->close();

header("Location: libros.php?estadophp=$estado");
exit;