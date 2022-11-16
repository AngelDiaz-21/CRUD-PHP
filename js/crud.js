function mostrar() {
    $.ajax({
        type: "POST",
        url: "procesos/mostrarDatos.php",
        success: function(r) {
            $('#tablaDatos').html(r);
        }
    });
}

function obtenerDatos(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "procesos/obtenerDatos.php",
        success: function(r) {
            r = jQuery.parseJSON(r);
            $('#id').val(r['id']);
            $('#nombreu').val(r['nombre']);
            $('#sueldou').val(r['sueldo']);
            $('#edadu').val(r['edad']);
            $('#fechau').val(r['fRegistro']);
        }
    });

}


function actualizarDatos() {
    $.ajax({
        type: "POST",
        url: "procesos/actualizarDatos.php",
        // Mandamos a llamar el formulario
        data: $('#frminsertu').serialize(),
        success: function(r) {
            // console.log(r);
            if (r == 1) {
                mostrar();
                swal("Actualizado con exito", ":D", "success");
            } else {
                swal("Error", ":(", "error");
            }
        }
    });
    return false;
}


function eliminarDatos(id) {
    swal({
            title: "¿Estas seguro de eliminar este registro?",
            text: "!Una vez eliminado no podra recuperarse¡",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "procesos/eliminarDatos.php",
                    // Mandamos a llamar el formulario
                    data: "id=" + id,
                    success: function(r) {
                        console.log(r);
                        if (r == 1) {
                            mostrar();
                            swal("Eliminado con exito", ":D", "info");
                        } else {
                            swal("Error", ":(", "error");
                        }
                    }
                });
            }
        });
}

function insertarDatos() {
    $.ajax({
        type: "POST",
        url: "procesos/insertarDatos.php",
        // Mandamos a llamar el formulario
        data: $('#frminsert').serialize(),
        success: function(r) {
            console.log(r);
            if (r == 1) {
                // Reseteamos frminsert
                $('#frminsert')[0].reset(); //Limpiar el formulario
                mostrar();
                swal("Dato agregado con exito", ":D", "success");
            } else {
                swal("Error", ":(", "error");
            }
        }
    });
    return false;
}

var btnCerrarVentana = document.getElementById('btn-cerrar');

btnCerrarVentana.addEventListener('click', function(){
    $('input[type=text]').val('');
    // $('input[type=email]').val('');
    // $('input[type=password]').val('');
})