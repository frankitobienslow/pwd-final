<?php

class UsuarioRol extends BaseDatos{

    private $objUsuario; 
    private $objRol; 
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct(){
        parent::__construct(); 
        $this->objRol=new Rol();
        $this->objUsuario=new Usuario();
    }// fin constructor 

    // METODO SETEAR 
    public function setear($objR,$objU){
        $this->setObjUsuario($objU);
        $this->setObjRol($objR);

    }// fin metodo setear

    // METODOS GET
    public function getObjUsuario(){
        return $this->objUsuario; 
    }// fin metodo get

    public function getObjRol(){
        return $this->objRol; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    // METODOS SET
    public function setObjUsuario($usuario){
        $this->objUsuario=$usuario;
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
        $this->getObjUsuario()->setId($idUsuario);
    }// fin metodo setClave

    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $sql="SELECT * FROM usuariorol WHERE idrol=".$this->getObjRol()->getId()." AND idusuario=".$this->getObjUsuario()->getId().";";
        if($this->Iniciar()){
            $salida=$this->Ejecutar($sql);
            if($salida>-1){
                if($salida>0){
                    $row=$this->Registro();
                    $objU=new Usuario();
                    $objU->setId($row['idusuario']);
                    $objU->cargar(); 
                    $objR=new Rol();
                    $objR->setId($row['idrol']);
                    $objR->cargar(); 
                    $this->setear($objR,$objU); 

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
        $sql="DELETE FROM usuariorol WHERE idrol=".$this->getObjRol()->getId()." AND idusuario=".$this->getObjUsuario()->getId().";";
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;
            }// fin if 
            else{
                $this->setMensaje("Usuario ->eliminar ".$this->getError()); 
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("Usuario ->eliminar ".$this->getError()); 

        }// fin else

        return $salida; 


    }// fin metodo eliminar 


    /** METODO LISTAR 
     * @param parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayUusarioRol=array();
        $sql="SELECT * FROM usuariorol";
        if($parametro!=""){
            $sql.=' WHERE '.$parametro; 
        }// fin if 
        if($this->Iniciar()){
            print_r("entro");
            $salida=$this->Ejecutar($sql);
            var_dump($salida);
            if($salida>-1){
                if($salida>0){
                    while($row=$this->Registro()){
                        $obj=new UsuarioRol();
                        $obj->getObjUsuario()->setId($row['idusuario']);
                        $obj->getObjRol()->setId($row['idrol']);
                        $obj->cargar();
                        array_push($arrayUusarioRol,$obj); 

                    }// fin while 
                }// fin if 

            }// fin if

        }// fin if
        else{
            $this->setMensaje("Usuario -> listar: ".$this->getError());
        }// fin else

        return $arrayUusarioRol; 
    }// fin metodo listar 


}// fin clase 


?>