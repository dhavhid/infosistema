<br />
<div class="row">
    <div class="col-md-3">
        <a href="javascript:window.history.back();" class="btn btn-default">
            <i class="fa fa-times"></i>
            Cerrar
        </a>
        <a href="javascript:window.print();" class="btn btn-primary">
            <i class="fa fa-print"></i>
            Imprimir
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2><?php echo $persona['Persona']['primer_nombre'] . ' ' . $persona['Persona']['segundo_nombre'] . ' ' . $persona['Persona']['tercer_nombre'] . ' ' . $persona['Persona']['primer_apellido'] . ' ' . $persona['Persona']['segundo_apellido']?></h2>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Datos personales</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
            <li>
                <span>Tel&eacute;fono de oficina:</span>
                <?php echo $persona['Persona']['telefono_oficina']?>
            </li>
            <li>
                <span>Tel&eacute;fono celular:</span>
                <?php echo $persona['Persona']['telefono_celular']?>
            </li>
            <li>
                <span>Tel&eacute;fono de casa:</span>
                <?php echo $persona['Persona']['telefono_casa']?>
            </li>
            <li>
                <span>Correo electr&oacute;nico:</span>
                <?php echo $persona['Persona']['correo_electronico']?>
            </li>
            <li>
                <span>Correo electr&oacute;nico personal:</span>
                <?php echo $persona['Persona']['correo_electronico_secundario']?>
            </li>
        </ul>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Credenciales</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>                
            <li>
                <span>Nombre de usuario:</span>
                <?php echo $usuario['Usuario']['usuario']?>
            </li>
            <li>
                <span>M&oacute;dulos a los que tiene acceso:</span>
                <?php
                    if( $usuario['Usuario']['modulo_administracion'] == 1 )echo "Administraci&oacute;n";
                    if( $usuario['Usuario']['modulo_busqueda'] == 1 )echo ", B&uacute;squeda";
                    if( $usuario['Usuario']['modulo_empresa'] == 1 )echo ", Empresas y servicios tecnol&oacute;gicos";
                    if( $usuario['Usuario']['modulo_reporte'] == 1 )echo ", Reportes";
                    if( $usuario['Usuario']['modulo_ticket'] == 1 )echo ", Tickets";
                ?>
            </li>
            <li>
                <span>Fecha de creaci&oacute;n:</span>
                <?php echo date('d-m-Y',strtotime($persona['Persona']['created']))?>
            </li>
        </ul>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Empresa</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>                
            <li>
                <span>Nombre de la empresa a la que sirve de contacto:</span>
                <?php echo $empresa['Empresa']['nombre_empresa']?>
            </li>
        </ul>
    </div>
</div>
