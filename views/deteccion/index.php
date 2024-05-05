<?php
session_name("agrocacao");
//inciar sesiones 
session_start();
//para destruir session
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <title>Home | Procesamiento</title>
    <?php include_once("../Layouts/Head.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="../../assets/css/deteccion.css">
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

        <?php include_once("../Layouts/Header.php"); ?>


        <?php include_once("../Layouts/Nav.php"); ?>

        <!-- begin #content -->
        <div id="content" class="content">

            <!-- begin breadcrumb -->
            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="../../controllers/login.php">Home</a></li>
                <li class="breadcrumb-item"><a href="./index.php">Procesamiento de Imágenes</a></li>
            </ol>
            <!-- end breadcrumb -->


            <!-- begin page-header -->
            <h1 class="page-header">Procesamiento de Imágenes <small>Cargar, Identidicar, Procesar, Gua</small></h1>
            <!-- end page-header -->


            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Procesamiento de Imágenes</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                </div>
                <div class="panel-body">





				<div class="flex flex-col gap-2 md:gap-4 xl:gap-6" id="Presentation">
  <div class="grid md:grid-cols-2 items-start gap-4 xl:gap-8" id="ContDeteccion">
    <div id="webcam-container" class="w-75 object-cover rounded-lg overflow-hidden border dark:border-gray-800" style="max-width: 100%;
    height: auto; margin:auto; object-fit: cover; display:none" ></div>
    <img
      alt="Image"
      class="w-70 object-cover rounded-lg overflow-hidden border dark:border-gray-800"
      height="700"
      src="./Sana.jpg"
      width="1050"
      style="aspect-ratio: 1050 / 700; object-fit: cover;"
      id="preview-image"
    />
    <div id="detalleseleccion" name="detalleseleccion" class="este">





<!-- caja par subir el eviar y la camara :) -->
    <div class="grid gap-2">
      <h1 class="text-4xl font-bold text-gray-900 " id="descripccion"><b>Descripción</b></h1>

      <!-- Texto de la descripccion -->
      <div id="descripcionImagen"></div>
      <div id="label-container"></div>

<br/>
      <!-- Camara y File -->
      <div class="flex items-center justify-center">
        
      <!-- Subir un file -->

        <label
          for="file-upload"
          class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:hover:text-gray-950"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="mr-2 h-5 w-5"
          >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" x2="12" y1="3" y2="15"></line>
          </svg>
          Subir Imagen
        </label>
        <input id="file-upload" class="sr-only" accept="image/*" type="file" />

        <!-- camara -->
        <button
          type="button"
          onclick="init()"
		  id="cam"
          class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="mr-2 h-5 w-5"
          >
            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
            <circle cx="12" cy="13" r="3"></circle>
          </svg>
          Camara
        </button>
      </div>
    
      <div>
        <button
          type="submit"
          id="enviarData"
          onclick="enviar()"
          class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600"
        >
          Enviar
        </button>
      </div>














    </div>

    </div>
  </div>
</div>
<!-- loading -->
<div class="loading-overlay" id="overlay">
  <div class="loader lds-facebook lds-dual-ring" id="loading"></div>

</div>

<script src="./descrition.js"></script>
<script src="./deteccion.js"></script>













					



				
                    
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end #content -->



    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->


    <?php include_once("../Layouts/modal.php"); ?>
    <?php include_once("../Layouts/Js.php"); ?>
    <script type="text/javascript" src="../admin_usuario/admin_usuario.js"></script>
</body>

</html>

<?php
} else {
    header('Location: ../../controllers/login.php');
}
?>