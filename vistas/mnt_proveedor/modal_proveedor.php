<div class="modal fade bd-example-modal" id="modalmant" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Registrar proveedor</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="font-icon-close-2"></i>
        </button>
      </div>
        
        <form id="proveedor-form">
          
          
          <div class="modal-body">
            <h1 class="modal-title fs-5" id="modal-titulo"></h1>
            <input type="hidden" name="id_proveedor" id="id_proveedor">
            <div class="form-group">
              <label for="">Nombre del Proveedor</label>
              <input type="text" class="form-control" name="nombre_proveedor" id="nombre_proveedor">
            </div>
            <div class="form-group">
              <label for="">Correo del Proveedor</label>
              <input type="email" class="form-control" name="correo" id="correo">
            </div>
            <div class="form-group">
              <label for="">Telefono 1</label>
              <input type="tel" class="form-control" name="telefono_1" id="telefono_1">
            </div>
            <div class="form-group">
              <label for="">Telefono 2</label>
              <input type="tel" class="form-control" name="telefono_2" id="telefono_2">
            </div>
            <div class="form-group">
              <label for="">RFC</label>
              <input type="text" class="form-control" name="RFC" id="RFC">
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
    </div>
  </div>
</div>