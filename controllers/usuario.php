<?PHP
include_once 'Conexion.php';
class usuario{
    var $objetos;
    public function __construct(){
        $db = new  conexion();
        $this->acceso = $db->pdo;
    }
function loguearse($email,$pass){
    $sql="select * from usuario 
    INNER JOIN tipo_usuario on usuario.us_tipo = tipo_usuario.id_tipo_us
    INNER JOIN estado_usuario on usuario.estado_usuario = estado_usuario.id_estado_usuario
    where email_us =:email and contrasena_us=:pass";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':email'=>$email,':pass'=>$pass));
    $this->objetos=$query->fetchall();
    return $this->objetos;
}//fin logearse
}