<?php


class Producto extends BaseDatos{

    private $idProducto;
    private $nombre; 
    private $detalle; 
    private $cantStock; 
    private $precio; 
    private $mensaje; 

    // METODO CONSTRUCTOR 
    public function __construct()
    {
        parent::__construct(); 
        $this->idProducto=0;
        $this->nombre=""; 
        $this->detalle="";
        $this->cantStock=0; 
        $this->mensaje=""; 
        $this->precio=0; 
    }// fin metodo constructor 

    // METODO SETEAR 
    public function setear ($id,$nombre,$detalle,$stock,$precio){
        $this->idProducto=$id;
        $this->nombre=$nombre;
        $this->detalle=$detalle;
        $this->setStock($stock); 
        $this->precio=$precio; 

    }// fin metodo setear 

    // METODOS GET
    public function getId(){
        return $this->idProducto; 
    }// fin metodo get

    public function getNombre(){
        return $this->nombre; 
    }// fin metodo get

    public function getDetalle(){
        return $this->detalle; 
    }// fin metodo get

    public function getStock(){
        return $this->cantStock; 
    }// fin metodo get

    public function getPrecio(){
        return $this->precio; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    // METODOS SET
    public function setId($id){
        $this->idProducto=$id;
    }// fin metodo set

    public function setNombre($name){
        $this->nombre=$name;
    }// fin metodo set

    public function setDetalle($detalle){
        $this->detalle=$detalle;
    }// fin metodo set

    public function setStock($cant){
        $this->cantStock=$cant;
    }// fin metodo set

    public function setPrecio($precio){
        $this->precio=$precio;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $sql="SELECT * FROM producto WHERE idproducto=".$this->getId();
        if($this->Iniciar()){// inicializa la conexion
            $salida=$this->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$this->Registro(); // recupera los registros de la tabla  con la ID dada
                    
                    $this->setear($R['idproducto'],$R['pronombre'],$R['prodetalle'],$R['procantstock0'],$R['precio']);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla producto").$this->getError();
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
        $precio=$this->getPrecio(); 
        $sql="INSERT INTO producto (idproducto,pronombre,prodetalle,procantstock,precio)
        VALUES ($id,'".$this->getNombre()."','".$this->getDetalle()."',".$this->getStock().",$precio);"; 
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("producto - > Insertar").$this->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("producto - > Insertar").$this->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 

    /**
     * METODO MODIFICAR
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $sql="UPDATE producto SET pronombre='".$this->getNombre()."', prodetalle=".$this->getDetalle().", 
        procantstock=".$this->getStock().", precio=".$this->getPrecio()."  WHERE idproducto=".$this->getId();

        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla producto Modificar ").$this->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla producto Modificar ").$this->getError();

        } // fin else

        return $salida; 


    }// fin function modificar

    /**
     * METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="DELETE FROM producto WHERE idproducto=".$this->getId();
        if($this->Iniciar()){
            if($this->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla producto-> eliminar".$this->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla producto-> eliminar".$this->getError());
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
        $arrayProductos=array();
        $sql="SELECT * FROM producto ";
        //
        if($parametro!=""){
            $sql.=' WHERE '.$parametro;
        }// fin if 
        if($this->Iniciar()){
            $respuesta=$this->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                    
                    while($row=$this->Registro()){
                    $obj=new Producto();

                    $obj->setear($row['idproducto'],$row['pronombre'],$row['prodetalle'],$row['procantstock'],$row['precio']);
                     
                    array_push($arrayProductos,$obj); 
                    //var_dump($row['procantstock']);
                    //var_dump($obj->getStock());  
                    }// fin while 


                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayProductos; 
    }// fin function listar


}// fin clase 

?>