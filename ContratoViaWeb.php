<?php

class ContratoViaWeb extends Contrato{
    private $porcentajeDescuento;


    public function __construct($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente){
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan,$costo,$seRennueva,$objCliente);
        $this->porcentajeDescuento=10;
    }

    public function getPorcentajeDescuento(){
        return $this->porcentajeDescuento;
    }

    public function setPorcentajeDescuento($porcentajeDescuento){
        $this->porcentajeDescuento=$porcentajeDescuento;
    }

    public function calcularImporte(){
        $importePadre=parent::calcularImporte();
        $importeFinal=$importePadre*(100-$this->getPorcentajeDescuento())/100;
        return $importeFinal;
    }



}