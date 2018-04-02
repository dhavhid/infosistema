<?php $this->Html->addCrumb('Tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb($ticket['Ticket']['ficha_proyecto'],'/tickets/ver/'.$ticket['Ticket']['id'],array('escape'=>false))?>
<?php $this->Html->addCrumb('Criterios de satisfacci&oacute;n',false,array('escape'=>false))?>
<div class="row"><div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div></div>
<div class="row">
	<?php echo $this->Form->create('CriteriosTicket')?>
	<div class="col-md-12">
		<p>Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
		Por favor marque el n&uacute;mero de estrellas para evaluar cada criterio de satisfacci&oacute;n, tenga en cuenta lo siguiente:</p>
	</div>
</div>
<div class="row">
	<div class="col-md-3">	
		<br />
		<table cellpadding="10px" cellspacing="10px" style="border-spacing:5px;">
			<tr>
				<td align="right"><img src="/img/star-on.png"><img src="/img/star-on.png"><img src="/img/star-on.png"><img src="/img/star-on.png"><img src="/img/star-on.png"></td>
				<td> Excelente</td>
			</tr>
			<tr>
				<td align="right"><img src="/img/star-on.png"><img src="/img/star-on.png"><img src="/img/star-on.png"><img src="/img/star-on.png"></td>
				<td> Muy Bueno</td>
			</tr>
			<tr>
				<td align="right"><img src="/img/star-on.png"><img src="/img/star-on.png"><img src="/img/star-on.png"></td>
				<td> Bueno</td>
			</tr>
			<tr>
				<td align="right"><img src="/img/star-on.png"><img src="/img/star-on.png"></td>
				<td> Regular</td>
			</tr>
			<tr>
				<td align="right"><img src="/img/star-on.png"></td>
				<td> Deficiente</td>
			</tr>
		</table>
		<br />
	</div>
</div>
<br />
<div class="row">	
	<div class="col-md-12"> 
		<?php $i = 1;?>
		<?php foreach($criterios as $criterio):?>
		<div class="form-group">
			<label><i class="fa fa-caret-right"></i> <?php echo $criterio['CriteriosSatisfaccion']['nombre_criterio']?> <span class="required">*</span></label>
			<div class="raty raty_<?php echo $criterio['CriteriosSatisfaccion']['id']?>"></div>
			<input type="hidden" value="<?php echo $ticket_id?>" name="data[criterios][<?php echo $i?>][CriteriosTicket][ticket_id]">
			<input type="hidden" value="<?php echo $criterio['CriteriosSatisfaccion']['id']?>" name="data[criterios][<?php echo $i?>][CriteriosTicket][criterio_id]">
			<input type="hidden" value="<?php echo $persona['Usuario']['persona_id']?>" name="data[criterios][<?php echo $i?>][CriteriosTicket][persona_id]">
			<input type="hidden" name="data[criterios][<?php echo $i?>][CriteriosTicket][evaluacion]" class="evaluacion" id="evaluacion_<?php echo $criterio['CriteriosSatisfaccion']['id']?>">
			<script type="text/javascript">
				$(document).ready(function(){
					$(".raty_<?php echo $criterio['CriteriosSatisfaccion']['id']?>").raty({
						"path": "/img/",
						"click": function(score){
							var a = '';
							if( score == '1' )a = 'Deficiente';
							if( score == '2' )a = 'Regular';
							if( score == '3' )a = 'Bueno';
							if( score == '4' )a = 'Muy bueno';
							if( score == '5' )a = 'Excelente';
							$("#evaluacion_<?php echo $criterio['CriteriosSatisfaccion']['id']?>").val(a);
						}
					})
				});
			</script>
		</div>
		<?php $i++;?>
		<?php endforeach;?>
	</div>
	<div class="col-md-12">
		<?php echo $this->Html->link('Cancelar',array('controller'=>'tickets','action'=>'ver',$ticket_id),array('escape'=>false,'class'=>'btn btn-default'))?>
		<input type="button" id="btn_submit" value="Guardar" class="btn btn-primary">
	</div>
	<?php echo $this->Form->end()?>
</div>
<script type="text/javascript">
	var formulario = document.getElementById('CriteriosTicketCriteriosForm');
	$(document).ready(function(){
		$('#btn_submit').click(function(){
			$('.evaluacion').each(function(index,element){
				if( $(element).val() == '' ){
					$('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
	                var body = $("html, body");
	                body.animate({scrollTop:0}, '500', 'swing', function() {
	                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
	                        $(this).remove(); 
	                    });
	                });
	                return false;
				}
			});
			formulario.submit();
		});
	});
</script>