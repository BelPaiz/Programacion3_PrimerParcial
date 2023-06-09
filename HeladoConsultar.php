<?php
    function POST_consultarHelado($arrayHelados){
        if(!isset($_POST['sabor'],  $_POST['tipo']))
        {
            echo "ERROR!! Carga de datos invalida";
        }
        else{
            $sabor = $_POST['sabor'];
            $tipo =  $_POST['tipo'];
            $helado = new Helado($sabor, 0, $tipo, "", 0, 0);
            $indice = $helado->HeladoYaExiste($arrayHelados);
            if($indice == -1){
                $indiceSabor = $helado->ExisteSabor($arrayHelados);
                $indiceTipo = $helado->ExisteTipo($arrayHelados);
                if($indiceSabor == -1){
                    echo "No existe sabor\n";
                }
                else{
                    echo "No existe tipo \n"; 
                }
            }
            else{
                echo "Existe \n";
            }
        }
    }
?>