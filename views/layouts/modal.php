<div class="modal modal-message" id="mdlcarga">
  <div class="modal-dialog d-flex align-items-center justify-content-center">
    <div class="fa-3x">
      <i class="fas fa-sync fa-spin text-white"></i>
    </div>
  </div>
</div>


<!-- MODAL CONFIRMAR-->
<div id="modal-confirmar" class="modal-propio">
  <div class="modal-content-propio">
  <span class="close">&times;</span>
  <h4 class="titulo-modal"></h1>
  <div class="stylo-alerta-confirmacion" id="exito" style='display:none;'>
    <span class="alert-exito"></span>
  </div>
  <div class="stylo-alerta-rechazo" id="rechazar" style='display:none;'>
    <span class="alert-error"></span>
  </div>
    <!-- form de cambiar contraseña -->
    <form id="form-confirmar" class="formulario">
        <!-- contraseña vieja input -->
              <div class="form">
                <input type="password" class="form-control" id="input-confirmar" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> INGRESAR PASSWORD</span>
		            </label>
              </div>
              <!-- para darle id usuario -->
              <input type="hidden" id="id_user">
              <input type="hidden" id="funcion">
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button">CONFIRMAR</button>
        
      </div> 
       
     </form>
  </div>
</div>