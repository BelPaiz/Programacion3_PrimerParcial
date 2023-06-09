<?php
function POST_altaVenta($arrayHelados, $arrayVentas, $arrayCupones, $id, $pathHelado, $pathVentas, $pathCupones, $pathDescuentos, $rutaImagenVenta){
    if(!isset($_POST['mail'],  $_POST['sabor'],  $_POST['tipo'],  $_POST['stock'], $_POST['vaso'], $_FILES['imagen'], $id))
    {
        echo "ERROR!! Carga de datos invalida";
    }
    else{
        $mail = $_POST['mail'];
        $sabor = $_POST['sabor'];
        $tipo =  $_POST['tipo'];
        $stock = $_POST['stock'];
        $imagen = $_FILES['imagen'];
        $vaso = $_POST['vaso'];
        if(!isset($_POST['id_cupon'])){
            $id_cupon = null;
        }
        else{
            $id_cupon = $_POST['id_cupon'];
        }
        $venta = new Venta($mail, $sabor, $tipo, $stock, $id, $vaso);
        $helado = new Helado($sabor, 0, $tipo, $vaso , $stock, 0);
        $indice = $helado->HeladoYaExisteVaso($arrayHelados);
        
        if($indice == -1){
            echo "No hay helado de esa variedad\n";
        }
        else{
            $stockDisponibleHelado = Helado::ConsultarStock($arrayHelados, $indice);
            if($stockDisponibleHelado >= $stock){
                array_push($arrayVentas, $venta);
                Venta::RealizarVenta($arrayVentas, $pathVentas);
                Helado::Descontarstock($helado, $arrayHelados, $indice, $pathHelado);
                $destino = $venta->DefinirDestinoImagen($rutaImagenVenta);
                if(move_uploaded_file($imagen['tmp_name'], $destino))
                {
                    echo "Se guardo la imagen en: ", $destino, "\n";
                }
                else{
                    echo "La imagen sigue en: ", $imagen['tmp_name'], "\n";
                }
            }
            else{
                echo "No hay stock disponible\n";
            }
            if($id_cupon != null){
                $indiceCupon = Cupon::CuponYaExiste($arrayCupones, $id_cupon);
                if($indiceCupon == -1){
                    echo "Cupon invalido\n";
                }
                else{  
                    $estadoCupon = Cupon::ConsultarEstadoCupon($arrayCupones, $indiceCupon);
                    if($estadoCupon == 1){
                        echo "Cupon ya utilizado\n";
                    }
                    else{
                        Cupon::CambiarEstadoCupon(1, $arrayCupones, $indiceCupon, $pathCupones);
                        $cupon = Cupon::TraerCupon($arrayCupones, $indiceCupon);
                        $precioHelado = Helado::ConsultarPrecio($arrayHelados, $indice);
                        $cupon->UsarCupon($precioHelado, $stock, $pathDescuentos);
                    }
                }
            }
        }
    }
}
?>