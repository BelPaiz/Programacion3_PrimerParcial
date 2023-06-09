<?php
include "helado.php";
include "venta.php";

include "cupon.php";


class IDGenerador
{
    private static $ultimoIdHelado = 0;
    private static $ultimoIdVenta = 0;
    private static $ultimoIdDevolucion = 0;
    private static $ultimoIdCupon = 0;

    public static function GenerarIdHelado($path){
        IDGenerador::$ultimoIdHelado = (Helado::LeerIdJson($path))+1;
        return IDGenerador::$ultimoIdHelado;
    }
    public static function GenerarIdVenta($path){
        IDGenerador::$ultimoIdVenta = (Venta::LeerIdJson($path))+1;
        return IDGenerador::$ultimoIdVenta;
    }
    public static function GenerarIdDevolucion($path){
        IDGenerador::$ultimoIdDevolucion = (Devolucion::LeerIdJson($path))+1;
        return IDGenerador::$ultimoIdDevolucion;
    }
    public static function GenerarIdCupon($path){
        IDGenerador::$ultimoIdCupon = (Cupon::LeerIdJson($path))+1;
        return IDGenerador::$ultimoIdCupon;
    }
}
?>