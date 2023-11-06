<?php

class CompraEstadoTipo extends BaseDatos{

    private $id; 
    private $descripcion;
    private $detalle; 
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct()
    {
        $this->id=0; 
        $this->descripcion="";
        $this->detalle=""; 
        $this->mensaje="";

    }// fin metodo constructor
    
    // METODO SETEAR 
    public function setear($id,$descrp,$detalle){
        $this->id=$id;
        $this->descripcion=$descrp;
        $this->detalle=$detalle;

    }// fin metodo setear 

    // METODOS GET
    public function getId(){
        return $this->id; 
    }// fin metodo get

    public function getDescripcion(){
        return $this->descripcion; 
    }// fin metodo get

    public function getDetalle(){
        return $this->detalle; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    // METODOS SET 
    public function setId($id){
        $this->id=$id;
    }// fin metodo set

    public function setDetalle($detalle){
        $this->detalle=$detalle;
    }// fin metodo set

    public function setDEscripcion($descrp){
        $this->descripcion=$descrp;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    /**
     * METODO CARGAR
     * carga a un obj usuario en caso que se encuentre en la base de datos 
     * @return boolean
     */
    public function cargar(){
        $salida=false; // inicializacion del valor de retorno
        $sql = "SELECT * FROM compraestadotiop WHERE idcompraestadotipo=".$this->getId();
        if($this->Iniciar()){// inicializa la conexion
            $salida=$this->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$this->Registro(); // recupera los registros de la tabla  con la ID dada
                    
                    $this->setear($R['idcompraestadotipo'],$R['cetdescripcion'],$R['cetdetalle']);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla compraestadotipo").$this->getError();
        }// fin else

        return $salida; 

    }// fin function 

    /** METODO INSERTAR 
     * Ingresa un registro en la base de datos 
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
        $id=$this->getId();
        $sql="INSERT INTO usuario (idcompraestadotipo,cetdescripcion,cetdetalle)
        VALUES ($id,'".$this->getDescripcion()."','".$this->getDetalle()."');"; 
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("compraestadotipo - > Insertar").$this->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("compraestadotipo - > Insertar").$this->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 

    /**
     * METODO MODIFICAR
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $sql="UPDATE compraestadotipo SET cetdescripcion='".$this->getDescripcion()."', cetdetalle='".$this->getDetalle()."' WHERE idcompraestadotipo=".$this->getId();

        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla compraestadotipo Modificar ").$this->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla compraestadotipo Modificar ").$this->getError();

        } // fin else

        return $salida; 


    }// fin function modificar

    /**
     * METODO ELIMINAR (BORARDO LOGICO)
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="DELETE FROM compraestadotipo WHERE idcompraestadotipo=".$this->getId();
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla compraestadotipo-> eliminar".$this->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla compraestadotipo-> eliminar".$this->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar


    /**
     * METODO LISTAR 
     * DEVUELVE TODOS LOS USUARIOS EN LA BASE DE DATOS
     * @param parametro
     * @return array 
     */
    public function listar($parametro=""){
        $arrayCompraEstadoTipo=array();
        $sql="SELECT * FROM compraestadotipo";
        if($parametro!=""){
            $sql.=' WHERE'.$parametro;
        }// fin if 
        
        if($this->Iniciar()){
           
            $respuesta=$this->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                    
                    while($row=$this->Registro()){
                    $obj=new CompraEstadoTipo();
                    $obj->setear($row['idcompraestadotipo'],$row['cetdescripcion'],$row['cetdetalle']);
                    array_push($arrayUsuarios,$obj);   
                    }// fin while 


                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayCompraEstadoTipo; 
    }// fin function listar
  




}// fin clase 


?>