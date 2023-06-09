<?php
function POST_devolverHelado($arrayVentas, $arrayDevoluciones, $arrayCupones, $pathdevoluciones, $pathcupones, $idDevolucion, $idCupon, $rutaImagenDevolucion){
    if(!isset($_POST['numeroPedido'],  $_POST['motivo'], $_FILES['imagen']))
    {
        echo "ERROR!! Carga de datos invalida";
    }
    else
    {
        $numeroPedido = $_POST['numeroPedido'];
        $motivo = $_POST['motivo'];
        $imagen = $_FILES['imagen'];

        $indice = Venta::VentaYaExiste($arrayVentas, $numeroPedido);
        if($indice != -1){
            $devolucion = new Devolucion($numeroPedido, $motivo, $idDevolucion);
            array_push($arrayDevoluciones, $devolucion);
            Devolucion::RealizarDevolucion($arrayDevoluciones, $pathdevoluciones);
            $destino = $devolucion->DefinirDestinoImagen($rutaImagenDevolucion);
            if(move_uploaded_file($imagen['tmp_name'], $destino))
            {
                 echo "Se guardo la imagen en: ", $destino, "\n";
            }
            else{
                    echo "La imagen sigue en: ", $imagen['tmp_name'], "\n";
            }
            $cupon = new Cupon($idCupon, $idDevolucion);
            array_push($arrayCupones, $cupon);
            Cupon::RealizarCupon($arrayCupones, $pathcupones);

        }
        else
        {
            echo "El numero de pedido ingresado no existe";
        }
    }
}
?>