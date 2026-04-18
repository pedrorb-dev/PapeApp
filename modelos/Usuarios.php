<?php
    class Usuarios extends Conexion {

        public function get_usuario(){
            $conectar = parent::conectar();
            parent::set_names();
            $sql = "SELECT * FROM usuarios";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_usuario_id($id_usuario){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_usuario);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;     
        }

        public function insert_usuario($nombre, $contraseña, $rol) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO usuarios(id_usuario, nombre_usuario, contrasena, rol) 
                        VALUES (NULL,?, ?, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $nombre);
            $sql -> bindValue(2, $contraseña);
            $sql -> bindValue(2, $rol);
            $sql->execute();
        }

        public function delete_usuario($id_usuario) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM usuarios WHERE id_usuario = ? ";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_usuario);
            $sql->execute();
        }

        public function update_usuario($id_prov, $id_prod) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE usuarios
                        SET  nombre_usuario, contrasena, rol
                        WHERE id_usuario = ?";
            $sql = $conectar -> prepare($sql);

            $sql -> bindValue(1, $id_usuario);

            $sql->execute();
        }

    }

?>