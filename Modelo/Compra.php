<?php

class Compra extends BaseDatos{
    private $idCompra;
    private $coFecha; 
    private $objUsuario; // delegacion
    private $mensaje;  

    // COSNTRUCTOR
    public function __construct()
    {
        parent::__construct();
        $this->idCompra=0;
        $this->coFecha="";
        $this->objUsuario=new Usuario();
        $this->mensaje="";
    }// fin constructor

    // METODO SETEAR 
    public function setear($id,$fecha,$usuario){
        $this->idCompra=$id;
        $this->coFecha=$fecha;
        $this->objUsuario=$usuario;
    }// fin function 

    // METODOS GET
    public function getId(){
        return $this->idCompra;
    }// fin metodo get

    public function getCoFecha(){
        return $this->coFecha;
    }// fin metodo get

    public function getUsuario(){
        return $this->objUsuario;
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje;
    }// fin metodo get

    //METODOS SET
    public function setId($id){
        $this->idCompra=$id;
    }// fin metodo set

    public function setCoFecha($fecha){
        $this->coFecha=$fecha;
    }// fin metodo set

    public function setUsuario($obj){
        $this->objUsuario=$obj;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set


    /**METODO CARGAR
     * carga el obj compra segun su id. Si no lo encuentra retorna falso
     * @return boolean
     */
    public function cargar(){
        $salida=false; // inicializacion del valor de retorno
        $sql = "SELECT * FROM compra WHERE idcompra=".$this->getId();
        if($this->Iniciar()){// inicializa la conexion
            $salida=$this->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$this->Registro(); // recupera los registros de la tabla  con la ID dada
                    $objU=new Usuario(); // carga del obj con su id
                    $objU->setId($R['idusuario']);
                    $objU->cargar(); 
                    $this->setear($R['idcompra'],$R['cofecha'],$objU);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla compra").$this->getError();
        }// fin else

        return $salida; 

    }// fin metodo cargar

    /**METODO INSERTAR 
     * Ingresa un registro en la tabla compra
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
        $id=$this->getId();// id de compra 
        $idUsuario=$this->getUsuario()->getId();
        $sql="INSERT INTO compra (idcompra,cofecha,idusuario)
        VALUES ($id,'".$this->getCoFecha()."',$idUsuario);"; 
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("compra - > Insertar").$this->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("compra - > Insertar").$this->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 

    /**METODO MODIFICAR 
     * ACTUALIZA LOS DATOS EN LA TABLA COMPRA SEGUN SU ID
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $idUsuario=$this->getUsuario()->getId();
        $sql="UPDATE compra SET idusuario=$idUsuario, cofecha='".$this->getCoFecha()."' WHERE idcompra=".$this->getId();

        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla compra Modificar ").$this->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla compra Modificar ").$this->getError();

        } // fin else

        return $salida; 


    }// fin function modificar

    /**METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="DELETE FROM compra WHERE idcompra=".$this->getId();
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla compra-> eliminar".$this->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla compra-> eliminar".$this->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar

    /**
     * METODO LISTAR COMPRA 
     * DEVUELVE TODAS LAS COMPRAS DE LA BASE DE DATOS
     * @param parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayCompras=array();
        $sql="SELECT * FROM compra";
        if($parametro!=""){
            $sql.=' WHERE'.$parametro;
        }// fin if 
        if($this->Iniciar()){
            $respuesta=$this->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                // creo y cargo  obj usuario
                    while($row=$this->Registro()){
                    $obj=new Usuario();
                    $obj->setId($row['idusuario']);
                    $obj->cargar();     
                    // seteo el obj Compra
                    $objCompra=new Compra();    
                    $objCompra->setear($row['idcompra'],$row['cofecha'],$obj);
                    array_push($arrayCompras,$objCompra);   // opcion con this. Sino creo un obj y lo reemplazo por el this
                    }// fin while 
                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayCompras; 
    }// fin function listar




}// fin clase

?>