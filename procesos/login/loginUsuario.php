<?php

    session_start();
    $usuario = $_POST['login'];
    $password = sha1($_POST['password']);
    

    
    include "../../clases/Usuarios.php";
    
    $Usuarios = new Usuarios();
   

    echo $Usuarios->loginUsuario($usuario, $password,);
    


function tokenG($leng=10){
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = "";


    for ($i=0; $i < $leng; $i++){
        $token .= $cadena[rand(0,35)];
    }
    return $token;

    

  

}
echo tokenG();





