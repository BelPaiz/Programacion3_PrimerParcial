<?php
function DELETE_borrarVenta($arrayVentas, $pathVentas, $numeroPedido, $rutaEliminarImagen, $rutaImagenesVenta){
    if(!isset($numeroPedido)){
        echo "ERROR!! Carga de datos invalida";
    }
    else
    {
        $indice = Venta::VentaYaExiste($arrayVentas, $numeroPedido);
        if($indice != -1){
            Venta::BorrarVenta($arrayVentas, $pathVentas, $indice, $rutaImagenesVenta, $rutaEliminarImagen);     
        }
        else{
            echo "El numero de pedido ingresado no existe";
        }
    }
}
?>