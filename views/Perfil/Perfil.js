$(document).ready(function () {
  var funcion = "";
  var template = '';
  dato_usuario();

  function dato_usuario() {
    funcion = 'dato_usuario';
    $.post('../../controllers/usuario.php', {
      funcion
    }, (response) => {
      template = '';
      const datos = JSON.parse(response);
      const usuario = datos[0];
      template += `
            <h1 class="titulo">DATOS PERSONALES</h1>
            <div class="display-perfil">
                    <div class="personal-info">
                      <h2>DATOS</h2>
                    
                      <div class="image">
                        <img src="../../uploads/avatar/${usuario.avatar}">
                      </div>
                      <ul>
                        <li><b style="color:#0b7300">NOMBRES:</b><a id="nombre"></a> ${usuario.nombres}</li>
                        <li><b style="color:#0b7300">APELLIDOS:</b><a id="apelllido"></a> ${usuario.apellidos}</li>
                        <li><b style="color:#0b7300">EDAD:</b><a id="edad"></a> ${usuario.edad}</li>
                        <li><b style="color:#0b7300">C.I: </b><a id="ci"></a>${usuario.ci}</li>
                        <li>
                          <b style="color:#0b7300">TIPO DE USUARIO:</b>
                          <span id="us_tipo">${usuario.nombre_tipo}</span>
                        </li>
                        <li><button class="inline-button btn-avatar">CAMBIAR AVATAR</button></li>
                      </ul>
                    </div>
                    
                    <div class="Formulario">
                    <form id="act_perfil">
                        <div>
                          <label for="nombre-usu">
                            <span><i class="fas fa-user"></i> NOMBRES</span>
                          </label>
                          <input type="text" id="nombre" name="nombre" class='input-_update' placeholder="${usuario.nombres}" required><br>
                        </div>
                        <div>
                          <label for="nombre-apellido">
                            <span><i class="fas fa-user"></i> APELLIDO:</span>
                          </label>
                          <input type="text" id="apellido" class='input-_update' name="apellido" placeholder="${usuario.apellidos}" required><br>
                        </div>
                        <div>
                          <label for="telefono">
                            <span><i class="fas fa-phone"></i> TELEFONO</span>
                          </label>
                          <input type="tel" id="telefono" class='input-_update' name="telefono" placeholder="${usuario.telefono}" required><br>
                        </div>
                        <br>
                        <button type="submit" class="inline-button-editar">Guardar </button>                     </form>
                    </div>
                </div>
            
              `

      $('#datos_personales').html(template)






    })
  }
  //TODO: BOTON DEL PANEL ACTUALIZAR
  $('#reloadButton').click(function () {
    dato_usuario();
  });



  // //TODO: Modal de cambiar avatar
  // var act_perfil = $("#modal-cambiar-avatar");
  $('#act_perfil').on('click', '.btn_act', function () {
    //   Tu código para mostrar el modal aquí
    funcion = 'act_perfil';
    $.post('../../controllers/usuario.php', {
      funcion
    }, (response) => {
      template = '';
      template += `
            <h1 class="titulo">DATOS PERSONALES</h1>
            <div class="display-perfil">
                    <div class="personal-info">
                      <h2>DATOS</h2>
                    
                      <div class="image">
                        <img src="../../uploads/avatar/${usuario.avatar}">
                      </div>
                      <ul>
                        <li><b style="color:#0b7300">NOMBRES:</b><a id="nombre"></a> ${usuario.nombres}</li>
                        <li><b style="color:#0b7300">APELLIDOS:</b><a id="apelllido"></a> ${usuario.apellidos}</li>
                        <li><b style="color:#0b7300">EDAD:</b><a id="edad"></a> ${usuario.edad}</li>
                        <li><b style="color:#0b7300">C.I: </b><a id="ci"></a>${usuario.ci}</li>
                        <li>
                          <b style="color:#0b7300">TIPO DE USUARIO:</b>
                          <span id="us_tipo">${usuario.nombre_tipo}</span>
                        </li>
                        <li><button class="inline-button btn-avatar">CAMBIAR AVATAR</button></li>
                      </ul>
                    </div>
                    
                    <div class="">
                      <form id="act_perfil">
                        <div>
                          <label for="nombre">Nombre</label><br>
                          <input type="text" id="nombre" name="nombre" class='input-_update' required><br>
                        </div>
                        <div>
                          <label for="apellido">Apellido</label><br>
                          <input type="text" id="apellido" class='input-_update' name="apellido" required><br>
                        </div>
                        <div>
                          <label for="telefono">Teléfono</label><br>
                          <input type="tel" id="telefono" class='input-_update' name="telefono" required><br>
                        </div>
                        <br>
                        
                          <button type="submit" style="background:red;" class="inline-button-editar"></button>
                        
                      </form>
                    </div>
                </div>
              `;

      $('#datos_personales').html(template)

    })
    modal_cambiar_avatar.css("display", "block");
  });


  //TODO: Modal de cambiar avatar
  var modal_cambiar_avatar = $("#modal-cambiar-avatar");
  $('#datos_personales').on('click', '.btn-avatar', function () {
    //   Tu código para mostrar el modal aquí
    funcion = 'buscar_avatar_usuario';
    $.post('../../controllers/usuario.php', {
      funcion
    }, (response) => {
      template = '';
      template += `
          <img src="../../uploads/avatar/${response}">
        `;

      $('.vista-previa').html(template)

    })
    modal_cambiar_avatar.css("display", "block");
  });

  //TODO: SUBIR AVATAR
  $('#form-avatar').submit(e => {
    let formData = new FormData($('#form-avatar')[0]);
    formData.append('funcion', 'cambiar_avatar');
    // Verificar si se seleccionó un archivo
    $.ajax({
      url: '../../controllers/usuario.php',
      type: 'POST',
      data: formData,
      processData: false, // Evita que jQuery procese los datos
      contentType: false, // Evita que jQuery configure el tipo de contenido
      cache: false, // Evita el almacenamiento en caché de la solicitud
    }).done(function (response) {
      const json = JSON.parse(response);
      if (json.alert == 'edit') {
        $('#edit').hide('slow');
        $('#edit').show(1000);
        $('#edit').hide(2000);
        $('#form-avatar').trigger('reset');
        dato_usuario();
      } else {
        $('#noedit').hide('slow');
        $('#noedit').show(1000);
        $('#noedit').hide(2000);
        $('#form-photo').trigger('reset');
        e.preventDefault();
      }

    });


  })



    //TODO: editar datos del usuario
   // Asignar el evento submit después de inyectar el formulario
   $("#act_perfil").on('submit', function(e) {
    e.preventDefault(); // Previene el comportamiento por defecto del submit
    console.log("entro")
  })


  // mostrar img
  var input_avatar = $('#avatar');
  input_avatar.change(mostrarImagen);

  function mostrarImagen() {
    var input_avatar = $('#avatar')[0]; // Accede al elemento HTML subyacente
    var vista_previa = $('.vista-previa');

    // Verificar si se seleccionó un archivo
    if (input_avatar.files.length > 0) {
      var imagen_seleccionada = input_avatar.files[0];

      // Verificar si el archivo es una imagen
      if (imagen_seleccionada.type.startsWith('image/')) {
        var imagen = new Image();
        imagen.src = URL.createObjectURL(imagen_seleccionada);
        imagen.style.maxWidth = '100%';
        vista_previa.empty(); // Limpiar vista previa anterior
        vista_previa.append(imagen);
      } else {
        alert('El archivo seleccionado no es una imagen.');
        input_avatar.value = ''; // Limpiar la selección
      }
    } else {
      vista_previa.empty(); // Limpiar vista previa si no se selecciona ningún archivo
    }
  }

  //TODO: funcionamiento de modal 
  var cerrar = $(".close");
  cerrar.click(function () {
    // cerrar modal de usuario <span> (x)
    if (modal_cambiar_avatar.length) {
      modal_cambiar_avatar.css("display", "none");
    }
  });

  var btn_cer_cam_av = $('.cerrar-cambiar-avatar');
  btn_cer_cam_av.click(function () {

    let input_avatar = $('#avatar');

    // Restablece el campo de entrada de archivo a un estado vacío
    input_avatar.val(''); // Esto establecerá el valor del campo a una cadena vacía
    modal_cambiar_avatar.css("display", "none");

  })

  $(window).click(function (event) {
    if (modal_cambiar_avatar.length) {
      if (event.target == modal_cambiar_avatar[0]) {
        modal_cambiar_avatar.css("display", "none");
      }
    }
  });
});