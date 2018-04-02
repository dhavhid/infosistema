<?php $this->Html->addCrumb('Tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb($ticket['Ticket']['ficha_proyecto'],'/tickets/ver/'.$ticket['Ticket']['id'],array('escape'=>false))?>
<?php $this->Html->addCrumb('Contrato de vinculaci&oacute;n empresarial',false,array('escape'=>false))?>
<div class="row"><div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div></div>
<div class="row">
	<div class="col-md-12">
		Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
        <br /><br />
		<?php echo $this->Form->create('Contrato')?>
		<?php if( array_key_exists('Contrato', $this->request->data) )echo $this->Form->hidden('id')?>
		<?php echo $this->Form->hidden('ticket_id',array('value'=>$ticket['Ticket']['id']))?>
		<?php echo $this->Form->textarea('descripcion_servicio',array('id'=>'txt_ds','style'=>'display:none;','data-validetta'=>'required'))?>
		<?php echo $this->Form->textarea('criterios_aceptacion',array('id'=>'txt_ca','style'=>'display:none;','data-validetta'=>'required'))?>
		<div class="form-group">
			<label>Duraci&oacute;n del contrato <span class="required">*</span></label>
			<?php echo $this->Form->input('duracion',array('class'=>'form-control','data-validetta'=>'required','label'=>false,'div'=>false))?>
			<p class="help-block">Digite la duraci&oacute;n en meses &oacute; a&ntilde;os. Por ejemplo: 3 meses &oacute; 1 a&ntilde;o</p>
		</div>
		<div class="form-group">
			<label>Fecha de inicio <span class="required">*</span></label>
			<?php $fec_i = ( array_key_exists('Contrato', $this->request->data) )? date('dmY',strtotime($this->request->data['Contrato']['fecha_inicio'])) : '' ;?>
			<?php echo $this->Form->input('fecha_inicio',array('type'=>'text','class'=>'form-control','data-validetta'=>'required','label'=>false,'div'=>false,'value'=>$fec_i))?>
			<p class="help-block">Digite la fecha con el formato n&uacute;merico: d&iacute;a/mes/a&ntilde;o. Por ejemplo: 30/08/2014</p>
		</div>
		<div class="form-group">
			<label>Monto acordado en USD <span class="required">*</span></label>
			<?php echo $this->Form->input('Ticket.monto_acordado',array('class'=>'form-control','data-validetta'=>'required,number','label'=>false,'div'=>false,'value'=>$ticket['Ticket']['monto_acordado']))?>
		</div>
		<div class="form-group">
			<label>Indique el porcentaje del monto a pagar que cancelar&aacute; antes de la iniciaci&oacute;n de la prestaci&oacute;n del servicio <span class="required">*</span></label>
			<?php echo $this->Form->input('primer_pago',array('class'=>'form-control','data-validetta'=>'required,number','label'=>false,'div'=>false))?>
			<p class="help-block">Indique el porcentaje en n&uacute;meros entre 1 y 99 </p>
		</div>
		<div class="form-group">
			<label>Indique c&uacute;antos d&iacute;as antes de la iniciaci&oacute;n de la prestaci&oacute;n del servicio cancelar&aacute; el porcentaje inicial del monto a pagar <span class="required">*</span></label>
			<?php echo $this->Form->input('primer_pago_fecha',array('class'=>'form-control','data-validetta,number'=>'required','label'=>false,'div'=>false))?>
			<p class="help-block">Indique la cantidad de d&iacute;as</p>
		</div>
		<div class="form-group">
			<label>El servicio tecnol&oacute;gico comprende: <span class="required">*</span></label>
			<div class="servicio_tecnologico"><?php echo ( array_key_exists('Contrato', $this->request->data) && strlen($this->request->data['Contrato']['descripcion_servicio']) > 0 )? $this->request->data['Contrato']['descripcion_servicio'] : $oferente['ServicioTecnologico']['descripcion_servicio'];?></div>
		</div>
		<div class="form-group">
			<label>Dicho servicio tecnol&oacute;gico descrito anteriormente est&aacute; basado y aprobado por ambas partes por los siguientes Criterios de Aceptaci&oacute;n: <span class="required">*</span></label>	
			<div class="criterios_aceptacion"><?php echo ( array_key_exists('Contrato', $this->request->data) && strlen($this->request->data['Contrato']['criterios_aceptacion']) > 0 )? $this->request->data['Contrato']['criterios_aceptacion'] : '';?></div>
		</div>
		<div class="form-group">
			<label>Representante del Infosistema <span class="required">*</span></label>
			<?php echo $this->Form->select('representante_infosistema',$persona_administrador,array('label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
		</div>
		<div class="form-group">
			<label>Solicitante del servicio tecnol&oacute;gico <span class="required">*</span></label>
			<?php echo $this->Form->select('representante_cliente',$contactos_cliente,array('label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
		</div>
		<div class="form-group">
			<label>Ofertante del servicio tecnol&oacute;gico <span class="required">*</span></label>
			<?php echo $this->Form->select('representante_oferente',$contactos_oferente,array('label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
		</div>
	</div>
	<div class="col-md-12">
		<?php echo $this->Html->link('Cancelar',array('controller'=>'tickets','action'=>'ver',$ticket['Ticket']['id']),array('escape'=>false,'class'=>'btn btn-default'))?>
		<input type="button" id="btn_enviar" value="Guardar" class="btn btn-primary">
	</div>
	<?php echo $this->Form->end()?>
</div>
<script type="text/javascript">
	var editor_st = null;
	var editor_ca = null;
    $(document).ready(function(){
        editor_st = setEditor('.servicio_tecnologico',{
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        });
        editor_ca = setEditor('.criterios_aceptacion',{
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        });
        $("#ContratoFechaInicio").mask("99/99/9999");
        $('#btn_enviar').click(function(){
        	var formulario = document.getElementById('ContratoContratoForm');
	        if( editor_st.code() != '<p><br></p>' ){
                $('#txt_ds').html( editor_st.code() ); 
            }
            if( editor_ca.code() != '<p><br></p>' ){
                $('#txt_ca').html( editor_ca.code() ); 
            }
            if( $('#txt_ds').val().length < 5 || $('#txt_ca').val().length < 5 ){
                $('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
                var body = $("html, body");
                body.animate({scrollTop:0}, '500', 'swing', function() {
                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                });
                return false;
            }
            //revisar fecha de contrato
            if(!isDate($('#ContratoFechaInicio').val())){
	            alert('La fecha de inicio de contrato debe ser mayor que el día de hoy.');
	            $('#ContratoFechaInicio').val('');
	            $('#ContratoFechaInicio').focus();
	            return false;
            }
            formulario.submit(); 
        });
	});        
</script>