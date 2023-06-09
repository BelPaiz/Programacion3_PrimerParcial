<?php

function GET_consultarVentas($arrayVentas){
    if(!isset($_GET['fechaConsulta'], $_GET['mail'], $_GET['fechaInicio'], $_GET['fechaLimite'], $_GET['sabor'], $_GET['vaso']))
    {
        echo "ERROR!! Carga de datos invalida";
    }
    else{
        $fechaConsultar = $_GET['fechaConsulta'];
        $mail = $_GET['mail'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaLimite = $_GET['fechaLimite'];
        $sabor = $_GET['sabor'];
        $vaso = $_GET['vaso'];

        $arrayFiltrado = Venta::FiltrarVentasPorFecha($arrayVentas, $fechaConsultar);
        $cantidasVendidos = Venta::CantidadTotalDeHeladosVendidos($arrayFiltrado);
        echo "a- La cantidad de helados vendidos el dia: ",$fechaConsultar, " es: " ,$cantidasVendidos, "\n\n";

        $arrayFiltradoUsuario = Venta::FiltrarPorUsuario($arrayVentas, $mail);
        echo "b- Listado de ventas del usuario: ", $mail, "\n";
        Venta::MostrarVentas($arrayFiltradoUsuario);

        $arrayFiltradoRangoDeFechas = Venta::FiltrarVentasPorRangoDeFechas($arrayVentas, $fechaInicio, $fechaLimite);
        $arrayFiltradoOrdenado = Venta::OrdenarVentasPorMail($arrayFiltradoRangoDeFechas);
        echo "c- Listados de ventas entre: ", $fechaInicio," y ", $fechaLimite, "Ordenado por mail", "\n";
        Venta::MostrarVentas($arrayFiltradoOrdenado);

        $arrayFiltradoSabor = Venta::FiltrarPorSabor($arrayVentas, $sabor);
        echo "d- Listado de ventas del sabor: ", $sabor, "\n";
        Venta::MostrarVentas($arrayFiltradoSabor);

        $arrayFiltradoVaso = Venta::FiltrarPorVaso($arrayVentas, $vaso);
        echo "e- Listado de ventas del vaso: ", $vaso, "\n";
        Venta::MostrarVentas($arrayFiltradoVaso);

    }
}
?>