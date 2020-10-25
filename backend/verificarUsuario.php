<?php

require('../clases/fabrica.php');
require('./validarSesion.php');

$_pathDirectorioEmpleados = "../archivos";
$_pathArchivoEmpleados = $_pathDirectorioEmpleados . "/empleados.txt";

$_pathMostrar = "./mostrar.php";

$_pathLogin= "../login.html";

$existe = FALSE;

if(isset($_POST["txtDni"]) && isset($_POST["txtApellido"]))
{
    $dniEmpleado = $_POST["txtDni"];
    $apellidoEmpleado = $_POST["txtApellido"];

    if(is_dir($_pathDirectorioEmpleados))//si existe el directorio
    {
        if($_archivoEmpleados = fopen($_pathArchivoEmpleados, "r+"))//intento abrir el archivo
        {
            if ('' != file_get_contents($_pathArchivoEmpleados))//si contiene algo el archivo
            {
                while(!feof($_archivoEmpleados))
                {
                    $empleado = fgets($_archivoEmpleados);

                    $datosEmpleado = explode(" - ", $empleado);
                    $datosEmpleado[0] = trim($datosEmpleado[0]);

                    if($datosEmpleado[0] != '')
                    {
                        $datosEmpleado[6] = trim($datosEmpleado[6], "\r\n");

                        $empleado = new Empleado($datosEmpleado[0], $datosEmpleado[1], $datosEmpleado[2], $datosEmpleado[3],$datosEmpleado[4],$datosEmpleado[5],$datosEmpleado[6]);

                        if($empleado->GetDni() == $dniEmpleado && $empleado->GetApellido() == $apellidoEmpleado)
                        {
                            $existe = TRUE;
                            break;
                        }//if los datos coinciden
                        else
                        {
                            echo 'Los datos ingresados no coinciden con los de ningun empleado en la fabrica.<br>Se redireccionara al login. Si no se redirecciona, cliquee aqui: <a href="../login.html">Volver al login.</a>';
                            header("refresh:5;url=".$_pathLogin); 
                        }
                    }//if puedo crear al empleado
                }//while feof
                if($existe)
                {
                    $_SESSION["DNIEmpleado"] = $dniEmpleado;
                    header("Location: ../index.html");
                }
             
            fclose($_archivoEmpleados);
            }//if contenido
            else
            {
                echo "El archivo esta vacio.";
            }
        }
        else
        {
            echo "NO se pudo abrir el archivo.";
        }
    }
    else
    {
        echo "NO se pudo abrir el directorio.";
    }
}
else
{
    echo "NO se pudo obtener los datos.";
}