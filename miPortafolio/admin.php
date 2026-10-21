<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio - Admin</title>
    <link rel="stylesheet" href="./CSS/estilos.css">
</head>
<body>
    <!-- Este es el encabezado -->
    <header>
        <h1>Zona Administración</h1>
        <!-- La p significa párrafo -->
        <p>Mensajes Recibidos</p>
    </header>

    <!-- Barra de navegación / Icono de regreso -->
    <nav>
        <a href="index.php">🏠︎</a>
    </nav>

    <!-- Principal -->
    <main>
        <section class="seccion-admin">
            <!-- Cuadro contenedor de la tabla -->
            <div class="contenedor-cuadro-mensajes">
                <h2>Mensajes Recibidos</h2>

                <table class="tabla-mensajes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once "consulta_mensajes.php";
                        $rsMensaje = consultaMensajes();

                        while ($arrMensajes = mysqli_fetch_assoc($rsMensaje)):
                            $id = (int) $arrMensajes['id'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($arrMensajes['nombre']) ?></td>
                                <td><?= htmlspecialchars($arrMensajes['email']) ?></td>
                                <td><?= htmlspecialchars($arrMensajes['mensaje']) ?></td>
                                <td><?= htmlspecialchars($arrMensajes['timeStaps']) ?></td>
                                <td>
                                    <a href="editar.php?id=<?= $id ?>" title="Editar">✎</a>
                                    <a href="borrar.php?id=<?= $id ?>" title="Borrar"
                                       onclick="return confirm('Estas seguro de borrar este mensaje');">🗑</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2026 Mi Portafolio</p>
        <p>Práctica de Programación Web</p>
    </footer>

    <script src="JS/AlertInsert.js"></script>
</body>
</html>