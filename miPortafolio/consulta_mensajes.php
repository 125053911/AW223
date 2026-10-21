<?php
require_once "conexion.php";

function consultaMensajes(){
    global $conexion;

    $selectMsj= "select * from mensajes";

    try{
        $rsMsj= mysqli_query($conexion, $selectMsj);
        mysqli_close($conexion);
        return $rsMsj;

    }catch(Exception $e){
        die('Algo paso al consultar: '.$e->getMessage());

    }
}