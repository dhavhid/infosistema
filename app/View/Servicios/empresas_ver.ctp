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
    <div class="col-md-12">
        <h3><?php echo $servicio['ServicioTecnologico']['nombre_servicio']?></h3>
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
<?php if( strlen($servicio['ServicioTecnologico']['descripcion_servicio']) > 0 ){?>
<div class="row">
    <div class="col-md-12">
        <?php echo $servicio['ServicioTecnologico']['descripcion_servicio']?>
    </div>
</div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <ul>
            <?php if( $persona['Usuario']['modulo_empresa'] == 1 ){?>
            <li>
                <span>Empresa:</span>
                <?php echo $servicio['Empresa']['nombre_empresa']?>
            </li>
			<?php }?>
            <li>
                <span>Pasos para proveer el servicio tecnol&oacute;gico:</span>
                <?php echo $servicio['ServicioTecnologico']['pasos_servicio']?>
            </li>
            <li>
                <span>Precio:</span>
                <?php echo $this->Number->currency($servicio['ServicioTecnologico']['precio_servicio'], 'USD')?>
            </li>
            <li>
                <span>Capacidad de servicios tecnológicos por mes:</span>
                <?php echo $servicio['ServicioTecnologico']['capacidad_por_mes']?>
            </li>
            <li>
                <span>Promedio de servicios tecnológicos actuales provistos por mes:</span>
                <?php echo $servicio['ServicioTecnologico']['servicios_por_mes']?>
            </li>
            <li>
                <span>Tiempo de respuesta o de tr&aacute;mite para brindar el servicio tecnol&oacute;gico:</span>
                <?php echo $servicio['ServicioTecnologico']['tiempo_respuesta']?>
            </li>
            <li>
                <span>Tiempo en la realizaci&oacute;n del servicio tecnol&oacute;gico y entrega de resultados:</span>
                <?php echo $servicio['ServicioTecnologico']['tiempo_realizacion']?>
            </li>
            <li>
                <span>Elegibilidad del servicio:</span>
                <?php echo $servicio['ServicioTecnologico']['eligibilidad']?>
            </li>
            <li>
                <span>Clientes actuales:</span>
                <?php echo $servicio['ServicioTecnologico']['clientes_actuales']?>
            </li>
            <li>
                <span>Clientes potenciales:</span>
                <?php echo $servicio['ServicioTecnologico']['clientes_potenciales']?>
            </li>
            <li>
                <span>Precisi&oacute;n:</span>
                <?php echo $servicio['ServicioTecnologico']['precision']?>
            </li>
            <li>
                <span>Tiempo de ofertar el servicio tecnol&oacute;gico en el mercado:</span>
                <?php echo $servicio['ServicioTecnologico']['tiempo_en_mercado']?>
            </li>
            <li>
                <span>Ofrece sus servicios a medias, peque&ntilde;as y micro empresas:</span>
                <?php echo ($servicio['ServicioTecnologico']['gran_empresa'] == 1)? 'Si' : 'No' ;?>
                <?php echo $servicio['ServicioTecnologico']['gran_empresa_porque']?>
            </li>
            <li>
                <span>Si ofrece sus servicios a medias, peque&ntilde;as y micro empresas, &iquest;har&iacute;a alg&uacute;n tipo de oferta para que este tipo de empresas adquieran su servicio tecnol&oacute;gico?:</span>
                <?php echo ($servicio['ServicioTecnologico']['ofreceria_oferta'] == 1)? 'Si' : 'No' ;?>
                <?php echo $servicio['ServicioTecnologico']['ofreceria_oferta_porque']?>
            </li>
        </ul>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Tipo de servicio tecnol&oacute;gico</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
       <ul>
       		<?php if( array_key_exists('TipoServicio', $tiposervicio) ){?>
	            <?php if( $tiposervicio['TipoServicio']['servicio_tecnologico'] == 1 ) echo '<li>Servicio Tecnol&oacute;gicos</li>'?>
	            <?php if( $tiposervicio['TipoServicio']['transferencia_tecnologia'] == 1 ) echo '<li>Transferencia de Tecnolog&iacute;a</li>'?>
	            <?php if( $tiposervicio['TipoServicio']['proyectos_id'] == 1 ) echo '<li>Proyectos I+D</li>'?>
	            <?php if( $tiposervicio['TipoServicio']['proyectos_especiales'] == 1 ) echo '<li>Proyectos Especiales</li>'?>
	            <?php if( $tiposervicio['TipoServicio']['desarrollo_rrhh'] == 1 ) echo '<li>Desarrollo de RRHH</li>'?>
	            <?php if( strlen($tiposervicio['TipoServicio']['otros']) > 1 ) echo '<li>'.$tiposervicio['TipoServicio']['otros'].'</li>'?>
			<?php }?>	
       </ul>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-md-12">
        <div class="titulo_seccion">
            <h3>Categor&iacute;as de apoyo</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
        <?php 
        foreach( $categorias as $categoria ):
            ?>
            <li><?php echo $categoria['CategoriasApoyo']['subcategoria_nombre']?> (<?php echo $categoria['CategoriasApoyo']['categoria_nombre']?>)</li>
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
            <h3>Sectores de apoyo</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
        <?php
        foreach( $sectores as $sector ):
            ?>
            <li><?php echo $sector['SectoresApoyo']['sector_nombre']?></li>
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
            <h3>Tipo de empresas a las que se provee el servicio</h3>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <ul>
        	<?php if( array_key_exists('EmpresasServicio', $empresaservicio) ){?>
	            <?php if( $empresaservicio['EmpresasServicio']['microempresa'] == 1 ) echo '<li>Micro empresa</li>'?>
	            <?php if( $empresaservicio['EmpresasServicio']['pequenaempresa'] == 1 ) echo '<li>Peque&ntilde;a empresa</li>'?>
	            <?php if( $empresaservicio['EmpresasServicio']['medianaempresa'] == 1 ) echo '<li>Mediana empresa</li>'?>
	            <?php if( $empresaservicio['EmpresasServicio']['granempresa'] == 1 ) echo '<li>Gran empresa</li>'?>
	            <?php if( $empresaservicio['EmpresasServicio']['emprendedores'] == 1 ) echo '<li>Emprendimiento / Incubaci&oacute;n</li>'?>
	            <?php if( $empresaservicio['EmpresasServicio']['instituciones'] == 1 ) echo '<li>Instituciones</li>'?>
			<?php }?>
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