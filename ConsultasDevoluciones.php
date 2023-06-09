<?php
function GET_consultarDevoluciones($arrayCupones, $arrayDevoluciones){
echo "a- Listar devoluciones con cupones\n";
Cupon::Listar_devoluciones_y_cupones($arrayCupones, $arrayDevoluciones, 0);
echo "b- Listar cupones y su estado\n";
Cupon::Listar_cupones($arrayCupones);
echo "c- Listar devoluciones y sus cupones y si fueron usados\n";
Cupon::Listar_devoluciones_y_cupones($arrayCupones, $arrayDevoluciones, 1);
}
?>