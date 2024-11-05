$(document).ready(function() {
    $('#tablaReporteAdminLoad').load('reportesAdmin/tablaReportesAdmin.php');
});

function eliminarReporteAdmin(idReporte){
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
                data:"idReporte=" + idReporte,
                url:"../procesos/reportesCliente/eliminarReporteCliente.php",
                success:function(respuesta) {
                    if (respuesta == 1) {
                        $('#tablaReporteClienteLoad').load('reportesCliente/tablaReporteCliente.php');
                        Swal.fire(":D","Eliminado con Exito!","success");  
                    } else {
                        Swal.fire(":(","Fallo al Eliminar!" + respuesta, "error");
                    }
                }
            });
        }
      });

    return false;
}

function obtenerDatosSolucion(idReporte) {
    $.ajax({
        type:"POST",
        data:"idReporte=" + idReporte,
        url:"../procesos/reportesAdmin/obtenerSolucion.php",
        success:function(respuesta) {
            respuesta = jQuery.parseJSON(respuesta);
            $('#idReporte').val(respuesta['idReporte']);
            $('#solucion').val(respuesta['solucion']);
            $('#estatus').val(respuesta['estatus']);
        }
    });
}

function agregarSolucionReporte() {
    $.ajax({
        type:"POST",
        data:$('#frmAgregarSolucionReporte').serialize(),
        url:"../procesos/reportesAdmin/actualizarSolucion.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();

            if (respuesta == 1){
                Swal.fire(":D","Agregado Con Exito!", "success");
                $('#tablaReporteAdminLoad').load('reportesAdmin/tablaReportesAdmin.php');
            } else {
                Swal.fire(":(","Fallo!" + respuesta, "error");
            }
        }
    
    });

    return false;
}

