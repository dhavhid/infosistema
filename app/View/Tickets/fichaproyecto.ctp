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
<div class="row contrato">
	<div class="col-md-offset-2 col-md-8"><center><h3>Ficha de Proyecto</h3></center></div>
</div>
<br /><br />
<div class="row contrato">
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">C&oacute;digo de Ficha: <u><?php echo $ticket['Ticket']['ficha_proyecto']?></u></div>
</div>
<div class="row contrato">	
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">
		<p><hr /></p>
		PARTE I, INFORMACI&Oacute;N GENERAL
	</div>
	<div class="col-md-offset-2 col-md-8">
		<p>
		Nombre de la empresa que solicita el servicio tecnol&oacute;gico: <strong><?php echo $ticket['Cliente']['nombre_empresa']?></strong>,
		Giro: <strong><?php echo $ticket['Cliente']['giro']?></strong>, N&deg; de registro <strong><?php echo $ticket['Cliente']['numero_registro']?></strong>,
		direcci&oacute;n: <strong><?php echo $ticket['Cliente']['direccion_final'] . ', ' . $ticket['Municipio']['nombre_municipio'] . ', ' . $ticket['Departamento']['nombre_departamento'] ?></strong>, 
		Tel&eacute;fono: <strong><?php echo $ticket['Cliente']['telefono']?></strong>; Correo Electr&oacute;nico: <strong><?php echo $ticket['Cliente']['correo_electronico']?></strong>,
		P&aacute;gina Web (si posee): <strong><?php echo $ticket['Cliente']['website']?></strong>
		</p>
	</div>
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">
		<p><hr /></p>
		PARTE II, DESCRIPCI&Oacute;N DEL SERVICIO TECNOL&Oacute;GICO
	</div>
	<div class="col-md-offset-2 col-md-8">
		<?php if( isset($oferente) ):?>
			<p>
			Nombre del servicio tecnol&oacute;gico: <strong>&#8220;<?php echo $oferente['ServicioTecnologico']['nombre_servicio']?>&#8221;</strong>
			</p>
			<p>
			Descripci&oacute;n del servicio tecnol&oacute;gico (en qu&eacute; consiste): <strong><?php echo ( array_key_exists('Contrato', $contrato) )? $contrato['Contrato']['descripcion_servicio'] : $oferente['ServicioTecnologico']['descripcion_servicio'] ;?></strong>
			</p>
			<p>
			Criterios de Aceptaci&oacute;n (seg&uacute;n la empresa solicitante): <strong><?php echo ( array_key_exists('Contrato', $contrato) )? $contrato['Contrato']['criterios_aceptacion'] : '&mdash;' ;?></strong>
			</p>
			<p>
			Afecta ingresar a programas de financiamiento: <strong><?php echo ( $ticket['Ticket']['financiamiento'] == 0 )? 'No' : '&mdash;' ;?></strong>, Fecha de inicio: <strong><?php echo ( array_key_exists('Contrato', $contrato) )? date('d-m-Y',strtotime($contrato['Contrato']['fecha_inicio'])) : '&mdash;' ;?></strong>
			</p>
		<?php endif;?>
	</div>
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">
		<p><hr /></p>
		PARTE III
	</div>
	<div class="col-md-offset-2 col-md-8">
		<p>
		Fecha de inicio de b&uacute;squeda y selecci&oacute;n de empresa oferente: <strong><?php echo date('d-m-Y',strtotime($ticket['Ticket']['fecha_apertura']))?></strong>
		</p>
		<p>
		Hay empresas que brinden el servicio tecnol&oacute;gico: <strong>Si</strong>
		</p>
		<p>
		Se seleccion&oacute; a una empresa oferente: <strong><?php echo (array_key_exists('Contrato', $contrato))? 'Si' : 'No' ;?></strong>
		</p>
	</div>
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">
		INFORMACI&Oacute;N GENERAL DE LA EMPRESA OFERTANTE SELECCIONADA
	</div>
	<div class="col-md-offset-2 col-md-8">
		<?php if( isset($oferente) ):?>
			<p>
			Nombre de la empresa que ofrece el servicio tecnol&oacute;gico: <strong><?php echo $oferente['Oferente']['nombre_empresa']?></strong>,
			Giro: <strong><?php echo $oferente['Oferente']['giro']?></strong>, N&deg; de registro <strong><?php echo $oferente['Oferente']['numero_registro']?></strong>,
			direcci&oacute;n: <strong><?php echo $oferente['Oferente']['direccion_final'] . ', ' . $oferente['Municipio']['nombre_municipio'] . ', ' . $oferente['Departamento']['nombre_departamento'] ?></strong>, 
			Tel&eacute;fono: <strong><?php echo $oferente['Oferente']['telefono']?></strong>; Correo Electr&oacute;nico: <strong><?php echo $oferente['Oferente']['correo_electronico']?></strong>,
			P&aacute;gina Web (si posee): <strong><?php echo $oferente['Oferente']['website']?></strong>
			</p>
			<p>
			Fecha de selecci&oacute;n de empresa oferente: <strong><?php echo date('d-m-Y',strtotime($ticket['Ticket']['fecha_cierre']))?></strong>
			</p>
		<?php endif;?>
	</div>
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">
		<p><hr /></p>
		PARTE IV
	</div>
	<div class="col-md-offset-2 col-md-8">
		<p>
		Fecha de finalizaci&oacute;n del proceso vinculador: <strong><?php echo ( array_key_exists('Contrato', $contrato) )? date('d-m-Y',strtotime($contrato['Contrato']['fecha_contrato'])) : '&mdash;' ;?></strong>
		</p>
		<p>
		&#191;Se concluy&oacute; con el proceso vinculador con la culminaci&oacute;n del ST o se di&oacute; por resuelto en contrato? <strong>El proceso vinculador est&aacute; <?php echo (array_key_exists('Contrato', $contrato))? $ticket['Ticket']['estado'] . ' por medio de un contrato' : $ticket['Ticket']['estado'] ;?>.</strong>
		</p>
		<p>
		Logr&oacute; la empresa solicitante alg&uacute;n programa que ayude en la inversi&oacute;n: <strong><?php echo ( $ticket['Ticket']['financiamiento'] == 0 )? 'No' : 'Si' ;?></strong>, 
		observaciones sobre este proceso: <strong><?php echo $ticket['Ticket']['observaciones_financiamiento']?></strong>
		</p>
		<p>
		Monto acordado: <strong><?php echo $this->Number->currency($ticket['Ticket']['monto_acordado'])?></strong>, Monto final: <strong><?php echo $this->Number->currency($ticket['Ticket']['monto_final'])?></strong>, Duraci&oacute;n del contrato: <strong><?php echo ( array_key_exists('Contrato', $contrato) )? $contrato['Contrato']['duracion'] : '&mdash;' ;?></strong>
		</p>
		<p>
		<i class="fa <?php echo ($promedio_cliente == 'Excelente' || $promedio_cliente == 'Muy Bueno' || $promedio_cliente == 'Bueno')? 'fa-thumbs-o-up' : 'fa-thumbs-down' ;?> "></i> Grado de satisfacci&oacute;n del Usuario Solicitante: <strong><?php echo $promedio_cliente?></strong>
		</p>
		<p>
		<i class="fa <?php echo (array_key_exists('CriteriosTicket', $apoyo_cliente) && ($apoyo_cliente['CriteriosTicket']['evaluacion'] == 'excelente' || $apoyo_cliente['CriteriosTicket']['evaluacion'] == 'muy bueno' || $apoyo_cliente['CriteriosTicket']['evaluacion'] == 'bueno'))? 'fa-thumbs-o-up' : 'fa-thumbs-down' ;?>"></i> Grado de satisfacci&oacute;n del Usuario Solicitante con el Ad. CTT: <strong><?php echo ( array_key_exists('CriteriosTicket', $apoyo_cliente) )? ucwords($apoyo_cliente['CriteriosTicket']['evaluacion']) : '&mdash;' ;?></strong>
		</p>
		<p>
		<i class="fa <?php echo ($promedio_oferente == 'Excelente' || $promedio_oferente == 'Muy Bueno' || $promedio_oferente == 'Bueno')? 'fa-thumbs-o-up' : 'fa-thumbs-down' ;?> "></i> Grado de satisfacci&oacute;n del Usuario Oferente: <strong><?php echo $promedio_oferente?></strong>
		</p>
		<p>
		<i class="fa <?php echo (array_key_exists('CriteriosTicket', $apoyo_oferente) && ($apoyo_oferente['CriteriosTicket']['evaluacion'] == 'excelente' || $apoyo_oferente['CriteriosTicket']['evaluacion'] == 'muy bueno' || $apoyo_oferente['CriteriosTicket']['evaluacion'] == 'bueno'))? 'fa-thumbs-o-up' : 'fa-thumbs-down' ;?>"></i> Grado de satisfacci&oacute;n del Usuario Oferente con el Ad. CTT: <strong><?php echo ( array_key_exists('CriteriosTicket', $apoyo_oferente) )? ucwords($apoyo_oferente['CriteriosTicket']['evaluacion']) : '&mdash;' ;?></strong>
		</p>
		<p>
		Observaciones del proceso vinculador por parte del Ad. CTT: <strong><?php echo $ticket['Ticket']['observaciones']?></strong>
		</p>
	</div>
</div>