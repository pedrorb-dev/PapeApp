<div class="modal fade bd-example-modal" id="modalmant" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="font-icon-close-2"></i>
        </button>
      </div>
        
        <form id="categoria-form">
          
          
          <div class="modal-body">
            <h1 class="modal-title fs-5" id="modal-titulo">Ingresar Categoria</h1>
            <input type="hidden" name="id_categoria" id="id_categoria">
            <div class="form-group">
              <label for="">Nombre de la categoria</label>
              <input type="text" id="nombre_categoria" name="nombre_categoria" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
    </div>
  </div>
</div>