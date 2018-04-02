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
	<div class="col-md-offset-2 col-md-8"><center><h3>Contrato de Vinculaci&oacute;n Empresarial</h3></center></div>
</div>
<br /><br />
<div class="row contrato">
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">REUNIDOS</div>
	<div class="col-md-offset-2 col-md-8">
		<p>
		De una parte, la empresa <?php echo $ticket['Cliente']['nombre_empresa']?>, de giro <?php echo $ticket['Cliente']['giro']?>, 
		NIT <?php echo $ticket['Cliente']['nit']?>, N&deg; de registro <?php echo $ticket['Cliente']['numero_registro']?>, con domicilio 
		<?php echo $ticket['Cliente']['direccion_final'] . ', ' . $ticket['Municipio']['nombre_municipio'] . ', ' . $ticket['Departamento']['nombre_departamento'] ?> 
		y n&uacute;mero telef&oacute;nico de oficina de <?php echo $ticket['Cliente']['telefono']?>, empresa que solicita la contrataci&oacute;n de servicio/s tecnol&oacute;gico/s.
		</p>
		<p>
		Y de la parte, la empresa <?php echo $oferente['Oferente']['nombre_empresa']?>, de giro <?php echo $oferente['Oferente']['giro']?>,
		NIT <?php echo $oferente['Oferente']['nit']?>, N&deg; de registro <?php echo $oferente['Oferente']['numero_registro']?>, con domicilio
		<?php echo $oferente['Oferente']['direccion_final'] . ', ' . $oferente['Municipio']['nombre_municipio'] . ', ' . $oferente['Departamento']['nombre_departamento'] ?>
		y n&uacute;mero telef&oacute;nico de oficina de <?php echo $oferente['Oferente']['telefono']?>, empresa que ofrece la prestaci&oacute;n de servicio tecnol&oacute;gico.
		</p>
		<p>
		Presente, adem&aacute;s <?php echo $contrato['Contrato']['representante_infosistema'] ?> representante del
		MINEC, como figura vinculadora entre las partes y garante del acuerdo alcanzado entre los mismos.
		</p>
	</div><!-- fin del parrafo -->
	<div class="col-md-offset-2 col-md-8 contrato_subtitulo">MANIFIESTAN</div>
	<div class="col-md-offset-2 col-md-8">
		<p><span>Primero.</span></p>
		<p>
		Que la empresa <?php echo $ticket['Cliente']['nombre_empresa']?> solicitante del servicio tecnol&oacute;gico &#8220;<?php echo $oferente['ServicioTecnologico']['nombre_servicio']?>&#8221; contrata a la empresa 
		<?php echo $oferente['Oferente']['nombre_empresa']?> quien brinda el servicio tecnol&oacute;gico mencionado.
		</p>
	</div><!-- fin del primer paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Segundo.</span></p>
		<p>
		El servicio tecnol&oacute;gico comprende:
		</p>
		<?php echo $contrato['Contrato']['descripcion_servicio']?>
		<p>
		Dicho servicio tecnol&oacute;gico descrito anteriormente est&aacute; basado y aprobado por ambas partes por los siguientes Criterios de Aceptaci&oacute;n:
		</p>
		<?php echo $contrato['Contrato']['criterios_aceptacion']?>
		<p>
		Y este tendr&aacute; una duraci&oacute;n de <?php echo $contrato['Contrato']['duracion']?> a partir del d&iacute;a <?php echo date('d/m/Y',strtotime($contrato['Contrato']['fecha_inicio']))?>. Seg&uacute;n 
		lo que manifiesta la empresa <?php echo $oferente['Oferente']['nombre_empresa']?> que ofrece el servicio tecnol&oacute;gico.
		</p>
	</div><!-- fin del segundo paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Tercero.</span></p>
		<p>
		El precio convenido por el presente para la adquisici&oacute;n del servicio tecnol&oacute;gico es el de <?php echo $this->Number->currency($ticket['Ticket']['monto_acordado'])?> d&oacute;lares, 
		que la parte que contrata el servicio tecnol&oacute;gico satisfar&aacute; del siguiente modo:
		<p>
		<ol>
			<li>
			Se pagar&aacute; el <?php echo $contrato['Contrato']['primer_pago']?>% del monto total pactado, <?php echo $contrato['Contrato']['primer_pago_fecha']?> d&iacute;as antes de la fecha de 
			iniciaci&oacute;n del servicio antes acordada, cuyo valor asciende a <?php echo $this->Number->currency($contrato['Contrato']['primer_pago']*$ticket['Ticket']['monto_acordado']*0.01)?> d&oacute;lares.
			</li>
			<li>
			El <?php echo (100-$contrato['Contrato']['primer_pago'])?>% restante	cuyo valor asciende a <?php echo $this->Number->currency($ticket['Ticket']['monto_acordado']-($contrato['Contrato']['primer_pago']*$ticket['Ticket']['monto_acordado']*0.01))?> d&oacute;lares ser&aacute; cancelado a la culminaci&oacute;n del servicio tecnol&oacute;gico prestado.
			</li>
		</ol>
	</div><!-- fin del tercer paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Cuarto.</span></p>
		<p>
		Sin perjuicio de otras obligaciones expresamente estipuladas y/o derivadas del presente contrato, las partes tienen las siguientes obligaciones principales:
		</p>
		<ul>
			<li>
			A LA EMPRESA OFERTANTE DEL SERVICIO TECNOL&Oacute;GICO:
				<ol>
					<li>
					Se compromete a prestar el servicio en forma diligente, para lo cual podr&aacute; valerse de personal calificado, asumiendo respecto de &eacute;stos, las responsabilidades laborales y tributarias que de dicha relaci&oacute;n se deriven.
					</li>
				</ol>
			</li>
			<li>
			A LA EMPRESA SOLICITANTE DEL SERVICIO TECNOL&Oacute;GICO:
				<ol>
					<li>
					Se compromete a cancelar el precio acordado por las partes en los montos y plazos estipulados en el presente contrato.
					</li>
				</ol>
			</li>
		</ul>
	</div><!-- fin del cuarto paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Quinto.</span></p>
		<p>
		Queda establecido que si por cualquier motivo, LA EMPRESA SOLICITANTE decidiera resolver el presente contrato, el importe equivalente al <?php echo $contrato['Contrato']['primer_pago']?>% de la prestaci&oacute;n que hubiera abonado a LA EMPRESA OFERTANTE, no ser&aacute; devuelto por &eacute;sta.
		</p>
		<br />
		<p>
		Lo dispuesto en esta cl&aacute;usula no libera a LA EMPRESA SOLICITANTE del abono de la parte equivalente a la prestaci&oacute;n del servicio efectivo que hubiera realizado LA EMPRESA OFERTANTE DEL SERVICIO TECNOL&Oacute;GICO, al momento de la resoluci&oacute;n del contrato. Para el efecto, ambas partes, de com&uacute;n acuerdo, 
		determinar&aacute;n el justiprecio por los servicios realizados en funci&oacute;n de su avance.
		</p>
		<br />
		<p>
		Sin embargo, LA EMPRESA SOLICITANTE podr&aacute; apelar por indemnizaci&oacute;n de monto correspondiente al <?php echo $contrato['Contrato']['primer_pago']?>% ya pagado, adem&aacute;s de da&ntilde;os y perjuicios seg&uacute;n lo estipula el punto sexto.
		</p>
	</div><!-- fin del quinto paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Sexto.</span></p>
		<p>El presente contrato quedar&aacute; resuelto por la siguiente causa:</p>
		<ol>
			<li>
			Por incumplimiento de alguno o algunos de los t&eacute;rminos y condiciones establecidos en el presente contrato, quedando a salvo el derecho de la parte afectada para demandar indemnizaciones por da&ntilde;os y perjuicios. 
			</li>
		</ol>
	</div><!-- fin del sexto paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>S&eacute;ptimo.</span></p>
		<p>LA EMPRESA SOLICITANTE DEL SERVICIO TECNOL&Oacute;GICO:</p>
		<ol class="letras">
			<li>
			No podr&aacute; transferir parcial o totalmente las obligaciones que asume en este contrato, y tendr&aacute; responsabilidad directa y exclusiva por el cumplimiento del mismo.
			</li>
		</ol>	
	</div><!-- fin del septimo paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Octavo.</span></p>
		<p>LA EMPRESA OFERTANTE DEL SERVICIO TECNOL&Oacute;GICO:</p>
		<ol class="letras">
			<li>
			Se obliga a mantener en estricto secreto la informaci&oacute;n que pudiera recibir de LA EMPRESA SOLICITANTE DEL SERVICIO TECNOL&Oacute;GICO con motivo del presente contrato, a no revelarla en todo o en parte a terceros, sean estas personas naturales o jur&iacute;dicas y, a no utilizarla y cuidar que otros no la utilicen en forma alguna, bajo pena se asumir todos los da&ntilde;os y perjuicio ocasionados.
			</li>
			<li>
			La informaci&oacute;n transferida con la que se llego al acuerdo que se firma en este documento deber&aacute; mantenerse dicha informaci&oacute;n confidencial y no deber&aacute; revelar, ni total, ni parcialmente a persona alguna, salvo a aquellas personas que se vieron involucradas para fijar el precio, tiempo y todo lo que se detalla en la descripci&oacute;n antes mencionada del servicio tecnol&oacute;gico, anexando una copia del registro de las conversaciones (mensajes por medio del infosistema) donde se detalla dicha informaci&oacute;n a este documento.
			</li>
			<li>
			Se acepta que ser&aacute; responsable en caso de que la empresa solicitante sufra cualesquiera da&ntilde;os y perjuicios como consecuencia del incumplimiento por parte de la empresa oferente del servicio tecnol&oacute;gico en cualquiera de sus obligaciones emanadas del presente Contrato. Por tanto se exime de cualquier responsabilidad legal al Ministerio de Econom&iacute;a, de cualquier problema surgido por el uso de informaci&oacute;n  no autorizada. Dejando a la consideraci&oacute;n de LA EMPRESA OFERTANTE DEL SERVICIO TECNOL&Oacute;GICO el denunciar al Representante del Infosistema en la Superintendencia de &eacute;tica Gubernamental.
			</li>
			<li>
			LA EMPRESA OFERTANTE DEL SERVICIO TECNOL&Oacute;GICO devolver&aacute; a LA EMPRESA SOLICITANTE DEL SERVICIO TECNOL&Oacute;GICO toda la documentaci&oacute;n que tenga en su poder al vencimiento del plazo del contrato o de la resoluci&oacute;n del mismo.
			</li>
		</ol>
	</div><!-- fin de octavo paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>Noveno.</span></p>
		<p>
		La selecci&oacute;n de la empresa/instituci&oacute;n <?php echo $oferente['Oferente']['nombre_empresa']?> ofertante del servicio tecnol&oacute;gico NO corresponde a intereses particulares del Representante del Infosistema, la elecci&oacute;n de esta corresponden a los intereses mostrados por LA EMPRESA SOLICITANTE DEL SERVICIO TECNOL&Oacute;GICO, de donde el Representante del Infosistema solo mostro un listado con las condiciones que impuso para la escogitaci&oacute;n de las empresas oferentes a LA EMPRESA SOLICITANTE, de donde &eacute;sta selecciono a LA EMPRESA OFERTANTE DEL SERVICIO TECNOL&Oacute;GICO de la cual surgieron los acuerdos que se firman en este documento. 	
		</p>
	</div><!-- fin de noveno paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p><span>D&eacute;cimo.</span></p>
		<p>
		Para el supuesto de conflictos, ser&aacute; resuelto mediante arbitraje actuando como testigo de lo pactado por ambas partes el Representante del Infosistema que estuvo presenta en la firma de este documento, y siendo su &uacute;nica obligaci&oacute;n el comparecer como testigo de lo acordado por ambas partes, quedando desligado de cualquier responsabilidad que alguna de las partes desee imputarle.
		</p>
		<p>
		Las sugerencias que pudo verter el Representante del Infosistema en las comunicaciones que se llevaron a cabo las partes involucradas NO podr&aacute;n ser usadas como objeto de demanda al Ministerio de Econom&iacute;a y solo podr&aacute;n ser usadas para denunciar al Representante del infosistema en la Superintendencia de &eacute;tica Gubernamental, dado que en los acuerdos alcanzados dichas sugerencias debieron ser discutidas aceptadas o rechazadas, tomados o no en consideraci&oacute;n en las negociaciones y posterior acuerdo que se refleja en este documento, POR TANTO exime de cualquier responsabilidad legal al Ministerio de Econom&iacute;a y a sus empleados (a los &uacute;ltimos solo se podr&aacute; interponer la denuncia a la instancia se&ntilde;alada.)
		</p>
	</div><!-- fin del decimo paso -->
	
	<div class="col-md-offset-2 col-md-8">
		<p>
		<br />
		San Salvador a los <?php echo date('d')?> d&iacute;as del mes de <?php echo $meses[(date('n')-1)]?> de <?php echo date('Y')?>	
		<br /><br /><br /><br /><br /><br /><br />
		</p>
	</div><!-- fin de fecha -->
	
	<div class="col-md-offset-2 col-md-3">
		<?php echo $contrato['Contrato']['representante_cliente']?><br />
		<?php echo $ticket['Cliente']['nombre_empresa']?><br />
		Solicitante del Servicio Tecnol&oacute;gico.
		<p><br /><br /><br /></p>
	</div>
	<div class="col-md-3">
		<?php echo $contrato['Contrato']['representante_oferente']?><br />
		<?php echo $oferente['Oferente']['nombre_empresa']?><br />
		Ofertante del Servicio Tecnol&oacute;gico.
		<p><br /><br /><br /></p>
	</div>
	<div class="col-md-2">
		<?php echo $contrato['Contrato']['representante_infosistema']?><br />
		Representante del Infosistema.
		<p><br /><br /><br /></p>
	</div><!-- fin de firmas -->
	
</div>