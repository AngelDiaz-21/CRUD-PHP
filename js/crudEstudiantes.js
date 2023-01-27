function insertarDatos() {
    $.ajax({
        type: "POST",
        url: "registrar",
        data: $('#formCreate').serialize(),
        success: function(r) {
            if(r == 0){
                $('#formCreate')[0].reset();
                swal("Error", 'Los campos no pueden estar vacíos', "error");
            }else if (r == 1) {
                $('#formCreate')[0].reset(); //Limpiar el formulario
                swal("Dato agregado con éxito", "", "success");
            } else {
                swal("Error", 'No se pueden agregar campos repetidos', "error");
                // swal("Error", r, "error");
            }
        }
    });
    return false;
}

function actualizarDatos() {
    $.ajax({
        type: "POST",
        url: "../actualizarDatos",
        data: $('#formCreate').serialize(),
        success: function(r) {
            if(r == 0){
                $('#formCreate')[0].reset();
                swal("Error", 'Los campos no pueden estar vacíos', "error");
            }else if (r == 1) {
                swal(
                    "Dato actualizado con éxito",
                    "",
                    "success"
                )
                .then((success) => {
                    if(success){
                        window.location="http://crud-pdo-mysql.test/estudiantes";
                    } else{
                        window.location="http://crud-pdo-mysql.test/estudiantes";
                    }
                })
            } else {
                swal("Error", r, "error");
            }
        }
    });
    return false;
}

function eliminarDatos(matricula) {
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
                url: "estudiantes/delete",
                data: "matricula=" + matricula,
                success: function(r) {
                    if (r == 1) {
                            const tbody = document.querySelector('#tbody-alumnos');
                            const fila = document.querySelector('#fila-' + matricula);
                            tbody.removeChild(fila);
                        swal("Eliminado con éxito", "", "success");
                    } else {
                        swal("Error", "", "error");
                    }
                }
            });
        }
    });
}