<?php
include "devoluciones.php";
class Cupon
{
    public $id;
    public $id_devolucion;
    public $porcentajeDescuento;
    public $estado;

    public function __construct($id, $id_devolucion, $porcentaje = null, $estado = null)
    {
        $this->id = $id;
        $this->id_devolucion = $id_devolucion;
        if($porcentaje == null){
            $this->porcentajeDescuento = 10;
        }
        else{
            $this->porcentajeDescuento = $porcentaje;
        }
        if($estado == null){
            $this->estado = 0;
        }
        else{
            $this->estado = $estado;
        }
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
    public static function LeerCuponesJson($path){
        $datos = "";
        $arrayCupones = array();
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
                        $nuevoCupon = new Cupon($buffer[0]["id"], $buffer[0]["id_devolucion"], $buffer[0]["porcentajeDescuento"], $buffer[0]["estado"]);
                        array_push($arrayCupones, $nuevoCupon);
                    }
                    else{ 
                        foreach($buffer as $i){
                            $nuevoCupon = new Cupon($i["id"], $i["id_devolucion"], $i["porcentajeDescuento"], $i["estado"]);
                            array_push($arrayCupones, $nuevoCupon); 
                        }
                    }    
                }
                       
                fclose($archivo);
            }
        }
        
        return $arrayCupones;
    }
    public static function RealizarCupon($arrayCupones, $path)
    {
        $cuponesJson = json_encode($arrayCupones);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "No se creo el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $cuponesJson)) !== FALSE) 
            {
                echo "Cupón registrado\n";
            }
        }
        fclose($archivo);
    }
    public static function CuponYaExiste($arrayCupones, $id)
    {
        $index = -1;
        if(count($arrayCupones) > 0){
            foreach($arrayCupones as $indice => $cupon){
                if($cupon->id == $id){
                    $index = $indice;
                    break;
                }
            }
        } 
        return $index;
    }
    public static function CambiarEstadoCupon($estado, $arrayCupones, $indice, $path)
    {
        $arrayCupones[$indice]->estado = $estado;
        

        $ventaJson = json_encode($arrayCupones);
        $archivo = fopen($path, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo\n";
        } else 
        {
            if ((fwrite($archivo, $ventaJson)) !== FALSE) 
            {
                echo "Archivo de cupones actualizado\n";
            }
        }
        fclose($archivo);
    }
    public static function ConsultarEstadoCupon($arrayCupones, $indice)
    {
        $estado = $arrayCupones[$indice]->estado;
        return $estado;
    }
    public static function TraerCupon($arrayCupones, $indice)
    {
        $cupon = $arrayCupones[$indice];
        return $cupon;
    }
    public function UsarCupon($precio, $cantidad, $pathDescuentos)
    {
        $precioTotal = $precio * $cantidad;
        $precioFinal = $precioTotal - ($precioTotal * ($this->porcentajeDescuento / 100));
        $descuentosExistentes = array();
        $descuentoDatos = array(
            'precioFinal' => $precioFinal,
            'porcentajeDescuentoAplicado' => $this->porcentajeDescuento
        );
        $descuentosExistentes[] = $this::LeerJsonDescuentos($pathDescuentos);
        $descuentosExistentes[] = $descuentoDatos;
        $datosJson = json_encode($descuentosExistentes);

        $archivo = fopen($pathDescuentos, "w");

        if ($archivo == FALSE) {
            echo "Hay un problema con el archivo de descuentos\n";
        } else 
        {
            if ((fwrite($archivo, $datosJson)) !== FALSE) 
            {
                echo "Datos del descuento guardados\n";
            }
        }
        fclose($archivo);
    }
    public static function LeerJsonDescuentos($pathDescuentos)
    {
        $datos = "";
        $arrayExistente = array();
        if(file_exists($pathDescuentos)){
            $jsonString = file_get_contents($pathDescuentos);
            if($jsonString == null)
            {
                echo "El archivo no existe";
            }
            else
            {
                $arrayExistente = json_decode($jsonString, true);
            }
        }
        return $arrayExistente;
    }
    public static function Listar_devoluciones_y_cupones($arrayCupones, $arrayDevoluciones, $mostrarEstado){
        if(count($arrayCupones) > 0){
            foreach($arrayCupones as $cupon){
                foreach($arrayDevoluciones as $devolucion){
                    if($cupon->id_devolucion == $devolucion->id){
                        echo "Id Devolucion: ", $devolucion->id, "\n";
                        echo "Motivo: ", $devolucion->motivo, "\n";
                        echo "Numero del pedido: ", $devolucion->numeroDePedido, "\n";
                        echo "Id Cupon: ", $cupon->id, "\n";
                        echo "Porcentaje del descuento: ", $cupon->porcentajeDescuento, "%","\n";
                        if($mostrarEstado == 1){
                            if($cupon->estado == 0){
                                echo "Estado: No utilizado\n";
                            }
                            else{
                                echo "Estado: Utilizado\n";
                            }
                        }
                        echo "*******************************************\n";
                       
                    }
                }
            }
        }
        else{
            echo "No se encontraron devoluciones\n";
        }
    }
    public static function Listar_cupones($arrayCupones){
        if(count($arrayCupones) > 0){
            foreach($arrayCupones as $cupon){
                echo "Id Cupon: ", $cupon->id, "\n";
                echo "Id Devolucion: ", $cupon->id_devolucion, "\n";
                echo "Porcentaje del descuento: ", $cupon->porcentajeDescuento, "%","\n";
                if($cupon->estado == 0){
                    echo "Estado: No utilizado\n";
                }
                else{
                    echo "Estado: Utilizado\n";
                }
                echo "*******************************************\n";
            }
        }
        else{
            echo "No se encontraron cupones\n";
        }
    }

}
?>