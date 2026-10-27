<?php
require_once "consulta_usuarios.php";

$rsRoles    = consultaRoles();
$rsUsuarios = consultaUsuarios();
$rsEquipos  = consultaEquipos();

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
    <title>Soporte - Usuarios y equipos</title>
    <link rel="stylesheet" href="CSS/soporte.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <h1>Soporte técnico universitario</h1>
        <p>Bienvenido · Registro de usuarios y equipos</p>
    </header>

    <!-- Navegación (el equipo agrega aquí los enlaces de los otros módulos) -->
    <nav>
        <a href="usuarios.php" class="activa">Usuarios y equipos</a>
    </nav>

    <main>

        <!-- ============ REGISTRAR USUARIO ============ -->
        <section class="seccion-admin">
            <h2>
                Registro de usuario
                <span class="etiqueta-vista">Admin</span>
            </h2>

            <form method="POST" action="registrar_usuario.php"
                  class="formulario" onsubmit="return validarUsuario(this);" novalidate>

                <div class="fila-campos">
                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej. Ana">
                    </div>
                    <div class="campo">
                        <label for="apellido_paterno">Apellido paterno</label>
                        <input type="text" id="apellido_paterno" name="apellido_paterno" placeholder="Ej. López">
                    </div>
                    <div class="campo">
                        <label for="apellido_materno">Apellido materno <span class="ayuda">(opcional)</span></label>
                        <input type="text" id="apellido_materno" name="apellido_materno" placeholder="Ej. Pérez">
                    </div>
                </div>

                <div class="fila-campos">
                    <div class="campo">
                        <label for="correo">Correo electrónico</label>
                        <input type="email" id="correo" name="correo" placeholder="ejemplo@universidad.mx">
                    </div>
                    <div class="campo">
                        <label for="contrasena">Contraseña <span class="ayuda">(mínimo 6 caracteres)</span></label>
                        <input type="password" id="contrasena" name="contrasena" placeholder="Escribe una contraseña">
                    </div>
                </div>

                <div class="campo">
                    <label for="id_rol">Rol</label>
                    <select id="id_rol" name="id_rol">
                        <option value="">Seleccione un rol</option>
                        <?php while ($rol = mysqli_fetch_assoc($rsRoles)): ?>
                            <option value="<?= (int) $rol['id'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit">Guardar usuario</button>
            </form>
        </section>

        <!-- ============ LISTA DE USUARIOS ============ -->
        <section class="seccion-admin">
            <h2>
                Usuarios registrados
                <span class="etiqueta-vista">Admin</span>
            </h2>

            <div class="tabla-contenedor">
                <table class="tabla-mensajes">
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($rsUsuarios) === 0): ?>
                            <tr class="fila-vacia">
                                <td colspan="4">Todavía no hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>

                        <?php while ($u = mysqli_fetch_assoc($rsUsuarios)):
                            $nombreCompleto = trim($u['nombre'] . ' ' . $u['apellido_paterno'] . ' ' . ($u['apellido_materno'] ?? ''));
                            $rolClase = "rol-" . $u['rol'];
                        ?>
                            <tr>
                                <td class="col-id"><?= (int) $u['id'] ?></td>
                                <td><?= htmlspecialchars($nombreCompleto) ?></td>
                                <td><?= htmlspecialchars($u['correo']) ?></td>
                                <td><span class="badge <?= htmlspecialchars($rolClase) ?>"><?= htmlspecialchars($u['rol']) ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ============ REGISTRAR EQUIPO ============ -->
        <section class="seccion-admin">
            <h2>
                Registro de equipo
                <span class="etiqueta-vista">Admin</span>
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
                <span class="etiqueta-vista">Admin</span>
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