<?php
 class Venta extends Conexion {
    public function get_venta(){
        $conectar = parent::conectar(); #para llamar al metodo de la clase padre
        parent::set_names();

        $sql = "SELECT * FROM ventas"; #consulta 
        #ahora es un objeto
        $sql = $conectar ->prepare($sql) #usar el método prepare del objeto CONECTAR
        $sql->execute(); #ejecuta la sentencia

        $respuesta = $sql->fetchAll(); #recupera todas las filas que devuelve la consulta
        return $respuesta;
    }

    public function get_venta_id($id_venta){
        $conectar = parent::conectar(); #para llamar al metodo de la clase padre
        parent::set_names();

        $sql = "SELECT * FROM ventas WHERE id_venta = ?"; #consulta 
        #ahora es un objeto
        $sql = $conectar ->prepare($sql) #usar el método prepare del objeto CONECTAR
        $sql->bindValue(1, $id_venta)
        $sql->execute(); #ejecuta la sentencia

        $respuesta = $sql->fetchAll(); #recupera todas las filas que devuelve la consulta
        return $respuesta;
    }

    #insertar con un trigger, VENTA tiene que existir primero antes de insertar un detalle venta
    #de insertar detalle_venta
    #esta tabla no se puede editar

    public function delete_venta($id_venta){
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "DELETE FROM venta WHERE id_venta= ?"
        $sql = $conectar->prepare(sql);

        $sql->bindValue(1,$id_venta);
        $sql->execute();
    }


 }
?>
