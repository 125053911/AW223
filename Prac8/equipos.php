<?php
require_once "consulta_usuarios.php";

$rsEquipos = consultaEquipos();

// Etiquetas legibles para la disponibilidad guardada en la base
$etiquetasDisponibilidad = [
    "disponible"       => "Disponible",
    "en_mantenimiento" => "En mantenimiento",
    "baja"             => "Dado de baja",
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte - Equipos</title>
    <link rel="stylesheet" href="CSS/soporte.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <h1>Soporte técnico universitario</h1>
        <p>Bienvenido · Registro de equipos</p>
    </header>

    <!-- Navegación entre módulos -->
    <nav>
        <a href="usuarios.php">Usuarios</a>
        <a href="equipos.php" class="activa">Equipos</a>
    </nav>

    <main>

        <!-- ============ REGISTRAR EQUIPO ============ -->
        <section class="seccion-admin">
            <h2>
                Registro de equipo
            </h2>

            <form method="POST" action="registrar_equipo.php"
                  class="formulario" onsubmit="return validarEquipo(this);" novalidate>

                <div class="fila-campos">
                    <div class="campo">
                        <label for="nombre_equipo">Nombre del equipo</label>
                        <input type="text" id="nombre_equipo" name="nombre_equipo" placeholder="Ej. Computadora 5">
                    </div>
                    <div class="campo">
                        <label for="ubicacion">Ubicación <span class="ayuda">(opcional)</span></label>
                        <input type="text" id="ubicacion" name="ubicacion" placeholder="Ej. C2001">
                    </div>
                    <div class="campo">
                        <label for="disponibilidad">Disponibilidad</label>
                        <select id="disponibilidad" name="disponibilidad">
                            <option value="disponible">Disponible</option>
                            <option value="en_mantenimiento">En mantenimiento</option>
                            <option value="baja">Dado de baja</option>
                        </select>
                    </div>
                </div>

                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3"
                              placeholder="Características o problema del equipo"></textarea>
                </div>

                <button type="submit">Guardar equipo</button>
            </form>
        </section>

        <!-- ============ LISTA DE EQUIPOS ============ -->
        <section class="seccion-admin">
            <h2>
                Listado de equipos
            </h2>

            <div class="tabla-contenedor">
                <table class="tabla-mensajes">
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Ubicación</th>
                            <th>Disponibilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($rsEquipos) === 0): ?>
                            <tr class="fila-vacia">
                                <td colspan="5">Todavía no hay equipos registrados.</td>
                            </tr>
                        <?php endif; ?>

                        <?php while ($e = mysqli_fetch_assoc($rsEquipos)):
                            $disp = $e['disponibilidad'];
                        ?>
                            <tr>
                                <td class="col-id"><?= (int) $e['id'] ?></td>
                                <td><?= htmlspecialchars($e['nombre_equipo']) ?></td>
                                <td><?= htmlspecialchars($e['descripcion']) ?></td>
                                <td><?= htmlspecialchars($e['ubicacion'] ?? '—') ?></td>
                                <td>
                                    <span class="badge disp-<?= htmlspecialchars($disp) ?>">
                                        <?= htmlspecialchars($etiquetasDisponibilidad[$disp] ?? $disp) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Pie de página -->
    <footer>
        <p>© 2026 Sistema de soporte técnico universitario</p>
        <p>Práctica No. 8 · Integrante 1</p>
    </footer>

    <script src="JS/validaciones_usuarios.js"></script>
    <script src="JS/AlertInsert.js"></script>
</body>
</html>