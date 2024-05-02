<?php
include_once '../models/Usuario.php';
session_name("agrocacao");
session_start();
$id_usuario = $_SESSION["usuario"];
$usuario = new usuario();


//TODO: buscar usuario actual
if($_POST['funcion'] =='dato_usuario'){
    $json=array();
    $fecha_actual = new DateTime();
    $usuario->dato_usuario($id_usuario);
    foreach ($usuario->objetos as $objeto) { 
     $nacimiento = new DateTime($objeto->edad_us);
     $edad=$nacimiento->diff($fecha_actual);
     $edad_years = $edad->y;
     $json[]=array(
      'id_us'=>$objeto->id_us,   
      'nombres'=>$objeto->nombre_us,
      'apellidos'=>$objeto->apellido_us,
      'edad'=>$edad_years,
      'ci'=>$objeto->ci_us,
      'correo'=>$objeto->email_us,
      'nombre_tipo'=>$objeto->nombre_tipo_us,
      'tipo_us_id'=>$objeto->tipo_us_id,  
      'nombre_estado_usuario'=>$objeto->nombre_estado_us,
      'avatar'=>$objeto->avatar
     );  
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//TODO: tipos de usuario
if($_POST["funcion"] == "tipos_usuario"){
    $json = array();
    $usuario->tipo_usuario();
    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'id_tipo_us' => $objeto->id_tipo_us,
            'nombre_tipo_us' => $objeto->nombre_tipo_us
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}


//TODO: buscar usuarios
if($_POST['funcion'] == 'buscar_usuarios'){
    $json = array();
    $usuario->buscar();
    foreach($usuario -> objetos as $objeto){
        $json[]=array(
            'id_us'=>$objeto->id_us,   
            'nombres'=>$objeto->nombre_us,
            'apellidos'=>$objeto->apellido_us,
            'ci'=>$objeto->ci_us,
            'correo'=>$objeto->email_us,
            'telefono'=>$objeto->telefono,
            'nombre_tipo'=>$objeto->nombre_tipo_us,
            'tipo_us_id'=>$objeto->tipo_us_id, 
            'nombre_estado_us'=>$objeto->nombre_estado_us,
            'avatar'=>$objeto->avatar
        );
    }

  $jsonstring = json_encode($json);
  echo $jsonstring;

}


//TODO: insertar usuario
if ($_POST['funcion'] == 'crear_usuario') {
    // creo la carpeta si no existe
	if(!is_dir('../uploads/avatar')){
		mkdir('../uploads/avatar', 0777, true);
        // Ruta de la carpeta de origen
        $rutaOrigen = '../assets/img/';
        // Ruta de la carpeta de destino
        $rutaDestino = '../uploads/avatar/';

        // Nombre del archivo a copiar
        $nombreArchivo = 'imgavatar.png';

        // Construir rutas completas
        $rutaArchivoOrigen = $rutaOrigen . $nombreArchivo;
        $rutaArchivoDestino = $rutaDestino . $nombreArchivo;

        // Intentar copiar el archivo
        copy($rutaArchivoOrigen, $rutaArchivoDestino);
	}
    $avatar_defecto = "imgavatar.png";
    $habilitado = 1;
    // Obtener los datos enviados post
    $nombre = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_STRING);
    $apellido = filter_input(INPUT_POST, 'apellido_usuario', FILTER_SANITIZE_STRING);
    $fechaNacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
    $ci = filter_input(INPUT_POST, 'ci', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, 'select_tipo', FILTER_VALIDATE_INT);
    

    // Array de errores
	$errores = array();
    // Validar los datos antes de guardarlos en la base de datos
	// Validar campo nombre
	if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
		$nombre_validado = true;
        
	}else{
		$nombre_validado = false;
		$errores['nombre'] = "El nombre no es válido";
        
	}


    if(!empty($apellido) && !is_numeric($apellido) && !preg_match("/[0-9]/", $apellido)){
		$apellido_validado = true;
        
	}else{
		$apellido_validado = false;
		$errores['apellido'] = "El apellido no es válido";
        
	}

    // Validar la cedula
	if(!empty($ci) && is_numeric($ci) && strlen($ci) == 10){
		$ci_validado = true;
	}else{
		$ci_validado = false;
		$errores['cedula'] = "La cedula no es válido";
	}

    // Validar la contraseña
	if(!empty($contrasena)){
		$password_validado = true;
	}else{
		$password_validado = false;
		$errores['password'] = "La contraseña está vacía";
	}


    // validar tipo_usuario
    if(!empty($tipo)){
		$tipo_validado = true;
	}else{
		$tipo_validado = false;
		$errores['tipo-usuario'] = "Selecionar Tipo de Usuario";
	}

    // Validar apellidos
    if(count($errores) == 0){
        // Llamar al método crear del objeto usuario
        $resultado = $usuario->crear($nombre, $apellido, $fechaNacimiento, $ci, $telefono, $correo, $contrasena, $tipo, $habilitado, $avatar_defecto);
        echo $resultado;
       
    }else{
	    $jsonstring = json_encode($errores);
        echo $jsonstring;
	}

    
    
}



//TODO: buscar usuario actual
if($_POST['funcion']=='dato_usuario'){
    $json=array();
    $fecha_actual = new DateTime();
    $usuario->dato_usuario($id_usuario);
    foreach ($usuario->objetos as $objeto) { 
     $nacimiento = new DateTime($objeto->edad_us);
     $edad=$nacimiento->diff($fecha_actual);
     $edad_years = $edad->y;
     $json[]=array(
      'id_us'=>$objeto->id_us,   
      'nombres'=>$objeto->nombre_us,
      'apellidos'=>$objeto->apellido_us,
      'edad'=>$edad_years,
      'ci'=>$objeto->ci_us,
      'correo'=>$objeto->email_us,
      'nombre_tipo'=>$objeto->nombre_tipo_us,
      'tipo_us_id'=>$objeto->tipo_us_id,  
      'nombre_estado_usuario'=>$objeto->nombre_estado_us,
      'avatar'=>$objeto->avatar
     );  
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}




//TODO: borrar usuario
if($_POST['funcion']=='borrar-usuario'){
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
    // $id_borrado=$_POST['id_usuario'];
    $id_borrado = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $usuario->borrar($pass, $id_borrado, $id_usuario);
}
   

