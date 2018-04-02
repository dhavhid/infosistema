<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Abrir me&uacute;</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#"><i class="fa fa-home"></i></a></li>
        <li <?php echo ( !empty($menu_activo) && $menu_activo == 'buscar' )? 'class="active"' : '' ;?>><a href="/busquedas"><i class="fa fa-search"></i> B&uacute;squeda</a></li>
        <li class="dropdown <?php echo ( !empty($menu_activo) && $menu_activo == 'empresas' )? 'active' : '' ;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-building-o"></i> Empresas <span class="fa fa-angle-down"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/empresas/registroempresas">Registro de empresas</a></li>
            <li><a href="/empresas/servicios">Servicios tecnol&oacute;gicos</a></li>
          </ul>
        </li>
        <li <?php echo ( !empty($menu_activo) && $menu_activo == 'tickets' )? 'class="active"' : '' ;?>><a href="/tickets"><i class="fa fa-tags"></i> Tickets</a></li>
        <li class="dropdown <?php echo ( !empty($menu_activo) && $menu_activo == 'reportes' )? 'active' : '' ;?>">
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-print"></i> Reportes  <span class="fa fa-angle-down"></span></a>
        	<ul class="dropdown-menu" role="menu">
        		<li><a href="/reportes/usuarios">Usuarios</a></li>
        		<li><a href="/reportes/empresas">Empresas</a></li>
        		<li><a href="/reportes/servicios">Servicios Tecnol&oacute;gicos</a></li>
        		<li><a href="/reportes/tickets">Tickets</a></li>
        	</ul>
        </li>
        <li class="dropdown <?php echo ( !empty($menu_activo) && $menu_activo == 'administracion' )? 'active' : '' ;?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> Administraci&oacute;n <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/admin/usuarios/">Usuarios</a></li>
                <li class="divider"></li>
                <li><a href="/admin/actividades">Actividades econ&oacute;micas</a></li>
                <li><a href="/admin/contribuyentes">Contribuyentes</a></li>
            </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $nombre_completo?> <span class="fa fa-angle-down"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/usuarios/perfil/<?php echo $logged_in_user['Usuario']['id']?>">Mi Perfil</a></li>
            <li><a href="/admin/usuarios/credenciales/<?php echo $logged_in_user['Usuario']['id']?>">Cambiar contrase&ntilde;a</a></li>
            <li class="divider"></li>
            <li><a href="/sesiones/salir">Salir</a></li>
          </ul>
        </li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<br /><br /><br />