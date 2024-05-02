$(document).ready(function(){
  cargar_usuario();
  var funcion;
  function cargar_usuario(consulta) {
    funcion = 'buscar_usuarios';
    $.post('../../controllers/usuario.php', {
     consulta,
     funcion
    }, (response) => {
      // console.log(response);
    const usuarios = JSON.parse(response);
    let template = '';
    usuarios.forEach(usuario => {
      template += `
        <div class="card" usuarioId="${usuario.id_us}">
          <div class="card-body">
            <h1 style="background-color: #1783db; color: white; font-size: 15px; display: inline-block; border-radius: 5px;">${usuario.nombre_tipo}</h1>
            <img src="../../uploads/avatar/${usuario.avatar}">
            <h2 style="color: #0b7300; font-size: 20px; display: block; width: 100%; padding: 10px 0; text-align: center; overflow-wrap: break-word;">${usuario.nombres} ${usuario.apellidos}</b></h2>
              <ul style="text-decoration: none; list-style-type: none; display: block; width: 100%; padding: 10px 0; text-align: center; overflow-wrap: break-word;">
                <li style="margin-top: 10px;"><span><i class="fas fa-lg fa-id-card" style="color: #6c757d;"></i></span> C.I: ${usuario.ci}</li>
                <li style="margin-top: 10px;"><span><i class="fas fa-lg fa-at" style="color: #6c757d;"></i></span> Correo: ${usuario.correo}</li>
                <li style="margin-top: 10px;"><span><i class="fas fa-phone" style="color: #6c757d;"></i></span> Celular: ${usuario.telefono}</li>
                
              </ul>
            </div>
            `
      if (usuario.tipo_us_id != 1) {
        template += `
            <div class="card-footer">
              <!--<button type="button" class="inline-button">
                <i class=""></i> EDITAR
              </button>-->
            `
        if (usuario.nombre_estado_us == "Habilitado") {
          template += `
                <button type="button" class="inline-button-eliminar deshabilitar-usu">
                  <i  class="fas fa-ban"></i> Deshabilitar
                </button>
                `
        }
        if (usuario.nombre_estado_us == "Deshabilitado") {
          template += `
                <button type="button" class="inline-button habilitar-usu">
                  <i class="fas fa-check-circle"></i> Habilitar
                </button>
                `
        }
        
        template += `
                <button type="button" class="inline-button-eliminar confirmar-eliminar">
                  <i class="fas fa-window-close mr-1"></i> Eliminar
                </button>
        
                `
      }


      template += `
            </div>
        </div>
            `
    });

    $('.usuarios-card').html(template);

   });
  }
  //TODO: BOTON DEL PANEL ACTUALIZAR
  $('#reloadButton').click(function() {
    let consulta = $("#buscar").val();
    // Llama a la función cargarContenido
    cargar_usuario(consulta);
  });

  // TODO: BTN CREAR USUARIO
  $('#btnnuevo').click(function () {
    $('#mnt_form')[0].reset();
    $('#mdltitulo').html('CREAR USUARIO');
    $("#accion").val("crear_usuario");
    $("#inst_cod").prop("readonly", false);
    $('#mdlmnt').modal('show');
  });


  //TODO: INSERTAR USUARIO
  $('#mnt_form').submit(function(e) {
    e.preventDefault();
    let nombre_usuario = $('#nombre-usu').val();
    let apellido_usuario = $('#apellido-usu').val();
    let fecha_nacimiento = $('#fecha-nacimiento').val();
    let ci = $('#ci').val();
    let telefono = $("#telefono").val();
    let correo = $('#correo').val();
    let contrasena = $('#contrasena').val();
    // obtener value option
    let select_tipo = $('#select-tipo').val()

    var accion = $("#accion").val()
    funcion = accion;
  
    let data = {
      funcion: funcion,
      nombre_usuario: nombre_usuario,
      apellido_usuario: apellido_usuario,
      fecha_nacimiento: fecha_nacimiento,
      ci: ci,
      telefono: telefono,
      correo: correo,
      contrasena: contrasena,
      select_tipo: select_tipo
    };
    $.post('../../controllers/usuario.php', data, function(response) {
      // console.log(response);
      response = response.trim();
      if (response.trim() === "add") {
        // Cambiar el contenido de texto dentro del span con el id "alert-exito"
        $("#alert-exito").html("<i class='fas fa-check'></i> Editado con Exito");
        // Mostrar el elemento #noexito
        $('#exito').hide().show(1000).delay(2000).hide(1000);
        $('#mnt_form').trigger('reset');
        cargar_usuario();
      } else if (response == "noadd") {
        // Cambiar el contenido de texto dentro del span con el id "alert-error"
        $("#alert-error").html("<i class='fas fa-times m-1'></i> Usuario ya Ingresado");
        // Mostrar el elemento #noexito
        $('#noexito').hide().show(1000).delay(2000).hide(1000);
      }else {
        const errores = JSON.parse(response);
        for (const clave in errores){
          const valor = errores[clave];
          // console.log(`La clave es ${clave} y el valor es ${valor}`);
          $('#'+clave).hide('slow');
          $('#'+clave).show(1000);
          $('#'+clave).hide(7000);
        }
      
      }
    
    });
  });


  // cuando se tecle se ejecuta una funcion de calban
  $(document).on('keyup','#buscar',function(){
    // cojo el valor id
    let valor = $(this).val();
    if(valor != ""){
      // console.log(valor);
      cargar_usuario(valor)

    }else{
      cargar_usuario();

    }
  })

//   // abrir el modal habiliar
//   $(document).on("click", ".habilitar-usu", function() {
//      // Obtener el div padre más cercano con la clase "card"
//      var cardPadre = $(this).closest('.card');
//      // Obtener el valor del atributo "usuarioId"
//      var id = cardPadre.attr('usuarioId');
//     $('#id_user').val(id);
//     $("#funcion").val("habilitar-usu");
//     $(".titulo-modal").html("HABILITAR USUARIO")
//     $("#modal-confirmar").css("display", "block");
//   });


//   // abrir el modal deshabiliar
//   $(document).on("click", ".deshabilitar-usu", function() {
//     // Obtener el div padre más cercano con la clase "card"
//     var cardPadre = $(this).closest('.card');
//     // Obtener el valor del atributo "usuarioId"
//     var id = cardPadre.attr('usuarioId');
//    $('#id_user').val(id);
//    $("#funcion").val("deshabilitar-usu");
//    $(".titulo-modal").html("DESHABILITAR USUARIO")
//    $("#modal-confirmar").css("display", "block");
//  });


 // abrir el modal deshabiliar
 $(document).on("click", ".confirmar-eliminar", function() {
    // Obtener el div padre más cercano con la clase "card"
    var cardPadre = $(this).closest('.card');
    // Obtener el valor del atributo "usuarioId"
    var id = cardPadre.attr('usuarioId');
  $('#id_user').val(id);
  $("#funcion").val("borrar-usuario");
  $(".titulo-modal").html("ELIMINAR USUARIO")
  $("#modal-confirmar").css("display", "block");
  });


  // confirmar
  $('#form-confirmar').submit(e => {
    let pass = $('#input-confirmar').val();
    let id_usuario = $('#id_user').val();
    funcion = $('#funcion').val();
    // console.log(pass,id_usuario,funcion)
    $.post('../../controllers/usuario.php', { pass, id_usuario, funcion }, (response) => {
        response = response.trim();
        console.log(response);
        if (response == 'habilitado') {
            // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-exito").html("<i class='fas fa-check'></i> Habilitado con Exito");
            // Mostrar el elemento #exit
            $('.stylo-alerta-confirmacion').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
            cargar_usuario();
        } else if(response == 'deshabilitado'){
            // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-exito").html("<i class='fas fa-check'></i> Deshabilitado con Exito");
            // Mostrar el elemento #exit
            $('.stylo-alerta-confirmacion').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
            cargar_usuario();
        }else if(response == 'borrado'){
              // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-exito").html("<i class='fas fa-check'></i> Eliminado con Exito");
            // Mostrar el elemento #exit
            $('.stylo-alerta-confirmacion').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
            cargar_usuario();
        }else {
            // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-error").html("<i class='fas fa-times m-1'></i>Contraseña Incorrecta");
            // Mostrar el elemento #exit
            $('.stylo-alerta-rechazo').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
        }
        

    });
    e.preventDefault();
  })    


  



  //TODO: VALIDACIONES 
  //CEDULA
  $("#ci").on("input", function(e) {
    var inputValue = e.target.value;
    // Eliminar caracteres no numéricos con exprecion regulares
    inputValue = inputValue.replace(/[^\d]/g, '');
    // Validar cedula con 10 caracteres
    if (inputValue.length > 10) {
     inputValue = inputValue.slice(0, 10);
    }
    // Asignar el valor modificado de vuelta al campo de entrada
    e.target.value = inputValue;
  });

 // VALIDACION NOMBRE   
  function validacion_nombres(id) {
    $(id).on("input", function(e) {
        e.preventDefault();

        var inputValue = e.target.value;
        // Mantener solo letras, espacios, ñ y tildes en el valor del campo
        inputValue = inputValue.replace(/[^A-Za-zñÑáéíóúÁÉÍÓÚ\s]/g, '');

        // Dividir el valor en palabras
        var palabras = inputValue.split(' ');

        // Capitalizar solo la primera letra de la primera palabra
        if (palabras.length > 0) {
            palabras[0] = palabras[0].charAt(0).toUpperCase() + palabras[0].slice(1).toLowerCase();
        }

        // Capitalizar la primera letra de cada palabra (excepto la primera)
        for (var i = 1; i < palabras.length; i++) {
            palabras[i] = palabras[i].toLowerCase(); // Convertir la palabra completa a minúsculas
            palabras[i] = palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1);
        }

        // Unir las palabras de nuevo con espacios
        var resultado = palabras.join(' ');

        // Asignar el valor modificado de vuelta al campo de entrada
        $(this).val(resultado);
    });
  }

  // nombre
  validacion_nombres("#nombre-usu");
  // apellido
  validacion_nombres("#apellido-usu");


  //TODO: funcionamiento de modal 
  var cerrar = $(".close");
  var modal_confirmar = $("#modal-confirmar")
  cerrar.click(function() {
    // cerrar modal de usuario <span> (x)
    if (modal_confirmar.length) {
      modal_confirmar.css("display", "none");
    }
  });

  $(window).click(function(event) {
    if (modal_confirmar.length) {
      if (event.target == modal_confirmar[0]) {
        modal_confirmar.css("display", "none");
      }
    }
  });



});