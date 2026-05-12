<div class="modal fade bd-example-modal" id="modalmant" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Registrar producto</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="font-icon-close-2"></i>
        </button>
      </div>
        
        <form id="producto-form">
          
          
          <div class="modal-body">
            <h1 class="modal-title fs-5" id="modal-titulo"></h1>
            <input type="hidden" name="id_producto" id="id_producto">
            <div class="form-group">
              <label for="">Categoria</label>
              <select class="form-control" name="id_categoria" id="id_categoria" data-placeholder="Seleccione"></select>
            </div>
            <div class="form-group">
              <label for="">Nombre del Producto</label>
              <input type="text" class="form-control" name="nombre_producto" id="nombre_producto">
            </div>
            <div class="form-group">
              <label for="">Descripcion del Producto</label>
              <textarea name="descripcion" id="descripcion" rows="4" cols="50">
                Descripcion del producto
              </textarea>
            </div>
            <div class="form-group">
              <label for="">Precio del Producto</label>
              <input type="text" class="form-control" name="precio" id="precio" onkeyup="handlerChanges(this.value)">
          </div>
          <div class="form-group">
              <label for="">Costo del Producto</label>
              <input type="text" class="form-control" name="costo" id="costo" onkeyup="handlerChanges2(this.value)">
          </div>
          <div class="form-group">
              <label for="">Marca del Producto</label>
              <input type="text" class="form-control" name="marca" id="marca">
          </div>
          <div class="form-group">
              <label for="">Stock Minimo</label>
              <input type="text" class="form-control" name="min_stock" id="min_stock">
          </div>
          <div class="form-group">
              <label for="">Existencias</label>
              <input type="text" class="form-control" name="stock" id="stock">
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" id="send" class="btn btn-primary">Enviar</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script>
  const handlerChanges = (value) => {
    const fieldPrice = document.getElementById("precio");
    if(isNaN(value)) {
      
      fieldPrice.style.borderColor = "red"
      fieldPrice.style.borderWidth = "2px"
      fieldPrice.style.borderStyle = "solid"

      document.getElementById("send").setAttribute("disabled", "true")
    } else {
      document.getElementById("send").removeAttribute("disabled")
      fieldPrice.style = "";
      console.log(value)
    }
  }

  const handlerChanges2 = (value) => {
    const fieldCost = document.getElementById("costo");
    if(isNaN(value)) {
      
      fieldCost.style.borderColor = "red"
      fieldCost.style.borderWidth = "2px"
      fieldCost.style.borderStyle = "solid"
      document.getElementById("send").setAttribute("disabled", "true")
    } else {
      document.getElementById("send").removeAttribute("disabled")
      fieldCost.style = "";
      console.log(value)
    }
  }
</script>