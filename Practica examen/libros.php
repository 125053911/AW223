<?php
require_once "consulta_biblioteca.php";

$rsCategorias = consultaCategorias();
$rsLibros     = consultaLibros();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Libros</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <header>
        <h1>Biblioteca</h1>
        <p>Registro de libros</p>
    </header>

    <nav>
        <a href="libros.php">Libros</a> |
        <a href="prestamos.php">Préstamos</a>
    </nav>

    <main>
        <!-- ======== REGISTRAR LIBRO ======== -->
        <section>
            <h2>Registrar libro</h2>

            <form method="POST" action="registrar_libro.php"
                  onsubmit="return validarLibro(this);" novalidate>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo">

                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor">

                <label for="id_categoria">Categoría</label>
                <select id="id_categoria" name="id_categoria">
                    <option value="">Seleccione una categoría</option>
                    <?php while ($c = mysqli_fetch_assoc($rsCategorias)): ?>
                        <option value="<?= (int) $c['id_categoria'] ?>">
                            <?= htmlspecialchars($c['nombre_categoria']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="existencias">Existencias</label>
                <input type="number" id="existencias" name="existencias" value="1" min="1">

                <button type="submit">Guardar libro</button>
            </form>
        </section>

        <!-- ======== LISTA DE LIBROS ======== -->
        <section>
            <h2>Libros registrados</h2>

            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categoría</th>
                        <th>Existencias</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($rsLibros) === 0): ?>
                        <tr><td colspan="5">Todavía no hay libros registrados.</td></tr>
                    <?php endif; ?>

                    <?php while ($l = mysqli_fetch_assoc($rsLibros)):
                        $id = (int) $l['id_libro'];
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($l['titulo']) ?></td>
                            <td><?= htmlspecialchars($l['autor']) ?></td>
                            <td><?= htmlspecialchars($l['nombre_categoria']) ?></td>
                            <td><?= (int) $l['existencias'] ?></td>
                            <td>
                                <a href="editar_libro.php?id_libro=<?= $id ?>" title="Editar">✎</a>
                                <a href="borrar_libro.php?id_libro=<?= $id ?>" title="Borrar"
                                   onclick="return confirm('¿Seguro que deseas borrar este libro?');">🗑</a>
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