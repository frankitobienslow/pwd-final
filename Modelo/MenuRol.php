<?php

class MenuRol extends BaseDatos{
    private $objMenu; 
    private $objRol; 
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct(){
        parent::__construct(); 
        $this->objRol=new Rol();
        $this->objMenu=new Usuario();
    }// fin constructor 

    // METODO SETEAR 
    public function setear($objR,$objM){
        $this->setObjMenu($objM);
        $this->setObjRol($objR);

    }// fin metodo setear

    // METODOS GET
    public function getObjMenu(){
        return $this->objMenu; 
    }// fin metodo get

    public function getObjRol(){
        return $this->objRol; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    // METODOS SET
    public function setObjMenu($menu){
        $this->objMenu=$menu;
    }// fin metodo set

    public function setObjRol($rol){
        $this->objRol=$rol;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    // METODO SET CLAVE
    /**Setea los id de rol y usuario dados por parametro */
    public function setClave($idUsuario,$idRol){
        $this->getObjRol()->setId($idRol);
        $this->getObjMenu()->setId($idUsuario);
    }// fin metodo setClave

    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $sql="SELECT * FROM menurol WHERE idrol=".$this->getObjRol()->getId()." AND idusuraio=".$this->getObjMenu()->getId().";";
        if($this->Iniciar()){
            $salida=$this->Ejecutar($sql);
            if($salida>-1){
                if($salida>0){
                    $row=$this->Registro();
                    $objM=new Menu();
                    $objM->setId($row['idmenu']);
                    $objM->cargar(); 
                    $objR=new Rol();
                    $objR->setId($row['idrol']);
                    $objR->cargar(); 
                    $this->setear($objR,$objM); 

                }// fin if 

            }// fin if 

        }// fin if 
        else{
            $this->setMensaje($this->getError());
        }// fin else

        return $salida; 

    }// fin metodo cargar 

    /** METODO MODIFICAR
     * La clase usuarioROl al ser un entidad debil en el modelo , no puede modificar a usuario o rol 
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        return $salida;
    }// fin metodo modificar

    /**METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="DELETE FROM menurol WHERE idrol=".$this->getObjRol()->getId()." AND idmenu=".$this->getObjMenu()->getId().";";
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;
            }// fin if 
            else{
                $this->setMensaje("Menu ->eliminar ".$this->getError()); 
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("Menu ->eliminar ".$this->getError()); 

        }// fin else

        return $salida; 


    }// fin metodo eliminar 


    /** METODO LISTAR 
     * @param parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayUusarioRol=array();
        $sql="SELECT * FROM menurol";
        if($parametro!=""){
            $sql.=' WHERE '.$parametro; 
        }// fin if 
        if($this->Iniciar()){
            $salida=$this->Ejecutar($sql);
            if($salida>-1){
                if($salida>0){
                    while($row=$this->Registro()){
                        $obj=new MenuRol();
                        $obj->getObjMenu()->setId($row['idmenu']);
                        $obj->getObjRol()->setId($row['idrol']);
                        $obj->cargar();
                        array_push($arrayUusarioRol,$obj); 

                    }// fin while 
                }// fin if 

            }// fin if

        }// fin if
        else{
            $this->setMensaje("Menu -> listar: ".$this->getError());
        }// fin else

        return $arrayUusarioRol; 
    }// fin metodo listar 


}// fin clase 


?>