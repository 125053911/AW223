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
    <link rel="stylesheet" href="./CSS/estilos.css?v=<?= filemtime(__DIR__ . '/CSS/estilos.css') ?>">
</head>
<body>
    <header>
        <h1>Editar Gasto</h1>
    </header>
    <main>
        <?php if (!$existe): ?>
            <p>El gasto solicitado no existe.</p>
            <a href="index.php">Volver</a>
        <?php else: ?>
            <?php if ($error !== ""): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form action="gastos.php?id=<?= $id ?>" method="post" onsubmit="return validarGasto(this)">
                <div>
                    <label for="concepto-gasto">Concepto:</label>
                    <input type="text" id="concepto-gasto" name="concepto-gasto" value="<?= htmlspecialchars($msg["concepto"]) ?>" required>
                </div>
                <div>
                    <label for="monto-gasto">Monto:</label>
                    <input type="number" id="monto-gasto" name="monto-gasto" step="0.01" min="0.01" value="<?= htmlspecialchars($msg["monto"]) ?>" required>
                </div>
                <div>
                    <label for="categoria-gasto">Categoría:</label>
                    <input type="text" id="categoria-gasto" name="categoria-gasto" value="<?= htmlspecialchars($msg["categoria"]) ?>" required>
                </div>
                <div>
                    <button type="submit">Guardar cambios</button>
                    <a href="index.php">Cancelar</a>
                </div>
            </form>
        <?php endif; ?>
    </main>
    <script src="./JS/AlertInsert.js"></script>
</body>
</html>
