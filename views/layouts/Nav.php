<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav" id="nav-perfil">
			
		</ul>
		<!-- end sidebar user -->


		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="nav-header">Menu</li>
			<!-- ADMINISTRADOR Y ROOT -->
			<?php
			// if ($_SESSION['us_tipo'] == 1) {
			?>
				<li class="has-sub">
					<a href="../Home/admin_catalogo.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-home fa-fw"></i>
						<span>Home</span>
					</a>
				</li>

				<li class="has-sub">
					<a href="../Admin_usuario/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-users"></i>
						<span>Administracion Usuario</span>
					</a>

				</li>


				<li class="has-sub">
					<a href="../Proyecto/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-bullseye"></i>
						<span>procesamiento de Imágenes</span>
					</a>

				</li>
			<?php
			// } else {
			// 	header('Location: ../../controllers/login.php');
			// }
			?>

			<!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->
