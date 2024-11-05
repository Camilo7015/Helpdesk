
$(document).ready(function(){
    $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
});

function agregarNuevoUsuario(){

    $.ajax({
        type: "POST",
        data: $('#frmAgregarUsuario').serialize(),
        url: "../procesos/usuarios/agregarNuevoUsuario.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1){
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                $('#frmAgregarUsuario')[0].reset();
                Swal.fire(":D","Agregado con Exito!","success");
            }else {
                Swal.fire(":(","Error al agregar" + respuesta,"error")
            }
        } 
    });
    
    return false;
}

function obtenerDatosUsuario(idUsuario) {
    $.ajax({
        type: "POST",
        data: "idUsuario=" + idUsuario,
        url: "../procesos/usuarios/obtenerDatosUsuarios.php",
        success:function(respuesta) {
            respuesta = jQuery.parseJSON(respuesta);
            $('#idUsuario').val(respuesta['idUsuario']);
            $('#paternou').val(respuesta['paterno']);
            $('#maternou').val(respuesta['materno']);
            $('#nombreu').val(respuesta['nombrePersona']);
            $('#fechanacimientou').val(respuesta['fechaNacimiento']);
            $('#sexou').val(respuesta['sexo']);
            $('#telefonou').val(respuesta['telefono']);
            $('#correou').val(respuesta['correo']);
            $('#usuariou').val(respuesta['nombreUsuario']);
            $('#idRolu').val(respuesta['idRol']);
            $('#ubicacionu').val(respuesta['ubicacion']);
        }
    });
}

function actualizarUsuario() {
    $.ajax({
        type:"POST",
        data:$('#frmActualizarUsuario').serialize(),
        url:"../procesos/usuarios/actualizarUsuario.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                $('#modalActualizarUsuarios').modal('hide');
                Swal.fire(":D","Actualizado con Exito!","success");

            }else {
                Swal.fire(":(","Error al actualizar" + respuesta,"error")
            }
        }
    });

    return false;
}

function agregarIdUsuarioReset(idUsuario) {
    $('#idUsuarioReset').val(idUsuario);
}

function resetPassword() {
    $.ajax({
        type:"POST",
        data: $('#frmActualizaPassword').serialize(),
        url:"../procesos/usuarios/extras/resetPassword.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                $('#modalResetPassword').modal('hide');
                Swal.fire(":D","Cambio de password con Exito!","success");
                
            }else {
                Swal.fire(":(","Error al actualizar el password" + respuesta,"error")
            }
        }
    });

    return false;
}

function cambioEstatusUsuario(idUsuario, estatus) {
    $.ajax({
        type:"POST",
        data:"idUsuario=" + idUsuario + "&estatus=" + estatus,
        url:"../procesos/usuarios/extras/cambioEstatus.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                Swal.fire(":D","Cambio de estatus con Exito!","success"); 
            } else {
                Swal.fire(":(","Error al cambiar el estatus" + respuesta,"error");
            }
        }
    });
}

function eliminarUsuario(idUsuario, idPersona) {
    Swal.fire({
        title: 'Estas seguro de eliminar este registro?',
        text: "Una vez eliminado no podra ser recuperado !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:"POST",
                data: "idUsuario=" + idUsuario + "&idPersona=" + idPersona,
                url:"../procesos/usuarios/eliminarUsuario.php",
                success:function(respuesta) {
                    respuesta = respuesta.trim();
                    if (respuesta == 1) {
                        $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                        Swal.fire(":D","Usuario eliminado con Exito!","success"); 
                    } else {
                        Swal.fire(":(","Error al eliminar usuario" + respuesta,"error");
                    }
                }
            });
        }
    });

    return false;
}
    
    
        
    

