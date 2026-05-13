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
              <select required class="form-control" name="id_categoria" id="id_categoria" data-placeholder="Seleccione"></select>
            </div>
            <div class="form-group">
              <label for="">Nombre del Producto</label>
              <input required type="text" class="form-control" name="nombre_producto" id="nombre_producto">
            </div>
            <div class="form-group">
              <label for="">Descripcion del Producto</label>
              <textarea name="descripcion" id="descripcion" rows="4" cols="50">
                Descripcion del producto
              </textarea>
            </div>
            <div class="form-group">
              <label for="">Precio del Producto</label>
              <input required type="text" class="form-control" name="precio" id="precio" onkeyup="handlerChanges(this.value, 'precio')">
          </div>
          <div class="form-group">
              <label for="">Costo del Producto</label>
              <input required type="text" class="form-control" name="costo" id="costo" onkeyup="handlerChanges(this.value, 'costo')">
          </div>
          <div class="form-group">
              <label for="">Marca del Producto</label>
              <input required type="text" class="form-control" name="marca" id="marca">
          </div>
          <div class="form-group">
              <label for="">Stock Minimo</label>
              <input required type="text" class="form-control" name="min_stock" id="min_stock">
          </div>
          <div class="form-group">
              <label for="">Existencias</label>
              <input required type="text" class="form-control" name="stock" id="stock">
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" id="send" class="btn btn-primary" onclick="validate()">Enviar</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script>
  const handlerChanges = (value, id) => {
    const field = document.getElementById(`${id}`);
    if(isNaN(value) || value === undefined) {
      
      field.style.borderColor = "red"
      field.style.borderWidth = "2px"
      field.style.borderStyle = "solid"

      document.getElementById("send").setAttribute("disabled", "true")
    } else {
      document.getElementById("send").removeAttribute("disabled")
      field.style = "";
    }
  }

  const validate = () => {
    const fieldPrice = document.getElementById("precio").value;
    const fieldCost = document.getElementById("costo").value;
  
    if(Number(fieldCost) > Number(fieldPrice)) {
      alert("El precio debe ser mayor al costo")
      document.getElementById("send").setAttribute("disabled", "true")
    } else {
      document.getElementById("send").removeAttribute("disabled")
    }
  }
</script>