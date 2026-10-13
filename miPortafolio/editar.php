<?php
require_once "datos.php";

$id       = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$existe   = isset($mensajes[$id]);
$msg      = $existe ? $mensajes[$id] : ["nombre" => "", "email" => "", "mensaje" => ""];
$guardado = false;

// Al enviar el formulario se toman los datos nuevos.
// En la siguiente práctica aquí se hará el UPDATE en la base de datos.
if ($_SERVER["REQUEST_METHOD"] === "POST" && $existe) {
    $msg["nombre"]  = trim($_POST["nombre"] ?? "");
    $msg["email"]   = trim($_POST["email"] ?? "");
    $msg["mensaje"] = trim($_POST["mensaje"] ?? "");
    $guardado = true;
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

    <!-- Navegación con iconos de regreso -->
    <nav>
        <a href="admin.php" class="icono-nav" title="Volver a la zona de administración">
            <svg viewBox="0 0 24 24">
                <path d="M19 12H5"/>
                <path d="M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <a href="index.html" class="icono-nav" title="Volver al portafolio">
            <svg viewBox="0 0 24 24">
                <path d="M3 11l9-8 9 8"/>
                <path d="M5 10v10h14V10"/>
                <path d="M10 20v-6h4v6"/>
            </svg>
        </a>
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

                <form method="POST" action="editar.php?id=<?= $id ?>">

                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre"
                               placeholder="Escribe tu nombre"
                               value="<?= htmlspecialchars($msg["nombre"]) ?>">
                    </div>

                    <div class="campo">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email"
                               placeholder="ejemplo@correo.com"
                               value="<?= htmlspecialchars($msg["email"]) ?>">
                    </div>

                    <div class="campo">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5"
                                  placeholder="Escribe tu mensaje"><?= htmlspecialchars($msg["mensaje"]) ?></textarea>
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

</body>
</html>