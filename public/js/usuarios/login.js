function loginUsuario(){
    $.ajax({
        type:"POST",
        data:$('#frmLogin').serialize(),
        url:"procesos/login/loginUsuario.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                window.location.href = "vistas/modalLoginSession.php";
                window.location.href = "vistas/inicio.php"

            } else {
                Swal.fire(":("," Error al ! " + respuesta, "Error");
            }

        }
    });

    return false;
}




