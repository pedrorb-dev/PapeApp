<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalUsuarioLabel">Registrar Usuario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <input type="hidden" id="id_usuario" value="">
                
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name = "nombre_usuario" id="nombre_usuario" placeholder="Nombre de usuario">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Contraseña">
                    <small class="text-muted" id="pass_help">Dejar en blanco para no cambiar</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select class="form-control" id="rol">
                        <option value="empleado">Empleado</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_guardar_usuario">Guardar</button>
            </div>
        </div>
    </div>
</div>