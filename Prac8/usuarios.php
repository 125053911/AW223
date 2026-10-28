<?php
require_once "consulta_usuarios.php";

$rsRoles    = consultaRoles();
$rsUsuarios = consultaUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte - Usuarios</title>
    <link rel="stylesheet" href="CSS/soporte.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <h1>Soporte técnico universitario</h1>
        <p>Bienvenido · Registro de usuarios</p>
    </header>

    <!-- Navegación entre módulos -->
    <nav>
        <a href="usuarios.php" class="activa">Usuarios</a>
        <a href="equipos.php">Equipos</a>
    </nav>

    <main>

        <!-- ============ REGISTRAR USUARIO ============ -->
        <section class="seccion-admin">
            <h2>
                Registro de usuario
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