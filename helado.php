<?php
class Helado
{
    public $sabor;
    public $precio;
    public $tipo;
    public $vaso;
    public $stock;
    public $id;

    public function __construct($sabor, $precio, $tipo, $vaso, $stock, $id)
    {
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->vaso = $vaso;
        $this->stock = $stock;
        $this->id = $id; 
    }

    public function HeladoYaExisteVaso($arrayHelados)
    {
        $index = -1;
        if(count($arrayHelados) > 0){
            foreach($arrayHelados as $indice => $helado){
                if($this->sabor == $helado->sabor && $this->tipo == $helado->tipo && $this->vaso == $helado->vaso){
                    $index = $indice;
                    break;
                }
            }
        } 
        return $index;
    }

    public function HeladoYaExiste($arrayHelados)
    {
        $index = -1;
        if(count($arrayHelados) > 0){
            foreach($arrayHelados as $indice => $helado){
                if($this->sabor == $helado->sabor && $this->tipo == $helado->tipo){
                    $index = $indice;
                    break;
                }
            }
        } 
        return $index;
    }
    public static function ConsultarStock($arrayHelados, $indice){
        $stock = $arrayHelados[$indice]->stock;
        
        return $stock;
    }
    public static function Descontarstock($helado, $arrayhelados, $indice, $path)
    {
        $arrayhelados[$indice]->stock -= $helado->stock;
        echo "Nueva stock de: ". $arrayhelados[$indice]->sabor. " dde tipo: ". $arrayhelados[$indice]->tipo. " es: ". $arrayhelados[$indice]->stock."\n";
        $heladoJson = json_encode($arrayhelados);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $heladoJson)) !== FALSE) 
            {
                echo "Stock actualizado\n";
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
    public static function LeerHeladoJson($path){
        $datos = "";
        $arrayHelados = array();
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
                        $nuevoHelado = new Helado($buffer[0]["sabor"], $buffer[0]["precio"], $buffer[0]["tipo"], $buffer[0]["vaso"], $buffer[0]["stock"], $buffer[0]["id"]);
                        array_push($arrayHelados, $nuevoHelado);
                    }
                    else{ 
                        foreach($buffer as $i){
                            $nuevoHelado = new Helado($i["sabor"], $i["precio"], $i["tipo"], $i["vaso"], $i["stock"], $i["id"]);
                            array_push($arrayHelados, $nuevoHelado); 
                        }
                    }    
                }
                       
                fclose($archivo);
            }
        }
        
        return $arrayHelados;
    }
    public static function AltaHelado($arrayHelados, $path){
        $heladosJson = json_encode($arrayHelados);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "No se creo el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $heladosJson)) !== FALSE) 
            {
                echo "Ingresado\n";
            }
        }
        fclose($archivo);
    }
    public function DefinirDestinoImagen($ruta){

        $destino = $ruta."\\".$this->sabor."-".$this->tipo.".png";
        return $destino;
    }
    public static function AgregarStock($helado, $arrayhelados, $indice, $path)
    {
        $arrayhelados[$indice]->stock += $helado->stock;
        echo "Nuevo Stock de: ". $arrayhelados[$indice]->sabor. " dde tipo: ". $arrayhelados[$indice]->tipo. " es: ". $arrayhelados[$indice]->stock."\n";
        $heladoJson = json_encode($arrayhelados);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $heladoJson)) !== FALSE) 
            {
                echo "Actualizado\n";
            }
        }
        fclose($archivo);
    }
    public static function ActualizarPrecio($helado, $arrayhelados, $indice, $path)
    {
        $arrayhelados[$indice]->precio = $helado->precio;
        echo "Nuevo precio de: ". $arrayhelados[$indice]->sabor. " de tipo: ". $arrayhelados[$indice]->tipo. " es: ". $arrayhelados[$indice]->precio."\n";
        $heladoJson = json_encode($arrayhelados);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $heladoJson)) !== FALSE) 
            {
                echo "Actualizado\n";
            }
        }
        fclose($archivo);
    }
    public function ExisteTipo($arrayHelados){
        $index = -1;
        if(count($arrayHelados) > 0){
            foreach($arrayHelados as $indice => $helado){
                if($this->tipo == $helado->tipo){
                    $index = $indice;
                    break;
                }
            }
        } 
        return $index;
    }
    public function ExisteSabor($arrayHelados){
        $index = -1;
        if(count($arrayHelados) > 0){
            foreach($arrayHelados as $indice => $helado){
                if($this->sabor == $helado->sabor){
                    $index = $indice;
                    break;
                }
            }
        } 
        return $index;
    }
    public static function ConsultarPrecio($arrayHelados, $indice){
        $precio = $arrayHelados[$indice]->precio;
        return $precio;
    }
}

?>