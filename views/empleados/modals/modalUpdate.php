<!-- Modal -->
<div class="modal fade" id="actualizarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frminsertu" onsubmit="return actualizarDatos()" method="post">
                    <input type="text" id="id" name="id" hidden="">
                    <label>Nombre</label>
                    <input type="text" id="nombreu" name="nombreUpdate" class="form-control form-control-sm" required="">
                    <label>Sueldo</label>
                    <input type="text" id="sueldou" name="sueldoUpdate" class="form-control form-control-sm" required="">
                    <label>Edad</label>
                    <input type="text" id="edadu" name="edadUpdate" class="form-control form-control-sm">
                    <label>Fecha de registro</label>
                    <input type="text" id="fechau" name="fechaUpdate" class="form-control form-control-sm">
                    <br>
                    <input type="submit" value="Actualizar" class="btn btn-warning">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>