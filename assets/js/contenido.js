$(document).ready(function () {
    // TODO: cambiar contraseña
    //  modal
    var modal_cambiar_contrasena = $("#modal-cambiar-contraseña");
    // Obtén el botón que abre el modal
    var btn_cambiar_contrasena = $(".cambiar-contrasena");

    // Cuando el usuario hace clic en el botón, abre el modal
    btn_cambiar_contrasena.click(function () {
        modal_cambiar_contrasena.css("display", "block");
    });


    $('#form-pass').submit(e => {
        let oldpass = $('#oldpass').val();
        let newpass = $('#newpass').val();
        funcion = 'cambiar_contra';
        $.post('../../controllers/usuario.php', {
            funcion,
            oldpass,
            newpass
        }, (response) => {
            // console.log(response)
            response = response.trim();
            if (response == 'update') {
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-pass').trigger('reset');

            } else {
                $('#noupdate').hide('slow');
                $('#noupdate').show(1000);
                $('#noupdate').hide(2000);
                $('#form-pass').trigger('reset');

            }


        })
        e.preventDefault();

    })









    var cerrar = $(".close");
    cerrar.click(function () {
        // cerrar modal de usuario <span> (x)
        if (modal_cambiar_contrasena.length) {
            modal_cambiar_contrasena.css("display", "none");
        }
    })


    $(window).click(function (event) {

        if (event.target === modal_cambiar_contrasena[0]) {
            modal_cambiar_contrasena.css("display", "none");
        }
    })

    
})