<?php
require_once "conexion.php";

function consultaRoles() {
    global $conexion;

    $sql = "SELECT id, nombre FROM roles ORDER BY id";

    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar los roles: " . $e->getMessage());
    }
}

function consultaUsuarios() {
    global $conexion;

    $sql = "SELECT u.id, u.nombre, u.apellido_paterno, u.apellido_materno,
                   u.correo, r.nombre AS rol
            FROM usuarios u
            JOIN roles r ON r.id = u.id_rol
            ORDER BY u.apellido_paterno, u.nombre";

    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar los usuarios: " . $e->getMessage());
    }
}

function consultaEquipos() {
    global $conexion;

    $sql = "SELECT id, nombre_equipo, descripcion, ubicacion, disponibilidad
            FROM equipos
            ORDER BY nombre_equipo";

    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar los equipos: " . $e->getMessage());
    }
}