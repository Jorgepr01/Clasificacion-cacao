<?php
include_once 'conexion.php';

class usuario
{
  var $objetos;
  private $acceso;
  public function __construct()
  {
    $db = new conexion();
    $this->acceso = $db->pdo;
  }

  // TODO: inicio de session
  function loguearse($email, $pass)
  {
    try {
      $sql = "SELECT * FROM usuario
          INNER JOIN tipo_usuario on usuario.tipo_us_id = tipo_usuario.id_tipo_us
          INNER JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
          WHERE email_us =:email";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':email' => $email));
      $usuario = $query->fetch(); // Establecer FETCH_ASSOC para obtener un array asociativo

      // Verificar si se encontró un usuario con el correo electrónico dado
      if ($usuario) {
        // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
        if (password_verify($pass, $usuario->contrasena_us)) {
          // Si la contraseña coincide, devolver el objeto de usuario
          return $usuario;
        } else {
          // Si la contraseña no coincide, devolver false indicando una contraseña incorrecta
          return null;
        }
      } else {
        // Si no se encontró ningún usuario con el correo electrónico dado, devolver false
        return null;
      }
    } catch (PDOException $e) {
      // Manejar cualquier excepción de PDO (por ejemplo, errores de consulta)
      // Puedes registrar el error o devolver un mensaje de error genérico
      error_log("Error al intentar iniciar sesión: " . $e->getMessage());
      return null;
    }
  }

  // TODO: CAMBIAR CONTRASEÑA
  function cambiar_contra($oldpass, $newpass, $id_usuario)
  {
    $sql = "SELECT * FROM usuario where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($oldpass, $this->objetos->contrasena_us)) {
      $contraseña_segura = password_hash($newpass, PASSWORD_BCRYPT, ['cost' => 4]);
      $sql = "UPDATE usuario SET contrasena_us=:newpass where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_usuario, ':newpass' => $contraseña_segura));
      echo 'update';
    } else {
      echo 'noupdate';
    }
  }



  //TODO: tipos de usuario
  function tipo_usuario()
  {
    $sql = "SELECT * FROM tipo_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute();
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }

  // TODO: Crear usuario
  function crear($nombre, $apellido, $fechaNacimiento, $ci, $telefono, $correo, $contrasena, $tipo, $habilitado, $avatar_defecto)
  {
    $sql = "SELECT * FROM usuario WHERE email_us = :email";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':email' => $correo));
    $this->objetos = $query->fetchAll();

    if (!empty($this->objetos)) {
      return 'noadd';
    } else {
      // Cifrar la contraseña
      $contrasena_segura = password_hash($contrasena, PASSWORD_BCRYPT, ['cost' => 4]);
      $sql = "INSERT INTO usuario(nombre_us, apellido_us, edad_us, ci_us, telefono, email_us, contrasena_us, tipo_us_id, estado_us_id, avatar, creado_en) 
            VALUES(:nombre, :apellido, :fechaNacimiento, :ci_us, :telefono, :correo, :contrasena, :tipo, :estado_usuario, :avatar, now())";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':fechaNacimiento' => $fechaNacimiento,
        ':ci_us' => $ci,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':contrasena' => $contrasena_segura,
        ':tipo' => $tipo,
        ':estado_usuario' => $habilitado,
        ':avatar' => $avatar_defecto
      ));

      return 'add';
    }
  }

  // TODO: Buscar Usuario
  function buscar()
  {
    // si teclea  que se muestre el usuario buscar
    if (!empty($_POST['consulta'])) {
      $consulta = $_POST['consulta'];
      $sql = "SELECT * FROM usuario 
       join tipo_usuario on tipo_usuario.id_tipo_us =  usuario.tipo_us_id
       join estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
       where nombre_us LIKE :consulta  OR apellido_us LIKE :consulta";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':consulta' => "%$consulta%"));
      $this->objetos = $query->fetchall();
      return $this->objetos;
    } else {
      $sql = "SELECT * FROM usuario 
        join tipo_usuario on tipo_usuario.id_tipo_us =  usuario.tipo_us_id
        join estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
        where nombre_us NOT LIKE '' ORDER BY id_us LIMIT 25";
      $query = $this->acceso->prepare($sql);
      $query->execute();
      $this->objetos = $query->fetchall();
      return $this->objetos;
    }
  }

  //TODO: datos personales
  function dato_usuario($id)
  {
    $sql = "SELECT * FROM usuario
        INNER JOIN tipo_usuario on usuario.tipo_us_id = tipo_usuario.id_tipo_us
        INNER JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
        and id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id));
    $this->objetos = $query->fetchAll();
    return $this->objetos;
  }

  //TODO: buscar avatar del usuario 
  function buscar_avatar_usuario($id_usuario)
  {
    try {
      $sql = "SELECT avatar FROM usuario WHERE id_us = :id_us";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id_us' => $id_usuario));
      $resultado = $query->fetchColumn();
      if ($resultado !== false) {
        return $resultado;
      } else {
        return "imgavatar.png";
      }
    } catch (PDOException $e) {
      // En lugar de imprimir un mensaje de error, podrías manejarlo de alguna otra manera (log, notificación, etc.)
      return "Error en la consulta: " . $e->getMessage();
    }
  }

  function cambiar_avatar($id_usuario, $nombre)
  {
    $sql = "SELECT avatar FROM usuario where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario));
    $this->objetos = $query->fetchall();

    $sql = "UPDATE usuario SET avatar=:nombre where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario, ':nombre' => $nombre));
    return $this->objetos;
  }


  //TODO: datos personales
  function actualizarDatosUser($id, $nuevos_datos)
  {
    $sql = "UPDATE usuario 
            SET nombre_us = :nombre, apellido_us = :apellido, telefono = :telefono 
            WHERE id_us = :id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(
      ':nombre' => $nuevos_datos['nombres'],
      ':apellido' => $nuevos_datos['apellidos'],
      ':telefono' => $nuevos_datos['telefono'],
      ':id' => $id
    ));
    return "edit";
  }




  //TODO: borrar usuario
  function borrar($pass, $id_borrado, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario WHERE id_us = :id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $sql = "DELETE FROM usuario WHERE id_us = :id_borrado";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id_borrado' => $id_borrado));
      echo 'borrado';
    } else {
      echo 'noborrado';
    }
  }

  //TODO: Deshabilitar Usuario
  function deshabilitar_usuario($pass, $id_deshabilitar, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario where id_us=:id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();

    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $habilitado = 2;
      $sql = "UPDATE usuario SET estado_us_id = :habilitado where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_deshabilitar, ':habilitado' => $habilitado));
      echo 'deshabilitado';
    } else {
      echo 'nodeshabiltado';
    }
  }

  //TODO: Habilitar usuario
  function habilitar_usuario($pass, $id_habilitar, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario where id_us=:id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $habilitado = 1;
      $sql = "UPDATE usuario SET estado_us_id =:habilitado where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_habilitar, ':habilitado' => $habilitado));
      echo 'habilitado';
    } else {
      echo 'noexit';
    }
  }
}
