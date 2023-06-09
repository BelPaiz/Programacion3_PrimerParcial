<?php
class Venta
{
    public $mail;
    public $sabor;
    public $tipo;
    public $stock;
    public $fecha;
    public $numeroDePedido;
    public $id;
    public $vaso;

    public function __construct($mail, $sabor, $tipo, $stock, $id, $vaso ,$fecha = null, $numeroDePedido = null)
    {
       $this->mail = $mail;
       $this->sabor = $sabor;
       $this->tipo = $tipo;
       $this->stock = $stock;
       $this->id = $id;
       if($fecha == null){
        $this->fecha =  date("d-m-Y");
       }
       else{
        $this->fecha = $fecha;
       }
       if($numeroDePedido == null){
        $this->numeroDePedido = rand(1, 100000);
       }
       else{
        $this->numeroDePedido = $numeroDePedido;
       }
        $this->vaso = $vaso;
       
    }
    public static function VentaYaExiste($arrayVentas, $numeroDePedido)
    {
        $index = -1;
        if(count($arrayVentas) > 0){
            foreach($arrayVentas as $indice => $venta){
                if($venta->numeroDePedido == $numeroDePedido){
                    $index = $indice;
                    break;
                }
            }
        } 
        return $index;
    }
    public static function ModificarVenta($venta, $arrayVentas, $indice, $path)
    {
        $arrayVentas[$indice]->mail = $venta->mail;
        $arrayVentas[$indice]->sabor = $venta->sabor;
        $arrayVentas[$indice]->tipo = $venta->tipo;
        $arrayVentas[$indice]->stock = $venta->stock;
        $arrayVentas[$indice]->vaso = $venta->vaso;

        $ventaJson = json_encode($arrayVentas);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $ventaJson)) !== FALSE) 
            {
                echo "Archivo de ventas actualizado\n";
            }
        }
        fclose($archivo);
    }
    public static function RealizarVenta($arrayVentas, $path)
    {
        $ventasJson = json_encode($arrayVentas);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "No se creo el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $ventasJson)) !== FALSE) 
            {
                echo "Venta registrada\n";
            }
        }
        fclose($archivo);
    }
    public static function LeerIdJson($path){
        $id = 0;
        $datos = "";
        $bufferId = -1;
        if(file_exists($path)){
            $archivo = fopen($path, "r");
            if($archivo == FALSE)
            {
                echo "El archivo no existe";
            }
            else
            {
                while (!feof($archivo))
                {
                    $datos .= fgets($archivo);    
                }
                $buffer = json_decode($datos, true);
                if($buffer != null){
                    if(count($buffer)==1){
                        $id = $buffer[0]['id'];
                    }
                    else{
                        
                        foreach($buffer as $i){
                            $bufferId = $i['id'];
                                if($bufferId > $id)
                                {
                                    $id = $bufferId;
                                }
                        }
                    }
                }
                fclose($archivo);
            }
        }
        return (int)$id;
    }
    public static function LeerVentasJson($path){
        $datos = "";
        $arrayVentas = array();
        if(file_exists($path)){
            $archivo = fopen($path, "r");
            if($archivo == FALSE)
            {
                echo "El archivo no existe";
            }
            else
            {
                while (!feof($archivo))
                {
                    $datos .= fgets($archivo);
                }
                $buffer = json_decode($datos, true);
                if($buffer != null){
                    if(count($buffer)==1){
                        $nuevaVenta = new Venta($buffer[0]["mail"], $buffer[0]["sabor"], $buffer[0]["tipo"], $buffer[0]["stock"], $buffer[0]["id"],$buffer[0]["vaso"], $buffer[0]["fecha"], $buffer[0]["numeroDePedido"]);
                        array_push($arrayVentas, $nuevaVenta);
                    }
                    else{ 
                        foreach($buffer as $i){
                            $nuevaVenta = new Venta($i["mail"], $i["sabor"], $i["tipo"], $i["stock"], $i["id"], $i["vaso"], $i["fecha"], $i["numeroDePedido"]);
                            array_push($arrayVentas, $nuevaVenta); 
                        }
                    }    
                }
                       
                fclose($archivo);
            }
        }
        
        return $arrayVentas;
    }
    public function DefinirDestinoImagen($ruta){
        $usuarioMail = strtok($this->mail, '@');

        $destino = $ruta."\\".$this->sabor."-".$this->tipo."-".$usuarioMail.".png";
        return $destino;
    }
    public static function CantidadTotalDeHeladosVendidos($arrayVentas)
    {
        $sumatoria = 0;
        if(count($arrayVentas) > 0)
        {
            foreach($arrayVentas as $helado){
                
                $sumatoria += (int)$helado->stock;
            }
        }
        return $sumatoria;
    }
    public static function FiltrarVentasPorFecha($arrayVentas, $fecha)
    {
        $nuevoArrayFiltrado = array();
        if(count($arrayVentas) > 0)
        {
            foreach($arrayVentas as $venta){
                if($venta->fecha == $fecha){
                    array_push($nuevoArrayFiltrado, $venta);
                }
            }
        }
        return $nuevoArrayFiltrado;
    }
    public static function FiltrarPorUsuario($arrayVentas, $mail)
    {
        $nuevoArrayFiltrado = array();
        if(count($arrayVentas) > 0)
        {
            foreach($arrayVentas as $venta){
                if($venta->mail == $mail){
                    array_push($nuevoArrayFiltrado, $venta);
                }
            }
        }
        return $nuevoArrayFiltrado;
    }
    public static function MostrarVentas($arrayVentas){
        if(count($arrayVentas) > 0){
            foreach($arrayVentas as $venta){
            
                echo "Usuario: ", $venta->mail, "\n";
                echo "sabor: ", $venta->sabor, "\n";
                echo "tipo: ", $venta->tipo, "\n";
                echo "cantidad: ", $venta->stock, "\n";
                echo "fecha: ", $venta->fecha, "\n";
                echo "numero de pedido: ", $venta->numeroDePedido, "\n";
                echo "vaso: ", $venta->vaso, "\n";
                echo "id: ", $venta->id, "\n\n";
            }
        }
        else{
            echo "No se encontraron coincidencias\n";
        }
    }
    public function FechaDentroRango($fechaInicio, $fechaLimite)
    {
        if($this->fecha >= $fechaInicio && $this->fecha <=$fechaLimite)
        {
            return true;
        }
        return false;
    }
    public static function FiltrarVentasPorRangoDeFechas($arrayVentas, $fechaInicio, $fechaLimite)
    {
        $nuevoArrayFiltrado = array();
        if(count($arrayVentas) > 0)
        {
            foreach($arrayVentas as $venta){
                if($venta->FechaDentroRango($fechaInicio, $fechaLimite)){
                    array_push($nuevoArrayFiltrado, $venta);
                }
            }
        }
        return $nuevoArrayFiltrado;
    }
    public static function CompareMail($a, $b){
        return strcmp($a->mail, $b->mail);
    }
    public static function OrdenarVentasPorMail($arrayVentas){
        usort($arrayVentas, 'Venta::CompareMail');
        return $arrayVentas;
    }

    public static function FiltrarPorSabor($arrayVentas, $sabor)
    {
        $nuevoArrayFiltrado = array();
        if(count($arrayVentas) > 0)
        {
            foreach($arrayVentas as $venta){
                if($venta->sabor == $sabor){
                    array_push($nuevoArrayFiltrado, $venta);
                }
            }
        }
        return $nuevoArrayFiltrado;
    }
    public static function FiltrarPorVaso($arrayVentas, $vaso)
    {
        $nuevoArrayFiltrado = array();
        if(count($arrayVentas) > 0)
        {
            foreach($arrayVentas as $venta){
                if($venta->vaso == $vaso){
                    array_push($nuevoArrayFiltrado, $venta);
                }
            }
        }
        return $nuevoArrayFiltrado;
    }
    public static function BorrarVenta($arrayVentas, $path, $indice, $rutaImagenes, $rutaEliminarImagen){
        $nombreImagenOrigen = $arrayVentas[$indice]->DefinirDestinoImagen($rutaImagenes);
        $destinoImagenBorrada = $arrayVentas[$indice]->DefinirDestinoImagen($rutaEliminarImagen);
        
        unset($arrayVentas[$indice]);
        $arrayVentas = array_values($arrayVentas);

        $ventaJson = json_encode($arrayVentas);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $ventaJson)) !== FALSE) 
            {
                echo "Archivo de ventas actualizado\n";
            }
        }
        fclose($archivo);
        if(rename($nombreImagenOrigen, $destinoImagenBorrada))
        {
            echo "Se guardo la imagen en: ", $destinoImagenBorrada;
        }
        else{
            echo "La imagen sigue en: ", $nombreImagenOrigen;
        }
    }
}
?>