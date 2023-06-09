<?php
function POST_altaHeladeria($arrayHelados, $id, $pathHelados, $rutaImagen){
    if(!isset($_POST['sabor'], $_POST['precio'], $_POST['tipo'],  $_POST['vaso'], $_POST['stock'], $_FILES['imagen'], $id))
    {
        echo "ERROR!! Carga de datos invalida";
    }
    else{
        $sabor = $_POST['sabor'];
        $precio = $_POST['precio'];
        $tipo =  $_POST['tipo'];
        $vaso = $_POST['vaso'];
        $stock = $_POST['stock'];
        $imagen = $_FILES['imagen'];
        

        $helado = new Helado($sabor, $precio, $tipo, $vaso, $stock, $id);

        $indice = $helado->HeladoYaExiste($arrayHelados);
        if($indice == -1){
            array_push($arrayHelados, $helado);
            Helado::AltaHelado($arrayHelados, $pathHelados);
            $destino = $helado->DefinirDestinoImagen($rutaImagen);
            if(move_uploaded_file($imagen['tmp_name'], $destino))
            {
                echo "Se guardo la imagen en: ", $destino;
            }
            else{
                echo "La imagen sigue en: ", $imagen['tmp_name'];
            }
        }
        else{
            Helado::AgregarStock($helado, $arrayHelados, $indice, $pathHelados);
            Helado::ActualizarPrecio($helado, $arrayHelados, $indice, $pathHelados);
        }
    }
}
?>