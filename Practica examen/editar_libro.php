<?php
require_once "consulta_biblioteca.php";

$id     = (int) ($_GET["id_libro"] ?? 0);
$error  = "";

// 1) Cargar el registro desde la BD
$stmt = $conexion->prepare(
    "SELECT titulo, autor, id_categoria, existencias FROM libros WHERE id_libro = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$libro = $stmt->get_result()->fetch_assoc();   // null si no existe
$stmt->close();

$existe = ($libro !== null);

// 2) Al enviar el formulario: validar y hacer el UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && $existe) {
    $libro["titulo"]       = trim($_POST["titulo"] ?? "");
    $libro["autor"]        = trim($_POST["autor"] ?? "");
    $libro["id_categoria"] = (int) ($_POST["id_categoria"] ?? 0);
    $libro["existencias"]  = (int) ($_POST["existencias"] ?? 0);

    if ($libro["titulo"] === "" || $libro["autor"] === ""
        || $libro["id_categoria"] <= 0 || $libro["existencias"] < 1) {
        $error = "Todos los campos son obligatorios y las existencias deben ser al menos 1.";
    } else {
        try {
            $stmt = $conexion->prepare(
                "UPDATE libros
                 SET titulo = ?, autor = ?, id_categoria = ?, existencias = ?
                 WHERE id_libro = ?"
            );
            $stmt->bind_param("ssiii",
                $libro["titulo"], $libro["autor"],
                $libro["id_categoria"], $libro["existencias"], $id);
            $stmt->execute();
            $stmt->close();
            $estado = "libro_actualizado";
        } catch (mysqli_sql_exception $e) {
            $estado = "error";
        }
        $conexion->close();

        header("Location: libros.php?estadophp=$estado");
        exit;
    }
}

$rsCategorias = $existe ? consultaCategorias() : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar libro</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <header>
        <h1>Biblioteca</h1>
        <p>Editar libro</p>
    </header>

    <nav>
        <a href="libros.php">⤶ Volver a libros</a>
    </nav>

    <main>
        <?php if (!$existe): ?>
            <p>El libro solicitado no existe.</p>
            <p><a href="libros.php">Volver a la lista</a></p>

        <?php else: ?>
            <?php if ($error !== ""): ?>
                <p><strong><?= htmlspecialchars($error) ?></strong></p>
            <?php endif; ?>

            <section>
            <form method="POST" action="editar_libro.php?id_libro=<?= $id ?>"
                  onsubmit="return validarLibro(this);" novalidate>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo"
                       value="<?= htmlspecialchars($libro['titulo']) ?>">

                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor"
                       value="<?= htmlspecialchars($libro['autor']) ?>">

                <label for="id_categoria">Categoría</label>
                <select id="id_categoria" name="id_categoria">
                    <option value="">Seleccione una categoría</option>
                    <?php while ($c = mysqli_fetch_assoc($rsCategorias)): ?>
                        <!-- selected: deja marcada la categoría actual del libro -->
                        <option value="<?= (int) $c['id_categoria'] ?>"
                            <?= ((int) $c['id_categoria'] === (int) $libro['id_categoria']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nombre_categoria']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="existencias">Existencias</label>
                <input type="number" id="existencias" name="existencias" min="1"
                       value="<?= (int) $libro['existencias'] ?>">

                <button type="submit">Actualizar libro</button>
            </form>
            </section>
        <?php endif; ?>
    </main>

    <script src="JS/validaciones.js"></script>
    <script src="JS/AlertInsert.js"></script>
</body>
</html>