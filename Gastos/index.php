<?php
require_once "conexion.php";

// Totales y listado desde la BD
$resumen = $conexion->query("SELECT COALESCE(SUM(monto), 0) AS total, COUNT(*) AS cantidad FROM gastos")->fetch_assoc();
$gastos  = $conexion->query("SELECT id, concepto, monto, categoria FROM gastos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2do P</title>
    <link rel="stylesheet" href="./CSS/estilos.css?v=<?= filemtime(__DIR__ . '/CSS/estilos.css') ?>">
</head>
<body>
     <header>
        <h1> Control de Gastos Personales </h1>
    </header>
    <main>
        <section>
            <div>
                <h2> Total Gastado </h2>
                <p id="total-gastado"><?= number_format((float) $resumen["total"], 2) ?></p>
            </div>
        </section>

          <section>
            <div>
                <h2> Gastos Registrados </h2>
                <p id="gastos-pendientes"><?= (int) $resumen["cantidad"] ?></p>
            </div>
        </section>

         <section>
            <div>
                <h2> Registrar Nuevo Gasto </h2>
                <form id="form-registrar-gasto" action="registrar_gasto.php" method="post" onsubmit="return validarGasto(this)">
                    <div>
                        <label for="concepto-gasto">Concepto:</label>
                        <input type="text" id="concepto-gasto" name="concepto-gasto" required>
                    </div>
                    <div>
                        <label for="monto-gasto">Monto:</label>
                        <input type="number" id="monto-gasto" name="monto-gasto" step="0.01" min="0.01" required>
                    </div>
                    <div>
                        <label for="categoria-gasto">Categoría:</label>
                        <input type="text" id="categoria-gasto" name="categoria-gasto" required>
                    </div>
                    <div>
                        <button type="submit">Registrar Gasto</button>
                    </div>
                </form>
            </div>
        </section>

          <section>
            <div>
                <h2> Listado de Gastos </h2>
                <table>
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($gastos->num_rows === 0): ?>
                        <tr><td colspan="4">Aún no hay gastos registrados.</td></tr>
                    <?php else: ?>
                        <?php while ($g = $gastos->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($g["concepto"]) ?></td>
                            <td><?= number_format((float) $g["monto"], 2) ?></td>
                            <td><?= htmlspecialchars($g["categoria"]) ?></td>
                            <td><a href="gastos.php?id=<?= (int) $g["id"] ?>">Editar</a></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

      </main>

    <script src="./JS/AlertInsert.js"></script>
</body>
</html>
<?php $conexion->close(); ?>
