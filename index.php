<?php
//Paiz Belen Primer Parcial
include "generarId.php";
$pathHeladeria = "heladeria.json";
$pathVenta = "venta.json";
$pathdevoluciones = "devoluciones.json";
$pathcupones = "cupones.json";
$pathDescuentosAplicados = "descuentos.json";

$rutaImagenHelados = 'C:\xampp\htdocs\PrimerParcial\ImagenesDeHelados';
$rutaImagenVentas = 'C:\xampp\htdocs\PrimerParcial\ImagenesDeLaVenta';
$rutaImagenDevolucion = 'C:\xampp\htdocs\PrimerParcial\ImagenesDevoluciones';
$rutaImagenesBorrar = 'C:\xampp\htdocs\PrimerParcial\ImagenesBackupVentas';

$helados = Helado::LeerHeladoJson($pathHeladeria);
$ultimoIdHelado = IDGenerador::GenerarIdHelado($pathHeladeria);

$ventas = Venta::LeerVentasJson($pathVenta);
$ultimoIdVentas = IDGenerador::GenerarIdVenta($pathVenta);

$devoluciones = Devolucion::LeerDevolucionesJson($pathdevoluciones);
$ultimoIdDevoluciones = IDGenerador::GenerarIdDevolucion($pathdevoluciones);

$cupones = Cupon::LeerCuponesJson($pathcupones);
$ultimoIdCupon = IDGenerador::GenerarIdCupon($pathcupones);


switch($_SERVER["REQUEST_METHOD"])
{
    case "POST":
        if(!isset($_POST['accion'])){
            echo "ERROR!! Carga de datos invalida1";
        }
        else{
            switch($_POST['accion'])
            {
                case "alta":
                    include "HeladeriaAlta.php";
                    POST_altaHeladeria($helados, $ultimoIdHelado, $pathHeladeria, $rutaImagenHelados);
                break;
                case "consultar":
                    include "HeladoConsultar.php";
                    POST_consultarHelado($helados);
                break;
                case "altaVenta":
                     include "altaVenta.php";
                     POST_altaVenta($helados, $ventas, $cupones, $ultimoIdVentas, $pathHeladeria, $pathVenta, $pathcupones, $pathDescuentosAplicados, $rutaImagenVentas);
                break;
                case "devolucion":
                    include "DevolverHelado.php";
                    POST_devolverHelado($ventas, $devoluciones, $cupones, $pathdevoluciones, $pathcupones, $ultimoIdDevoluciones, $ultimoIdCupon, $rutaImagenDevolucion);
                break;
            }
        }
    break;
    case "GET":
        if(!isset($_GET['accion'])){
            echo "ERROR!! Carga de datos invalida";
        }
        else{
            switch($_GET['accion'])
            {
                case "consultarVentas":
                    include "ConsultasVentas.php";
                    GET_consultarVentas($ventas);
                break;
                case "consultarDevoluciones":
                    include "ConsultasDevoluciones.php";
                    GET_consultarDevoluciones($cupones, $devoluciones);
                break;
            }
        }
    break;
    case "PUT":
        $data = file_get_contents('php://input');
        parse_str(file_get_contents("php://input"),$_PUT);
        if(!isset($_PUT['accion'])){
            echo "ERROR!! Carga de datos invalida";
        }
        else{
            switch($_PUT['accion']){
                case "modificarVenta":
                    $numeroPedido = $_PUT['numeroPedido'];
                    $mail = $_PUT['mail'];
                    $sabor = $_PUT['sabor'];
                    $tipo =  $_PUT['tipo'];
                    $vaso = $_PUT['vaso'];
                    $cantidad = $_PUT['cantidad'];
                    include "ModificarVenta.php";
                    PUT_modificarVenta($ventas, $pathVenta, $numeroPedido, $mail, $sabor, $tipo, $vaso, $cantidad);
                break;
            }
        }
    break;
    case "DELETE":
        $data = file_get_contents('php://input');
        $_DELETE = json_decode($data);
        if(!isset($_DELETE->accion)){
            echo "ERROR!! Carga de datos invalida";
        }
        else{
            switch($_DELETE->accion){
                case "borrarVenta":
                    $numeroPedido = $_DELETE->numeroPedido;
                    include "borrarVenta.php";
                    DELETE_borrarVenta($ventas, $pathVenta, $numeroPedido, $rutaImagenesBorrar, $rutaImagenVentas);
                break;
            }
        }
    break;
}
?>