<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Formas de pago',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/empresas/registroempresas/perfil/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li><a href="/empresas/registroempresas/areas/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
            <li><a href="/empresas/registroempresas/laboratorios/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">3</span> Laboratorios</a></li>
            <li><a href="/empresas/registroempresas/recursos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
            <li><a href="/empresas/registroempresas/infraestructuras/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">5</span> Infraestructura</a></li>
            <li><a href="/empresas/registroempresas/solicitantes/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">6</span> Empresas solicitantes</a></li>
            <li><a href="/empresas/registroempresas/contactos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">7</span> Medios de contacto</a></li>
            <li class="active"><a href="#pagos" role="tab" data-toggle="tab"><span class="badge">8</span> Medios de pago</a></li>
        </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="pagos">
                <?php echo $this->Form->create('FormasPago')?>
                <?php echo ( array_key_exists('FormasPago', $this->request->data) == TRUE )? $this->Form->hidden('id') : '' ;?>
                <?php echo $this->Form->hidden('empresa_id',array('value'=>$this->request->data['Empresa']['id']))?>
                <div class="col-md-12">
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <label>Medios de pago aceptados por la instituci&oacute;n: <span class="required">*</span></label>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[FormasPago][enefectivo]" id="medio"
                        <?php if( array_key_exists('FormasPago', $this->request->data) )echo ($this->request->data['FormasPago']['enefectivo'] == 1)? 'checked' : '' ;?>
                        > En Efectivo
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[FormasPago][tarjetacredito]" id="medio"
                        <?php if( array_key_exists('FormasPago', $this->request->data) )echo ($this->request->data['FormasPago']['tarjetacredito'] == 1)? 'checked' : '' ;?>
                        > Tarjeta de Cr&eacute;dito
                       </label>
                    </div>  
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[FormasPago][depositocuenta]" id="medio"
                        <?php if( array_key_exists('FormasPago', $this->request->data) )echo ($this->request->data['FormasPago']['depositocuenta'] == 1)? 'checked' : '' ;?>
                        > Dep&oacute;sito a Cuenta
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[FormasPago][cheque]" id="medio"
                        <?php if( array_key_exists('FormasPago', $this->request->data) )echo ($this->request->data['FormasPago']['cheque'] == 1)? 'checked' : '' ;?>
                        > Cheque
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[FormasPago][transferencia]" id="medio"
                        <?php if( array_key_exists('FormasPago', $this->request->data) )echo ($this->request->data['FormasPago']['transferencia'] == 1)? 'checked' : '' ;?>
                        > Transferencia
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[FormasPago][paypal]" id="medio"
                        <?php if( array_key_exists('FormasPago', $this->request->data) )echo ($this->request->data['FormasPago']['paypal'] == 1)? 'checked' : '' ;?>
                        > PayPal
                       </label>
                    </div>
                    <div class="form-group">
                        <label>Otras medios</label>
                        <?php echo $this->Form->input('otrosmedios',array('label'=>false,'div'=>false,'class'=>'form-control'))?>
                        <p class="help-block">Escriba los medios de pago separados por coma. Ej. Pagar&eacute;, Pago a plazos</p>
                    </div>
                </div>
            </div>
            <!-- fin del panel de perfil -->
            <hr />
            <div class="col-md-12">
                <?php echo $this->Html->link('Cancelar','/empresas/registroempresas',array('class'=>'btn btn-default'))?>
                <input type="button" id="btn_enviar" value="Terminar" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<style>
    .checkbox{margin-bottom:30px !important;}
</style>
<script type="text/javascript">
	var formulario = document.getElementById('FormasPagoEmpresasPagosForm');
	$(document).ready(function(){
		$('#btn_enviar').click(function(){
			if( $(':checkbox:checked').length == 0 ){
				$('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
                var body = $("html, body");
                body.animate({scrollTop:0}, '500', 'swing', function() {
                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                });
				return false;
			}
			formulario.submit();
		});	
		validetta_obj = null;
	});
</script>