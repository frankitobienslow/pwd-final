<?php

class Rol
{
    // ATRIBUTOS 
    private $idRol;
    private $descripcion;
    private $mensaje;
    private $habilitado;

    //CONSTRUCTOR 
    public function __construct()
    {

        $this->idRol = 0;
        $this->descripcion = "";
        $this->mensaje = "";
        $this->habilitado = 1;
    } // fin metodo constructor 

    // METODO SETEAR
    public function setear($id, $descrip, $hab)
    {
        $this->idRol = $id;
        $this->descripcion = $descrip;
        $this->habilitado = $hab;
    } // fin metodo setear 

    // METODO GET
    public function getId()
    {
        return $this->idRol;
    } // fin metodo get

    public function getDescripcion()
    {
        return $this->descripcion;
    } // fin metodo get

    public function getMensaje()
    {
        return $this->mensaje;
    } // fin metodo get


    public function getHabilitado()
    {
        return $this->habilitado;
    }

    //METODO SET

    public function setId($id)
    {
        $this->idRol = $id;
    } // fin metodo set

    public function setDescripcion($descr)
    {
        $this->descripcion = $descr;
    } // fin metodo set

    public function setMensaje($msj)
    {
        $this->mensaje = $msj;
    } // fin metodo set

    public function setHabilitado($hab)
    {
        $this->habilitado = $hab;
    } // fin metodo set



    /******** METODOS INGRESAR - MODIFICAR - ELIMINAR - LISTAR ********** */
    /** METODO BUSCAR: EN FUNCION DEL ID (DNI), BUSCA A LA PERSONA EN LA BASE DE DATOS
     * @return boolean
     */
    public function cargar()
    {
        $baseDatos = new BaseDatos();
        $salida = false; // inicializacion del valor de retorno
        $sql = "SELECT * FROM rol WHERE idrol=" . $this->getId();
        if ($baseDatos->Iniciar()) { // inicializa la conexion
            $salida = $baseDatos->Ejecutar($sql);
            if ($salida > -1) {
                if ($salida > 0) {
                    $salida = true;
                    $R = $baseDatos->Registro(); // recupera los registros de la tabla  con la ID dada

                    $this->setear($R['idrol'], $R['roldescripcion'], $R['habilitado']);
                } // fin if 

            } // fin if


        } // fin if 
        else {
            $this->setMensaje("Error en la Tabla rol") . $baseDatos->getError();
        } // fin else

        return $salida;
    } // fin function 


    /** METODO INSERTAR 
     * Ingresa un registro en la base de datos 
     * @return boolean|int Retorna el ID del registro insertado si se realiza la inserción correctamente, o false en caso contrario.
     */
    public function insertar()
    {
        $idInsertado = false; // inicialización del valor de retorno
        $baseDatos = new BaseDatos();
        $sql = "INSERT INTO rol (roldescripcion, habilitado)
    VALUES ('" . $this->getDescripcion() . "', ".$this->getHabilitado().");";
        if ($baseDatos->Iniciar()) {
            $idInsertado = $baseDatos->Ejecutar($sql);
            if ($idInsertado === false) {
                $this->setMensaje("rol -> Insertar: " . $baseDatos->getError());
            }
        } else {
            $this->setMensaje("rol -> Insertar: " . $baseDatos->getError());
        }

        return $idInsertado;
    } // fin function insertar 

    /**
     * METODO MODIFICAR
     * @return boolean
     */
    public function modificar()
    {
        $salida = false;
        $baseDatos = new BaseDatos();
        $sql = "UPDATE rol SET roldescripcion='" . $this->getDescripcion() . "', habilitado=".$this->getHabilitado()."  WHERE idrol=" . $this->getId();

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($sql)) {
                $salida = true;
            } // fin if 
            else {
                $this->setMensaje("Tabla rol Modificar ") . $baseDatos->getError();
            } // fin else


        } // fin if
        else {
            $this->setMensaje("Tabla rol Modificar ") . $baseDatos->getError();
        } // fin else

        return $salida;
    } // fin function modificar

    /**
     * METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar()
    {
        $salida = false;
        $baseDatos = new BaseDatos();
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getId();
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($sql)) {
                $salida = true;
            } // fin if
            else {
                $this->setMensaje("Tabla rol-> eliminar" . $baseDatos->getError());
            } // fin else

        } // fin if
        else {
            $this->setMensaje("Tabla rol-> eliminar" . $baseDatos->getError());
        } // fin else

        return $salida;
    } // fin function eliminar


    /**
     * METODO LISTAR POSTULANTE
     * DEVUELVE TODOS LOS POSTULANTES EN LA BASE DE DATOS
     * @param string $parametro
     * @return array 
     */
    public function listar($parametro = "")
    {
        //var_dump($parametro);
        $arrayUsuarios = array();
        $baseDatos = new BaseDatos();
        $sql = "SELECT * FROM rol";
        if ($parametro != "") {
            $sql .= ' WHERE ' . $parametro;
        } // fin if 

        if ($baseDatos->Iniciar()) {
            $respuesta = $baseDatos->Ejecutar($sql);
            if ($respuesta > -1) {
                if ($respuesta > 0) {

                    while ($row = $baseDatos->Registro()) {
                        $obj = new Rol();
                        $obj->setear($row['idrol'], $row['roldescripcion'], $row["habilitado"]);
                        array_push($arrayUsuarios, $obj);
                    } // fin while 


                } // fin if 
            } // fin if 
        } // fin if 
        return $arrayUsuarios;
    } // fin function listar

} // fin clase 
