<div id="menu-perfil" class="navbar fullwidth">
	<div class="navbar navbar-default navbar-fixed-top" role="navigation" id="menu" hidden>
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="./" id="mMain"><span class="glyphicon glyphicon-home"></span></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li id="mEnEspera" name="En Espera" class="dropdown">
						<a href="listado.php?t=En Espera" name="mButton[]"><span class="glyphicon glyphicon-time"></span> En Espera</a>
					</li>

					<li id="mRevisado" name="Revisado" class="dropdown">
						<a href="listado.php?t=Revisado" name="mButton[]"><span class="glyphicon glyphicon-edit"></span> Revisado</a>
					</li>

					<li id="mEnviado" name="Enviado" class="dropdown">
						<a href="listado.php?t=Enviado" name="mButton[]"><span class="glyphicon glyphicon-ok"></span> Enviado</a>
					</li>

					<li id="mConErrores" name="Con Errores" class="dropdown">
						<a href="listado.php?t=Con Errores" name="mButton[]"><span class="glyphicon glyphicon-remove"></span> Con Errores</a>
					</li>

					<li class="dropdown" id="menu-sesion">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Sesión <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="logout.php"><span class="glyphicon glyphicon-lock"></span> Cerrar Sesión</a></li>
							<li class="divider"></li>
							<li><a href="cambiarpass.php"><span class="glyphicon glyphicon-cog"></span> Cambiar Contraseña</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="theme-showcase docbody" role="main">
	<div id="logo" class="theme-showcase"><center><img class="logo" src="../html/img/logo.png"/></center></div>
	<div class="container theme-showcase doccontent" id="cuerpo"><?php echo $content; ?></div>
	<div class="footer"><?php require(__DIR__ . "/template0f.php"); ?></div>
</div>
