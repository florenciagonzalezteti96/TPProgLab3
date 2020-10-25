<?php

require('empleado.php');
require('interfaces.php');

class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    public function __construct($razonSocial, $cantidadMaxima = 5)
    {
        $this->_razonSocial = $razonSocial;
        $this->_empleados = array();
        $this->_cantidadMaxima = $cantidadMaxima;
    }

    public function AgregarEmpleado($emp)
    {
        $seAgrego = FALSE;
        if (($emp instanceof Empleado) && (count($this->_empleados) < $this->_cantidadMaxima)) {
            array_push($this->_empleados, $emp);
            $seAgrego = TRUE;
            $this->EliminarEmpleadosRepetidos();
        }
        return $seAgrego;
    }

    public function CalcularSueldos()
    {
        $totalSueldos = 0;
        foreach ($this->_empleados as $arraydeEmpleados => $empleado) {
            $totalSueldos += $empleado->GetSueldo();
        }
        return $totalSueldos;
    }

    public function EliminarEmpleado($emp)
    {
        $seElimino = FALSE;
        if ($emp != null) {
            for ($i = 0; $i < count($this->_empleados); $i++) {
                if ($this->_empleados[$i] == $emp) {
                    unlink($this->_empleados[$i]->GetPathFoto());
                    unset($this->_empleados[$i]);
                    $this->_empleados = array_values($this->_empleados);
                    $seElimino = TRUE;
                }
            }
        }
        return $seElimino;
    }

    private function EliminarEmpleadosRepetidos()
    {
        array_unique($this->_empleados, SORT_REGULAR);
    }

    public function GetEmpleados()
    {
        if ($this->_empleados != NULL) {
            return $this->_empleados;
        }
    }

    public function ToString()
    {
        $empleados = "";
        for ($i = 0; $i < count($this->_empleados); $i++) {
            if ($i == count($this->_empleados) - 1) {
                $empleados .= $this->_empleados[$i]->ToString();
            } else {
                $empleados .= $this->_empleados[$i]->ToString() . " - ";
            }
        }
        return $this->_razonSocial . " - " . $this->_cantidadMaxima . " - " . $empleados;
    }

    public function GuardarEnArchivo($nombreArchivo)
    {
        if ($_archivoEmpleados = fopen($nombreArchivo, "w")) {
            for ($i = 0; $i < count($this->_empleados); $i++) {
                $seGuardo = fwrite($_archivoEmpleados, $this->_empleados[$i]->ToString() . "\r\n");
                if (!$seGuardo) {
                    echo "Hubo un error al guardar el archivo de empleados.";
                    break;
                }
            }
            fclose($_archivoEmpleados);
        } else {
            echo "Hubo un error al abrir el archivo de empleados.";
        }
    }

    public function TraerDeArchivo($nombreArchivo)
    {
        if ($_archivoEmpleados = fopen($nombreArchivo, "r")) {
            if ('' != file_get_contents($nombreArchivo)) {
                while (!feof($_archivoEmpleados)) {
                    $empleadoEnArchivo  = fgets($_archivoEmpleados);
                    $datosEmpleado = explode(" - ", $empleadoEnArchivo);
                    $datosEmpleado[0] = trim($datosEmpleado[0]);

                    if ($datosEmpleado[0] != '') {
                        $datosEmpleado[7] = trim($datosEmpleado[7], "\r\n");

                        $empleadoNuevo = new Empleado($datosEmpleado[0], $datosEmpleado[1], $datosEmpleado[2], $datosEmpleado[3], $datosEmpleado[4], $datosEmpleado[5], $datosEmpleado[6]);
                        $empleadoNuevo->SetPathFoto($datosEmpleado[7]);
                        if (!$this->AgregarEmpleado($empleadoNuevo)) {
                            echo "No se pudo agregar el empleado a la fabrica.<br>";
                        }
                    }
                }
            }
            fclose($_archivoEmpleados);
        } else {
            echo "Error al abrir el archivo de empleados";
        }
    }
}//clase fabrica