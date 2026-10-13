<?php
require_once "datos.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona de Administración</title>
    <link rel="stylesheet" href="./CSS/estilos.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <h1>Zona Administración</h1>
        <p>Mensajes Recibidos</p>
    </header>

    <!-- Navegación con icono de regreso -->
    <nav>
        <a href="index.html" class="icono-nav" title="Volver al portafolio">
            <svg viewBox="0 0 24 24">
                <path d="M3 11l9-8 9 8"/>
                <path d="M5 10v10h14V10"/>
                <path d="M10 20v-6h4v6"/>
            </svg>
        </a>
    </nav>

    <main>
        <section class="seccion-admin">
            <h2>Mensajes Recibidos</h2>

            <div class="tabla-contenedor">
                <table class="tabla-mensajes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Mensaje</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensajes as $id => $m): ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= htmlspecialchars($m["nombre"]) ?></td>
                            <td><?= htmlspecialchars($m["email"]) ?></td>
                            <td><?= htmlspecialchars($m["mensaje"]) ?></td>
                            <td class="opciones">
                                <!-- Enlace funcional a editar.php -->
                                <a href="editar.php?id=<?= $id ?>" class="icono-accion" title="Editar">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4z"/>
                                    </svg>
                                </a>
                                <a href="admin.php?borrar=<?= $id ?>"
                                   class="icono-accion borrar"
                                   title="Borrar"
                                   onclick="return confirm('¿Seguro que deseas borrar este mensaje?');">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4h8v2"/>
                                        <path d="M6 6l1 14h10l1-14"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>© 2026 Mi Portafolio</p>
        <p>Práctica de Programación Web</p>
    </footer>

</body>
</html>