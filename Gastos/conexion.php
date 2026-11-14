<?php
$servidor= "localhost";
$usuario= "root";
$password="";
$baseDatos="gastos_db";

// Lanza excepciones mysqli_sql_exception en lugar de fallar en silencio
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conexion= new mysqli($servidor, $usuario, $password, $baseDatos);
$conexion->set_charset("utf8mb4");
// Sin "echo": cualquier salida antes de header("Location: ...") rompe la redirección
?>
