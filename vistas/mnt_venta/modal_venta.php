<div class="modal fade" id="modalVenta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Registrar Venta</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Buscar Producto</label>
                        <input type="text" id="buscar_producto" class="form-control" placeholder="Escriba el nombre o marca...">
                        <div id="resultados_busqueda" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;"></div>
                    </div>
                    <div class="col-md-6">
                        <label>Carrito de Compra</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cant</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="carrito_body"></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">TOTAL:</th>
                                        <th id="total_venta">$0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_guardar_venta">Guardar Venta</button>
            </div>
        </div>
    </div>
</div>