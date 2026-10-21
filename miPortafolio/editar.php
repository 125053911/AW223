<?php
require_once "conexion.php"; 

$id       = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$existe   = false;
$msg      = ["nombre" => "", "email" => "", "mensaje" => ""];
$guardado = false;
$error    = "";

// CAMBIO: carga el registro desde la BD en lugar del arreglo de datos.php
$stmt = $conexion->prepare("SELECT nombre, email, mensaje FROM mensajes WHERE id = ?");
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
    $msg["nombre"]  = trim($_POST["nombre"] ?? "");
    $msg["email"]   = trim($_POST["email"] ?? "");
    $msg["mensaje"] = trim($_POST["mensaje"] ?? "");

    // CAMBIO: validación en el servidor (no se permiten vacíos)
    if ($msg["nombre"] === "" || $msg["email"] === "" || $msg["mensaje"] === "") {
        $error = "Todos los campos son obligatorios.";
    } else {
        // CAMBIO: UPDATE en la BD y redirección al home con alert
        $stmt = $conexion->prepare(
            "UPDATE mensajes SET nombre = ?, email = ?, mensaje = ? WHERE id = ?"
        );
        $stmt->bind_param("sssi", $msg["nombre"], $msg["email"], $msg["mensaje"], $id);
        $estado = $stmt->execute() ? "actualizado" : "error";
        $stmt->close();
        $conexion->close();

        header("Location: index.php?estadophp=$estado");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mensaje</title>
    <link rel="stylesheet" href="./CSS/estilos.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <h1>Zona Administración</h1>
        <p>Formulario para Editar</p>
    </header>

    <!-- Navegación con símbolos de regreso -->
    <nav>
        <a href="admin.php" title="Volver a la zona de administración">⤶</a>
        <a href="index.html" title="Volver al portafolio">🏠︎</a>
    </nav>

    <main>
        <section>
            <h2>Editar Mensaje</h2>

            <?php if (!$existe): ?>
                <p class="aviso">El mensaje solicitado no existe.</p>
                <p style="text-align:center;"><a href="admin.php">Volver a la lista</a></p>

            <?php else: ?>

                <?php if ($guardado): ?>
                    <p class="aviso">Mensaje actualizado correctamente.</p>
                <?php endif; ?>

                <?php if ($error !== ""): ?>
                    <p class="aviso"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form method="POST" action="editar.php?id=<?= $id ?>">

                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre"
                               placeholder="Escribe tu nombre"
                               value="<?= htmlspecialchars($msg["nombre"]) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email"
                               placeholder="ejemplo@correo.com"
                               value="<?= htmlspecialchars($msg["email"]) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5"
                                  placeholder="Escribe tu mensaje" required><?= htmlspecialchars($msg["mensaje"]) ?></textarea>
                    </div>

                    <button type="submit">Actualizar Mensaje</button>
                </form>

            <?php endif; ?>
        </section>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>© 2026 Mi Portafolio</p>
        <p>Práctica de Programación Web</p>
    </footer>

    <!-- CAMBIO: carga el script de alerts -->
    <script src="JS/AlertInsert.js"></script>
</body>
</html>