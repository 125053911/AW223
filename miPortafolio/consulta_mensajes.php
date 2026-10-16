<?php

function consultaMensajes(){
    require_once "conexion.php";


    $selectMsj= "select * from mensajes";

    try{
        $rsMsj= mysqli_query($conexion, $selectMsj);
        mysqli_close($conexion);
        return $rsMsj;

    }catch(Exception){
        die('Algo paso al consultar: '.$e->getMessage());

    }
}