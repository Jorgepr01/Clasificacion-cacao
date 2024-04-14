?>
<!DOCTYPE html>
<html lang="es">

<head>

    <title>Home | Administracion Usuario</title>
    <?php include_once("../Layouts/Head.php"); ?>

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
                <li class="breadcrumb-item"><a href="./index.php">Administracion Usuario</a></li>
            </ol>
            <!-- end breadcrumb -->


            <!-- begin page-header -->
            <h1 class="page-header">Administracion Usuario <small>Registrar, Modificar, Habilitar, Deshabilitar</small></h1>
            <!-- end page-header -->


            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Administracion Usuario</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" id="reloadButton" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                </div>
                <div class="panel-body">
                    <!-- CREAR PRODUCTO -->
                    <button type="button" id="btnnuevo" class="btn btn-primary"><i class="fas fa-plus"></i> Usuario</button>
                    <br><br>
                    <!--buscar -->
                    <div class="ds-buscar">
                        <label for="buscar">
                            <span><i class="fas fa-search"></i> BUSCAR</span>
                        </label>
                        <input type="text" class="form-control" id="buscar" placeholder="Buscar por nombre o apellido" required>
                    </div>

                    <div class="contenedor-card usuarios-card">

                    </div>
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

    <?php require_once("mnt.php") ?>

    <?php include_once("../Layouts/modal.php"); ?>
    <?php include_once("../Layouts/Js.php"); ?>
    <script type="text/javascript" src="./admin_usuario.js"></script>
</body>

</html>