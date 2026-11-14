<?php
require_once "conexion.php";

// Evita abrir el archivo directo sin enviar el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Envía el formulario desde la página principal.");
}

$concepto  = trim($_POST["concepto-gasto"] ?? "");
$monto     = trim($_POST["monto-gasto"] ?? "");
$categoria = trim($_POST["categoria-gasto"] ?? "");

// Validación en el servidor (la de JS se puede saltar)
if ($concepto === "" || $categoria === "" || !is_numeric($monto) || (float) $monto <= 0) {
    header("Location: index.php?estado=campos_invalidos");
    exit;
}

try {
    $stmt = $conexion->prepare(
        "INSERT INTO gastos (concepto, monto, categoria) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sds", $concepto, $monto, $categoria);
    $stmt->execute();
    $stmt->close();
    $estado = "guardado";
} catch (mysqli_sql_exception $e) {
    $estado = "error";
}

$conexion->close();

header("Location: index.php?estado=$estado");
exit;
