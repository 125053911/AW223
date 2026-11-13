<?php
require_once "conexion.php";

// Las funciones NO cierran la conexión: una misma página llama a varias.

function consultaCategorias() {
    global $conexion;
    $sql = "SELECT id_categoria, nombre_categoria
            FROM categorias
            ORDER BY nombre_categoria";
    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar las categorías: " . $e->getMessage());
    }
}

// JOIN: muestra el NOMBRE de la categoría, no su id
function consultaLibros() {
    global $conexion;
    $sql = "SELECT l.id_libro, l.titulo, l.autor, l.existencias,
                   c.nombre_categoria
            FROM libros l
            JOIN categorias c ON c.id_categoria = l.id_categoria
            ORDER BY l.titulo";
    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar los libros: " . $e->getMessage());
    }
}

// Sólo libros que se pueden prestar (reto 15)
function consultaLibrosDisponibles() {
    global $conexion;
    $sql = "SELECT id_libro, titulo, existencias
            FROM libros
            WHERE existencias > 0
            ORDER BY titulo";
    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar los libros disponibles: " . $e->getMessage());
    }
}

function consultaPrestamos() {
    global $conexion;
    $sql = "SELECT p.id_prestamo, l.titulo, p.nombre_alumno,
                   p.correo_alumno, p.estado, p.fecha_prestamo
            FROM prestamos p
            JOIN libros l ON l.id_libro = p.id_libro
            ORDER BY p.id_prestamo DESC";
    try {
        return mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        die("Algo pasó al consultar los préstamos: " . $e->getMessage());
    }
}