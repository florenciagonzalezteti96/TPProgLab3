<?php

interface IArchivo
{
    public function GuardarEnArchivo($nombreArchivo);
    public function TraerDeArchivo($nombreArchivo);
}