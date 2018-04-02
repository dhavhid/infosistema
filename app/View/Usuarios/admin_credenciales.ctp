<?php $this->Html->addCrumb('Administraci&oacute;n','/admin',array('escape'=>false))?>
<?php $this->Html->addCrumb('Usuarios','/admin/usuarios/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Credenciales',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/admin/usuarios/perfil/<?php echo $this->request->data['Usuario']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li class="active"><a href="#credenciales" role="tab" data-toggle="tab"><span class="badge">2</span> Credenciales</a></li>
            <li><a href="/admin/usuarios/acceso/<?php echo $this->request->data['Usuario']['id']?>"><span class="badge">3</span> Acceso</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="credenciales">
                <div class="col-md-12">
                    <?php echo $this->Form->create('Usuario')?>
                    <?php echo $this->Form->hidden('id')?>
                    <?php echo $this->Form->hidden('persona_id')?>
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <div class="form-group">
                        <label>Nombre de usuario <span class="required">*</span></label>
                        <?php echo $this->Form->input('usuario',array('label'=>false,'class'=>'form-control','data-validetta'=>'required','disabled'=>'disabled'))?>
                        <p class="help-block">El nombre de usuario es generado autom&aacute;ticamente por el sistema.</p>
                    </div>
                    <p>Recuerde que la contrase&ntilde;a debe contener por lo menos un n&uacute;mero y debe ser de por lo menos 5 caracteres de longitud.</p>
                    <div class="form-group">
                        <label>Contrase&ntilde;a <span class="required">*</span></label>
                        <?php echo $this->Form->input('contrasena',array('type'=>'password','label'=>false,'class'=>'form-control','data-validetta'=>'required','id'=>'contrasena'))?>
                    </div>
                    <div class="form-group">
                        <label>Repetir Contrase&ntilde;a <span class="required">*</span></label>
                        <input type="password" class="form-control" data-validetta='required' id="repetir_contrasena">
                    </div>
                    <hr />
                </div>
                <div class="col-md-12">
                    <?php echo $this->Html->link('Cancelar','/admin/usuarios',array('class'=>'btn btn-default'))?>
                    <input type="button" id="btn_submit" value="Continuar &rarr;" class="btn btn-primary" />
                    <input type="submit" style="display:none;">
                </div>
            </div>
            <!-- fin del panel de perfil -->
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<script type="text/javascript">
    var number = /[0-9]/;
    $(document).ready(function(){
        $('#btn_submit').click(function(){
            if( $('#contrasena').val() != $('#repetir_contrasena').val() ){
                alert('Las contraseñas no coinciden. Por favor digítelas nuevamente.');
                $('#contrasena').focus();
                return false;
            }
            if( ($('#contrasena').val().length > 5) && ($('#contrasena').val() == $('#repetir_contrasena').val()) ){
                if( !number.test($('#contrasena').val()) ){
                    alert('La contraseña debe contener por lo menos un número.');
                    return false;
                }
                $('#contrasena').val($.md5($('#contrasena').val()));
                $('#repetir_contrasena').val($.md5($('#repetir_contrasena').val()));
            }
            $('form').submit();
        });
    });
</script>
