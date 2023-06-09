<?php
function PUT_modificarVenta($arrayVentas, $path, $numeroPedido, $mail, $sabor, $tipo, $vaso, $cantidad){
    
    if(!isset($numeroPedido, $mail, $sabor, $tipo, $vaso, $cantidad))
        {
            echo "ERROR!! Carga de datos invalida";
        }
        else{

            $venta = new Venta($mail, $sabor, $tipo, $cantidad, 0, $vaso, "", $numeroPedido);
            $indice = Venta::VentaYaExiste($arrayVentas, $numeroPedido);
            if($indice == -1){
                echo "La venta no existe\n";
            }
            else{
                Venta::ModificarVenta($venta, $arrayVentas, $indice, $path);
            }
        }
}
?>