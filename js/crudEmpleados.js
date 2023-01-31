function mostrar() {
    $.ajax({
        type: "POST",
        url: "empleados/getEmpleados",
        success: function(r) {
            $('#tablaDatos').html(r);
        }
    });
}

function insertarDatos() {
    $.ajax({
        type: "POST",
        url: "empleados/registrarEmpleado",
        data: $('#frminsert').serialize(),
        success: function(r) {
            if (r == 0) {
                swal("Error", "Los campos no pueden estar vacíos", "error");
            } else if(r == 1){
                $('#frminsert')[0].reset();
                mostrar();
                swal("Dato agregado con éxito", "", "success");
            } else{
                swal("Error", r, "error");
            }
        }
    });
    return false;
}

function obtenerDatos(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        async: false,     //que espere respuesta
        url: "empleados/obtenerDatos",
        success: function(r) {
            if(!(r == 0)){
                r = jQuery.parseJSON(r);
                $('#id').val(r['id']);
                $('#nombreu').val(r['nombre']);
                $('#sueldou').val(r['sueldo']);
                $('#edadu').val(r['edad']);
                $('#fechau').val(r['fRegistro']);
                $('#session').val(r['dum']);
            }else{
                window.location="http://crud-pdo-mysql.test/empleados";
            }
        }
    });
}

function actualizarDatos() {
    $.ajax({
        type: "POST",
        url: "empleados/actualizarDatos",
        // Mandamos a llamar el formulario
        data: $('#frminsertu').serialize(),
        success: function(r) {
            if (r == 0) {
                swal("Error", "Los campos no pueden estar vacíos", "error");
            } else if(r == 1){
                $('#frminsert')[0].reset();
                mostrar();
                swal("Dato actualizado con éxito", "", "success").then((success) =>{
                    $("#actualizarModal").modal('hide');//ocultamos el modal
                })
            } else{
                swal("Error", 'Error', "error");
            }
        }
    });
    return false;
}

function eliminarDatos(id) {
    swal({
        title: "¿Esta seguro que desea eliminar este registro?",
        text: "¡Una vez eliminado no podrá recuperarse!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "empleados/eliminarDatos",
                data: "id=" + id,
                success: function(r) {
                    if (r == 1) {
                        mostrar();
                        swal("Registro eliminado con éxito", "", "success");
                    } else {
                        swal("Error", "", "error");
                    }
                }
            });
        }
    });
}

var btnCerrarVentana = document.querySelectorAll('.btnCerrar');

btnCerrarVentana.forEach(boton => {
    boton.addEventListener('click', function(){
        $('input[type=text]').val('');
        //$('input[type=email]').val('');
        //$('input[type=password]').val('');
    })
});