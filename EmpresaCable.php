<?php

class EmpresaCable{

    private $colPlanes;
    private $colContratos;

    //metodo constructor
    public function __construct($colPlanes, $colContratos){
        $this->colPlanes=$colPlanes;
        $this->colContratos=$colContratos;
    }

    //metodos de acceso

    public function getColPlanes(){
        return $this->colPlanes;
    }

    public function setColPlanes($colPlanes){
        $this->colPlanes=$colPlanes;
    }


    public function getColContratos(){
        return $this->colContratos;
    }

    public function setColContratos($colContratos){
        $this->colContratos=$colContratos;
    }

    //metodo para imprimir los array
    public function retornarCadena($cadena){
        $nuevaCadena="";
        foreach($cadena as $valor){
            $nuevaCadena.=$valor."\n";
        }
        return $nuevaCadena;
    }

    //metodo __tostring
    public function __toString(){
        return
        "\n". $this->retornarCadena($this->getColPlanes()).
        "\n". $this->retornarCadena($this->getColContratos());
    }


    public function incorporarPlan($objPlan){
        if($objPlan->getColCanales() && $objPlan->getIncluyeMG()){
            $copia=false;
            foreach($this->getColPlanes() as $plan){
                if($objPlan->getColCanales()==$plan->getColCanales() && $objPlan->getIncluyeMG()==$plan->getIncluyeMG()){
                    $copia=true;
                }
            }
            if(!$copia){
                $coleccionPlanes[]=$this->getColPlanes();
                array_push($coleccionPlanes,$objPlan);
                $this->setColPlanes($coleccionPlanes);
            }
        }else{
            $coleccionPlanes[]=$this->getColPlanes();
            array_push($coleccionPlanes,$objPlan);
            $this->setColPlanes($coleccionPlanes);
        }
    }


    public function incorporarContrato($objPlan,$objCliente,$fechaDesde,$fechaVenc,$esViaWeb){
        if($esViaWeb==true){
            $objContratoViaWeb= new ContratoViaWeb($fechaDesde, $fechaVenc, $objPlan, 0, true, $objCliente);
            $coleccionContratos[]=$this->getColContratos();
            array_push($coleccionContratos, $objContratoViaWeb);
            $this->setColContratos($coleccionContratos);
        }else{
            $objContrato= new Contrato($fechaDesde, $fechaVenc, $objPlan, 0, true, $objCliente);
            $coleccionContratos[]=$this->getColContratos();
            array_push($coleccionContratos, $objContrato);
            $this->setColContratos($coleccionContratos);
        }
    }

    public function retornarImporteContrator($codigoPlan){
        $colContratos=$this->getColContratos();
        $importeTotal=0;
        for($i=0;$i<count($colContratos);$i++){
            $contrato=$colContratos[$i];
            if($contrato->getObjPlan()->getCodigo()==$codigoPlan){
                $importeTotal+=$contrato->calcularImporte();
            }
        }
        return $importeTotal;
    }

    public function pagarContrato($objContrato){
        $objContrato->actualizarEstadoContrato();
        if($objContrato->getEstado() != 'SUSPENDIDO'){
            $objContrato->setEstado('AL DIA');
        }
        $importeTotal=$objContrato->calcularImporte();
        return $importeTotal;
    }
}

?>