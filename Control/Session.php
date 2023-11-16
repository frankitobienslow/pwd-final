<?php 
class Session{
    
    public function __construct()
    {
        session_start(); // Inicia la sessión 
    }// fin metodo constructor 


    
    /** METODO INICIAR 
     * @param $nombreUsuario string
     * @param $pws string
    */
    public function iniciar($nombreUsuario,$pws){
        $resp=false;
        $objAbmUsuario=new AbmUsuario();
        $consulta=['usnombre'=>$nombreUsuario,'uspass'=>$pws,'usdeshabilitado'=>null]; // forma la consulta para el metodo buscar de AbmUsuario 
        $usuarios=$objAbmUsuario->buscar($consulta);
        
        if(count($usuarios)>=1){
            if($this->activa()){
                $_SESSION['idUser']=$usuarios[0]->getId(); // guarda el Id del usuario en la session
                //$_SESSION['nombreUsuario']=$usuarios[0]->getNombre(); 
                $resp=true;

            }// fin if 
        }// fin if 
        //var_dump($resp);
        return $resp; 
    }// fin metodo iniciar 



    /** METODO VALIDAR
     * valida la session actual, si tiene usuario y pws válidos
     * @return boolean
     */
    public function validar(){
        $salida=false; 
        if(isset($_SESSION['idUser']) && $this->activa()){ // pregunta si esta seteado el id del usuario para validarlo
            $salida=true; 
        }// fin if 
        return $salida; 
    }// fin metodo validar

    /** METODO ACTIVA
     * @return boolean
     */
    public function activa(){
        $salida=false;
        if(session_status() === PHP_SESSION_ACTIVE){
            $salida=true; // la session esta activa 
        } // fin if 

        return $salida; 

    }// fin metodo activa

    /** METODO GETUSUARIO 
     * @return Usuario
    */
    public function getUsuario(){
        $objAbmUsuario=new AbmUsuario();
        $consulta=['idusuario'=>$_SESSION['idUser']];// pregunto si el usuario con 
        // esa session esta registrado. Lo busco en la BD
        $usuarios=$objAbmUsuario->buscar($consulta);
        if(count($usuarios)>=1){
            $usuarioRegistrado=$usuarios[0];

        }// fin if 
        return $usuarioRegistrado;
    }// fin metodo getUsuario

    /** METODO GETROL
     * @return obj
     */
    public function getRol(){
        $objRolesUsuarios=null;
        if($this->getUsuario()!=null){
            $userLog=$this->getUsuario(); // almacena el obj usuario  
            $datos['idusuario']=$userLog->getId(); // guarda el id de usuario 
            $objRolUsuario=new AbmUsuarioRol();
            $objRolesUsuarios=$objRolUsuario->buscar($datos); // busca en la tabla usuarioRol los roles que coincide con el id del usuario
        }// fin if 
        return $objRolesUsuarios;  // puede devolver una lista de usuarios con distintos roles o un solo usuario con un unico rol
    }// fin metodo getRol

    /** METODO CERRAR 
     * @return boolean
     */
    public function cerrar(){
        $resp=session_destroy();
        return $resp;  
    }// fin metodo cerrar

}// fin clase Session 

?>