<?php
    class Devolucion
    {
        public $numeroDePedido;
        public $motivo;
        public $id;

        public function __construct($numeroDePedido, $motivo, $id)
        {
            $this->numeroDePedido = $numeroDePedido;
            $this->motivo = $motivo;
            $this->id = $id;
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
        public static function LeerDevolucionesJson($path){
            $datos = "";
            $arrayDevoluciones = array();
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
                            $nuevaDevolucion = new Devolucion($buffer[0]["numeroDePedido"], $buffer[0]["motivo"], $buffer[0]["id"]);
                            array_push($arrayDevoluciones, $nuevaDevolucion);
                        }
                        else{ 
                            foreach($buffer as $i){
                                $nuevaDevolucion = new Devolucion($i["numeroDePedido"], $i["motivo"], $i["id"]);
                                array_push($arrayDevoluciones, $nuevaDevolucion); 
                            }
                        }    
                    }
                           
                    fclose($archivo);
                }
            }
            
            return $arrayDevoluciones;
        }
        public static function RealizarDevolucion($arrayDevoluciones, $path)
        {
            $devolucionesJson = json_encode($arrayDevoluciones);
            $archivo = fopen($path, "w");

            if ($archivo == FALSE) {
                echo "No se creo el archivo\n";
            } else 
            {
                if ((fwrite($archivo, $devolucionesJson)) !== FALSE) 
                {
                    echo "Devolucion registrada\n";
                }
            }
            fclose($archivo);
        }
        public function DefinirDestinoImagen($ruta){
    
            $destino = $ruta."\\".$this->numeroDePedido."-".$this->id.".png";
            return $destino;
        }
    }
?>