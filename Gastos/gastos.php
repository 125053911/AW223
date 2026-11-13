<?php
require_once "conexion.php";

$id       = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$existe   = false;
$msg      = ["concepto" => "", "monto" => "", "categoria" => ""];
$guardado = false;
$error    = "";

// CAMBIO: carga el registro desde la BD en lugar del arreglo de datos.php
$stmt = $conexion->prepare("SELECT concepto, monto, categoria FROM gastos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($registro) {
    $existe = true;
    $msg    = $registro;
}
// Al enviar el formulario se actualiza la BD
if ($_SERVER["REQUEST_METHOD"] === "POST" && $existe) {
    $msg["concepto"] = trim($_POST["concepto-gasto"] ?? "");
    $msg["monto"]    = trim($_POST["monto-gasto"] ?? "");
    $msg["categoria"]= trim($_POST["categoria-gasto"] ?? "");


    // CAMBIO: validación en el servidor (no se permiten vacíos)
    if ($msg["concepto"] === "" || $msg["monto"] === "" || $msg["categoria"] === "") {
        $error = "Todos los campos son obligatorios.";
    } else {
        // CAMBIO: UPDATE en la BD y redirección al home con alert
        $stmt = $conexion->prepare(
            "UPDATE gastos SET concepto = ?, monto = ?, categoria = ? WHERE id = ?"
        );
        $stmt->bind_param("sssi", $msg["concepto"], $msg["monto"], $msg["categoria"], $id);
        $estado = $stmt->execute() ? "actualizado" : "error";
        $stmt->close();
        $conexion->close();

        header("Location: index.php?estado=$estado");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Gasto</title>
    <link rel="stylesheet" href="./CSS/estilos.css">
</head>
<body>
    <!-- CAMBIO: carga el script de alerts -->
    <script src="./JS/AlertInsert.js"></script>
</body>
</html>
