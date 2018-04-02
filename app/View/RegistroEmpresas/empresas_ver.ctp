<br />
<div class="row">
    <div class="col-md-3">
        <?php if( $cerrar == 1 ){?>
        <a href="javascript:window.history.back();" class="btn btn-default">
            <i class="fa fa-times"></i>
            Cerrar
        </a>
        <?php }?>
        <a href="javascript:window.print();" class="btn btn-primary">
            <i class="fa fa-print"></i>
            Imprimir
        </a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-1">
        <?php if( strlen($empresa['Empresa']['logotipo']) > 0 ){?>
            <img data-src="" class="img-thumbnail" align="Logo" src="<?php echo FULL_BASE_URL . DS . 'files' . DS . 'logos' . DS . $empresa['Empresa']['logotipo']?>" width="100">
        <?php }?>
    </div>
    <div class="col-md-11">
        <h3><?php echo $empresa['Empresa']['nombre_empresa']?></h3>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Perfil</h3>
        </div>
    </div>
</div>
<br />
<?php if( strlen($empresa['Empresa']['comentario_adicional']) > 0 ){?>
    <div class="row">
        <div class="col-md-12">
            <?php echo $empresa['Empresa']['comentario_adicional']?>
        </div>
    </div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <ul>
            <li>
                <span>NIT:</span>
                <?php echo $empresa['Empresa']['nit']?>
            </li>
            <li>
                <span>N&uacute;mero de registro:</span>
                <?php echo $empresa['Empresa']['numero_registro']?>
            </li>
            <li>
                <span>Actividad / Giro de la empresa:</span>
                <?php echo $empresa['Empresa']['giro']?>
            </li>
            <li>
                <span>Contacto:</span>
                <?php echo $empresa['Persona']['primer_nombre'] . ' ' . $empresa['Persona']['primer_apellido']?>
            </li>
            <li>
                <span>Direcci&oacute;n:</span>
                <?php echo $empresa['Empresa']['direccion_final'] . '<br />' . $empresa['Municipio']['nombre_municipio'] . '<br />' . $empresa['Departamento']['nombre_departamento'];?>
            </li>
            <li>
                <span>Tel&eacute;fono:</span>
                <?php echo $empresa['Empresa']['telefono']?>
            </li>
            <li>
                <span>Fax:</span>
                <?php echo $empresa['Empresa']['fax']?>
            </li>
            <li>
                <span>Correo Electr&oacute;nico:</span>
                <?php echo $empresa['Empresa']['correo_electronico']?>
            </li>
            <li>
                <span>Direcci&oacute;n de sitio web:</span>
                <?php echo $empresa['Empresa']['website']?>
            </li>
            <li>
                <span>Redes sociales:</span>
                <ul>
                    <li><span>Facebook: </span><?php echo $empresa['Empresa']['facebook']?></li>
                    <li><span>Twitter: </span><?php echo $empresa['Empresa']['twitter']?></li>
                    <li><span>Google+ </span><?php echo $empresa['Empresa']['google+']?></li>
                    <li><span>Skype </span><?php echo $empresa['Empresa']['skype']?></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>&Aacute;reas y subareas de conocimiento y especialidad</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>&Aacute;rea</th>
                    <th>Bachillerato &oacute; T&eacute;cnico</th>
                    <th>Doctorado</th>
                    <th>Licenciatura &oacute; Ingenier&iacute;a</th>
                    <th>Maestr&iacute;a</th>
                    <th>Subareas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $areas as $area ):
                    ?>
                    <tr>
                        <td><?php echo $area['Area']['nombre_area']?></td>
                        <td><?php echo $area['Area']['bachillerato_tecnico']?></td>
                        <td><?php echo $area['Area']['doctorado']?></td>
                        <td><?php echo $area['Area']['licenciatura']?></td>
                        <td><?php echo $area['Area']['maestria']?></td>
                        <td><?php echo $area['Area']['subareas']?></td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Laboratorios</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Laboratorio</th>
                    <th>Experimentaci&oacute;n &oacute; Pr&aacute;cticas</th>
                    <th>Investigaci&oacute;n</th>
                    <th>Investigaci&oacute;n y Desarrollo</th>
                    <th>Pruebas y Ensayos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $laboratorios as $laboratorio ):
                    ?>
                    <tr>
                        <td><?php echo $laboratorio['Laboratorio']['nombre_laboratorio']?></td>
                        <td>
                            <ul>
                                <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['experimentacion']?></li>
                                <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_experimentacion']?></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['investigacion']?></li>
                                <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_investigacion']?></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['investigacion_desarrollo']?></li>
                                <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_investigacion_desarrollo']?></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['pruebas_ensayos']?></li>
                                <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_pruebas_ensayos']?></li>
                            </ul>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Recursos para la administraci&oacute;n</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
        <?php
        foreach( $recursos as $recurso ):
            ?>
            <li><?php echo $recurso['RecursosServicio']['nombre_recurso']?></li>
            <?php
        endforeach;
        ?>
        </ul>            
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Infraestructura</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
        <?php
        foreach( $infraestructuras as $infraestructura ):
            ?>
            <li><?php echo $infraestructura['Infraestructura']['nombre_infraestructura']?></li>
            <?php
        endforeach;
        ?>
        </ul> 
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Empresas solicitantes de los servicios tecnol&oacute;gicos (Cantidad por tipo)</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
            <li>
                <span>Micro empresa:</span>
                <?php echo $solicitante['EmpresasSolicitante']['microempresa']?>
            </li>
            <li>
                <span>Peque&ntilde;a empresa:</span>
                <?php echo $solicitante['EmpresasSolicitante']['pequenaempresa']?>
            </li>
            <li>
                <span>Mediana empresa:</span>
                <?php echo $solicitante['EmpresasSolicitante']['medianaempresa']?>
            </li>
            <li>
                <span>Gran empresa:</span>
                <?php echo $solicitante['EmpresasSolicitante']['granempresa']?>
            </li>
            <li>
                <span>Emprendedores:</span>
                <?php echo $solicitante['EmpresasSolicitante']['emprendedores']?>
            </li>
            <li>
                <span>Instituciones:</span>
                <?php echo $solicitante['EmpresasSolicitante']['instituciones']?>
            </li>
        </ul> 
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Medios de atenci&oacute;n al cliente</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
            <?php if( $contacto['FormasContacto']['enoficina'] == 1 ) echo '<li>En Oficina</li>'?>
            <?php if( $contacto['FormasContacto']['viatelefono'] == 1 ) echo '<li>V&iacute;a Tel&eacute;fono</li>'?>
            <?php if( $contacto['FormasContacto']['viaemail'] == 1 ) echo '<li>V&iacute;a E-Mail</li>'?>
            <?php if( $contacto['FormasContacto']['viawebsite'] == 1 ) echo '<li>V&iacute;a Website</li>'?>
            <?php if( $contacto['FormasContacto']['viaskype'] == 1 ) echo '<li>V&iacute;a Skype</li>'?>
            <?php if( $contacto['FormasContacto']['eventual'] == 1 ) echo '<li>In situ en Clientes / Proyecto (eventual) </li>'?>
            <?php if( $contacto['FormasContacto']['extensionismo'] == 1 ) echo '<li>In situ en Clientes (Extensionismo)</li>'?>
            <?php if( strlen($contacto['FormasContacto']['otrasformas']) > 0 ) echo '<li>'.$contacto['FormasContacto']['otrasformas'].'</li>'?>
        </ul> 
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Medios de pago</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
            <?php if( $pago['FormasPago']['enefectivo'] == 1 ) echo '<li>En Efectivo</li>'?>
            <?php if( $pago['FormasPago']['tarjetacredito'] == 1 ) echo '<li>Tarjeta de Cr&eacute;dito</li>'?>
            <?php if( $pago['FormasPago']['depositocuenta'] == 1 ) echo '<li>Dep&oacute;sito a Cuenta</li>'?>
            <?php if( $pago['FormasPago']['cheque'] == 1 ) echo '<li>Cheque</li>'?>
            <?php if( $pago['FormasPago']['transferencia'] == 1 ) echo '<li>Transferencia</li>'?>
            <?php if( $pago['FormasPago']['paypal'] == 1 ) echo '<li>PayPal</li>'?>
            <?php if( strlen($pago['FormasPago']['otrosmedios']) > 0 ) echo '<li>'.$pago['FormasPago']['otrosmedios'].'</li>'?>
        </ul> 
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Servicios Tecnol&oacute;gicos</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
        <?php
        foreach( $serviciostecnologicos as $servicio ):
            ?>
            <li><?php echo $servicio['ServicioTecnologico']['nombre_servicio']?></li>
            <?php
        endforeach;
        ?>
        </ul>            
    </div>
</div>