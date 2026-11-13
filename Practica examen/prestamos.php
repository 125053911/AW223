<?php
require_once "consulta_biblioteca.php";

$rsLibros    = consultaLibrosDisponibles();   // sólo con existencias > 0
$rsPrestamos = consultaPrestamos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Préstamos</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <header>
        <h1>Biblioteca</h1>
        <p>Préstamos</p>
    </header>

    <nav>
        <a href="libros.php">Libros</a> |
        <a href="prestamos.php">Préstamos</a>
    </nav>

    <main>
        <!-- ======== REGISTRAR PRÉSTAMO ======== -->
        <section>
            <h2>Registrar préstamo</h2>

            <!-- El estado NO se captura: la BD pone 'Prestado' por defecto -->
            <form method="POST" action="registrar_prestamo.php"
                  onsubmit="return validarPrestamo(this);" novalidate>

                <label for="id_libro">Libro</label>
                <select id="id_libro" name="id_libro">
                    <option value="">Seleccione un libro</option>
                    <?php while ($l = mysqli_fetch_assoc($rsLibros)): ?>
                        <option value="<?= (int) $l['id_libro'] ?>">
                            <?= htmlspecialchars($l['titulo']) ?> (<?= (int) $l['existencias'] ?> disp.)
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="nombre_alumno">Nombre del alumno</label>
                <input type="text" id="nombre_alumno" name="nombre_alumno">

                <label for="correo_alumno">Correo del alumno</label>
                <input type="email" id="correo_alumno" name="correo_alumno">

                <button type="submit">Registrar préstamo</button>
            </form>
        </section>

        <!-- ======== LISTA DE PRÉSTAMOS ======== -->
        <section>
            <h2>Préstamos registrados</h2>

            <table>
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Alumno</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($rsPrestamos) === 0): ?>
                        <tr><td colspan="6">Todavía no hay préstamos.</td></tr>
                    <?php endif; ?>

                    <?php while ($p = mysqli_fetch_assoc($rsPrestamos)): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['titulo']) ?></td>
                            <td><?= htmlspecialchars($p['nombre_alumno']) ?></td>
                            <td><?= htmlspecialchars($p['correo_alumno']) ?></td>
                            <td><?= htmlspecialchars($p['estado']) ?></td>
                            <td><?= htmlspecialchars($p['fecha_prestamo']) ?></td>
                            <td>
                                <?php if ($p['estado'] === 'Prestado'): ?>
                                    <!-- Mini formulario por fila: el id viaja en un input hidden -->
                                    <form method="POST" action="devolver_prestamo.php">
                                        <input type="hidden" name="id_prestamo"
                                               value="<?= (int) $p['id_prestamo'] ?>">
                                        <button type="submit">Marcar devuelto</button>
                                    </form>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="JS/validaciones.js"></script>
    <script src="JS/AlertInsert.js"></script>
</body>
</html>