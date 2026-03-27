<?php

namespace App\Functions;


class OperacionAuxiliar
{
    public function periodoPorMesNumerico($mes)
    {
        switch ($mes) {
            case '01':
                $periodo = 'Verano';
                break;
            case '02':
            case '03':
            case '04':
            case '05':
            case '06':
                $periodo = 1;
                break;
            case '07':
                $periodo = 'Invierno';
                break;
            case '08':
            case '09':
            case '10':
            case '11':
            case '12':
                $periodo = 2;
                break;
            default:
                $periodo = false;
        }
        return $periodo;
    }
    public function periodoPorMes($mes)
    {
        switch ($mes) {
            case 'Enero':
            case 'Febrero':
            case 'Marzo':
                $periodo = 1;
                break;
            case 'Abril':
            case 'Mayo':
            case 'Junio':
                $periodo = 2;
                break;
            case 'Julio':
            case 'Agosto':
            case 'Septiembre':
                $periodo = 3;
                break;
            case 'Octubre':
            case 'Noviembre':
            case 'Diciembre':
                $periodo = 4;
                break;
            default:
                $periodo = false;
        }
        return $periodo;
    }
    public function fechaInicialTrimestre($gestion, $trimestre)
    {
        switch ($trimestre) {
            case '1':
                $fechaInicial = $gestion.'-01-01';
                break;
            case '2':
                $fechaInicial = $gestion.'-04-01';
                break;
            case '3':
                $fechaInicial = $gestion.'-07-01';
                break;
            case '4':
                $fechaInicial = $gestion.'-10-01';
                break;
        }
        return $fechaInicial;
    }
    public function fechaFinalTrimestre($gestion, $trimestre)
    {
        switch ($trimestre) {
            case '1':
                $fechaFinal = $gestion.'-03-31';
                break;
            case '2':
                $fechaFinal = $gestion.'-06-30';
                break;
            case '3':
                $fechaFinal = $gestion.'-09-30';
                break;
            case '4':
                $fechaFinal = $gestion.'-12-31';
                break;
        }
        return $fechaFinal;
    }
    public function mesInicialTrimestre($trimestre)
    {
        switch ($trimestre) {
        case '1':
            $mesInicial = '01';
            break;
        case '2':
            $mesInicial = '04';
            break;
        case '3':
            $mesInicial = '07';
            break;
        case '4':
            $mesInicial = '10';
            break;
    }
    return $mesInicial;

    }
    public function mesLiteral($mes)
    {
        switch ($mes) {
            case '01':
                $mesLiteral = "Enero";
                break;
            case '02':
                $mesLiteral = "Febrero";
                break;
            case '03':
                $mesLiteral = "Marzo";
                break;
            case '04':
                $mesLiteral = "Abril";
                break;
            case '05':
                $mesLiteral = "Mayo";
                break;
            case '06':
                $mesLiteral = "Junio";
                break;
            case '07':
                $mesLiteral = "Julio";
                break;
            case '08':
                $mesLiteral = "Agosto";
                break;
            case '09':
                $mesLiteral = "Septiembre";
                break;
            case '10':
                $mesLiteral = "Octubre";
                break;
            case '11':
                $mesLiteral = "Noviembre";
                break;
            case '12':
                $mesLiteral = "Diciembre";
                break;
            default:
                $mesLiteral = false;
                break;
        }

        return $mesLiteral;
    }
    public function mesNumerico($mes)
    {
        switch ($mes) {
            case 'Enero':
                $mesNumerico = "01";
                break;
            case 'Febrero':
                $mesNumerico = "02";
                break;
            case 'Marzo':
                $mesNumerico = "03";
                break;
            case 'Abril':
                $mesNumerico = "04";
                break;
            case 'Mayo':
                $mesNumerico = "05";
                break;
            case 'Junio':
                $mesNumerico = "06";
                break;
            case 'Julio':
                $mesNumerico = "07";
                break;
            case 'Agosto':
                $mesNumerico = "08";
                break;
            case 'Septiembre':
                $mesNumerico = "09";
                break;
            case 'Octubre':
                $mesNumerico = "10";
                break;
            case 'Noviembre':
                $mesNumerico = "11";
                break;
            case 'Diciembre':
                $mesNumerico = "12";
                break;
            default:
                $mesNumerico = false;
                break;
        }

        return $mesNumerico;
    }
}
