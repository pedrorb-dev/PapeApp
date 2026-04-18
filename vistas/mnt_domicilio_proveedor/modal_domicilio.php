<div class="modal fade bd-example-modal" id="modalmant" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Registrar domicilio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="font-icon-close-2"></i>
        </button>
      </div>
        
        <form id="domicilio-form">
          <div class="modal-body">
            <h1 class="modal-title fs-5" id="modal-titulo"></h1>
            <input type="hidden" name="id_domicilio_proveedor" id="id_domicilio_proveedor">
            <div class="form-group">
              <label for="">Proveedor</label>
              <select class="form-control" name="id_proveedor" id="id_proveedor" data-placeholder="Seleccione"></select>
            </div>
            <div class="form-group">
              <label for="">Calle</label>
              <input type="text" class="form-control" name="calle" id="calle">
            </div>
            <div class="form-group">
              <label for="">Ciudad</label>
              <input type="text" class="form-control" name="ciudad" id="ciudad">
            </div>
            <div class="form-group">
              <label for="">Numero</label>
              <input type="text" class="form-control" name="numero" id="numero">
            </div>
            <div class="form-group">
              <label for="">Colonia</label>
              <input type="tel" class="form-control" name="colonia" id="colonia">
            </div>
            <div class="form-group">
              <label for="">Código postal</label>
              <input type="text" class="form-control" name="codigo_postal" id="codigo_postal">
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
    </div>
  </div>
</div>