<?php $this->Html->addCrumb('Administraci&oacute;n','/admin',array('escape'=>false))?>
<?php $this->Html->addCrumb('Usuarios','/admin/usuarios/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Perfil',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if( array_key_exists('Persona', $this->request->data) ){?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#perfil" role="tab" data-toggle="tab"><span class="badge">1</span> Perfil</a></li>
                <li><a href="/admin/usuarios/credenciales/<?php echo $this->request->data['Usuario']['id']?>"><span class="badge">2</span> Credenciales</a></li>
                <li><a href="/admin/usuarios/acceso/<?php echo $this->request->data['Usuario']['id']?>"><span class="badge">3</span> Acceso</a></li>
            </ul>
        <?php }else{?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#perfil" role="tab" data-toggle="tab"><span class="badge">1</span> Perfil</a></li>
                <li class="disabled"><a href="#"><span class="badge">2</span> Credenciales</a></li>
                <li class="disabled"><a href="#"><span class="badge">3</span> Acceso</a></li>
            </ul>
        <?php }?>    
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="perfil">
                <div class="col-md-12">
                    <?php echo $this->Form->create('Persona')?>
                    <?php if( array_key_exists('Persona', $this->request->data) )echo $this->Form->hidden('id')?>
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <div class="form-group">
                        <label>Primer nombre <span class="required">*</span></label>
                        <?php echo $this->Form->input('primer_nombre',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                    </div>
                    <div class="form-group">
                        <label>Segundo nombre</label>
                        <?php echo $this->Form->input('segundo_nombre',array('label'=>false,'class'=>'form-control'))?>
                    </div>
                    <div class="form-group">
                        <label>Tercer nombre</label>
                        <?php echo $this->Form->input('tercer_nombre',array('label'=>false,'class'=>'form-control'))?>
                    </div>
                    <div class="form-group">
                        <label>Primer apellido <span class="required">*</span></label>
                        <?php echo $this->Form->input('primer_apellido',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                    </div>
                    <div class="form-group">
                        <label>Segundo apellido <span class="required">*</span></label>
                        <?php echo $this->Form->input('segundo_apellido',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                    </div>
                    <div class="form-group">
                        <label>Tel&eacute;fono de oficina <span class="required">*</span></label>
                        <?php echo $this->Form->input('telefono_oficina',array('label'=>false,'class'=>'form-control','data-validetta'=>'required','placeholder'=>'2228-0099','data-inputmask'=>'telefono'))?>
                    </div>
                    <div class="form-group">
                        <label>Tel&eacute;fono celular</label>
                        <?php echo $this->Form->input('telefono_celular',array('label'=>false,'class'=>'form-control','placeholder'=>'2228-0099','data-inputmask'=>'telefono'))?>
                    </div>
                    <div class="form-group">
                        <label>Tel&eacute;fono de casa</label>
                        <?php echo $this->Form->input('telefono_casa',array('label'=>false,'class'=>'form-control','placeholder'=>'2228-0099','data-inputmask'=>'telefono'))?>
                    </div>
                    <div class="form-group">
                        <label>Correo electr&oacute;nico <span class="required">*</span></label>
                        <?php echo $this->Form->input('correo_electronico',array('label'=>false,'class'=>'form-control','data-validetta'=>'required,email','placeholder'=>'usuario@ejemplo.com'))?>
                    </div>
                    <div class="form-group">
                        <label>Correo electr&oacute;nico personal</label>
                        <?php echo $this->Form->input('correo_electronico_secundario',array('label'=>false,'class'=>'form-control','data-validetta'=>'email','placeholder'=>'usuario@ejemplo.com'))?>
                    </div>
                    <hr />
                </div>
                <div class="col-md-12">
                    <?php echo $this->Html->link('Cancelar','/admin/usuarios',array('class'=>'btn btn-default'))?>
                    <input type="button" id="btn_enviar" value="Continuar &rarr;" class="btn btn-primary" />
                </div>
            </div>
            <!-- fin del panel de perfil -->
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<script type="text/javascript">
	var persona_id = $('#PersonaId').val() || 0;
	var formulario = document.getElementById('PersonaAdminPerfilForm');
	$(document).ready(function(){
		$('#btn_enviar').click(function(){
			if( $('#PersonaCorreoElectronico').val().length > 0 ){
				$.ajax({
					"url":"/utilidades/verificar_correo/"+$('#PersonaCorreoElectronico').val()+"/"+persona_id+".json",
					"dataType":"JSON",
					"success": function(data){
						if(data.n == '0'){
							//alert('nitido!');
							$('form').submit();	
						}else{
							$('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> El correo electrónico que desea guardar ya existe en los registros del sistema, por favor digite uno diferente.</div>');
			                var body = $("html, body");
			                body.animate({scrollTop:0}, '500', 'swing', function() {
			                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
			                        $(this).remove(); 
			                    });
			                });
			                return false;
						}
					}
				});
			}
		});
	});
</script>