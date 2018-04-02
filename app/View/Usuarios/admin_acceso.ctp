<?php $this->Html->addCrumb('Administraci&oacute;n','/admin',array('escape'=>false))?>
<?php $this->Html->addCrumb('Usuarios','/admin/usuarios/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Credenciales',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/admin/usuarios/perfil/<?php echo $this->request->data['Persona']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li><a href="/admin/usuarios/credenciales/<?php echo $this->request->data['Usuario']['id']?>"><span class="badge">2</span> Credenciales</a></li>
            <li class="active"><a href="acceso" role="tab" data-toggle="tab"><span class="badge">3</span> Acceso</a></li>
        </ul>
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="acceso">
                <div class="col-md-12">
                    <?php echo $this->Form->create('Usuario')?>
                    <?php echo $this->Form->hidden('id')?>
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <p><span class="label label-warning">Importante:</span></p>
                    <label>Si desea que el usuario tenga acceso a todos los m&oacute;dulos del sistema seleccione la opci&oacute;n de administrador. <span class="required">*</span></label>
                    
                    <div class="form-group">
                        <div class="radio">
                              <label>
                                <input type="radio" name="data[Usuario][isadmin]" id="siadmin" value="1" data-validetta="required"
                                <?php if( $this->request->data['Usuario']['isadmin'] == 1 )echo 'checked="checked"';?> >
                                El usuario es administrador.
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="data[Usuario][isadmin]" id="noadmin" value="0" data-validetta="required"
                                <?php if( $this->request->data['Usuario']['isadmin'] == 0 )echo 'checked="checked"';?> >
                                El usuario tiene acceso a los siguientes m&oacute;dulos y opcionalmente a la siguiente empresa:<p class="help-block">(El m&oacute;dulo de B&uacute;squedas es accesible a todos los usuarios por defecto)</p>
                              </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="data[Usuario][modulo_administracion]" value="1"
                            <?php if( $this->request->data['Usuario']['modulo_administracion'] == 1 )echo 'checked="checked"';?> >
                            Administraci&oacute;n (Usuarios, Actividades econ&oacute;micas, Contribuyentes).
                          </label>
                        </div>
                        <div class="checkbox disabled">
                          <label>
                            <input type="checkbox" id="modulo_busqueda" name="data[Usuario][modulo_busqueda]" value="1" disabled="disabled" checked="">
                            B&uacute;squedas.
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="data[Usuario][modulo_empresa]"
                            <?php if( $this->request->data['Usuario']['modulo_empresa'] == 1 )echo 'checked="checked"';?> >
                            Registro de empresas y servicios tecnol&oacute;gicos.
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="data[Usuario][modulo_reporte]"
                            <?php if( $this->request->data['Usuario']['modulo_reporte'] == 1 )echo 'checked="checked"';?> >
                            Reportes.
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="data[Usuario][modulo_ticket]"
                            <?php if( $this->request->data['Usuario']['modulo_ticket'] == 1 )echo 'checked="checked"';?> >
                            Tickets.
                          </label>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label>Si el usuario no es administrador seleccione la empresa a la que tendr&aacute; acceso</label>
                        <?php echo $this->Form->input('empresa_id',array('options'=>$empresas,'empty'=>'Seleccione una empresa','class'=>'form-control','label'=>false))?>
                    </div>
                    <hr />
                </div>
                <div class="col-md-12">
                    <?php echo $this->Html->link('Cancelar','/admin/usuarios',array('class'=>'btn btn-default'))?>
                    <input type="button" id="btn_submit" value="Terminar" class="btn btn-primary" />
                    <input type="submit" style="display:none;">
                </div>
            </div>
            <!-- fin del panel de perfil -->
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<script type="text/javascript">
    $(document).ready(function(){
        //$('input[type="checkbox"]').prop('disabled','disabled');
        $('#noadmin').click(function(){
            $('input[type="checkbox"]').removeAttr('checked');
            $('input[type="checkbox"]').removeAttr('disabled');
            $('#modulo_busqueda').prop('disabled','disabled');
            $('#modulo_busqueda').prop('checked','checked');
        });   
        $('#siadmin').click(function(){
            $('input[type="checkbox"]').prop('checked','checked');
            /*$('input[type="checkbox"]').prop('disabled','disabled');*/
        }); 
        $('input[type="checkbox"]').click(function(){
            if( $(this).is(':checked') == false ){
                $('#noadmin').prop('checked','checked');
            }else{
                var allchecked = $('input[type="checkbox"]:checked');
                if( allchecked.length == 5 )
                    $('#siadmin').prop('checked','checked');    
            }
        });
        $('#btn_submit').click(function(){
            if( document.getElementById('siadmin').checked == false && document.getElementById('noadmin').checked == false ){
                alert('Por favor indique si el usuario es administrador ó seleccione los módulos a los que el usuario tendrá acceso.');
                return false;
            }else{
                $('input[type="checkbox"]').removeAttr('disabled');
                $('form').submit();
            }
        });
    });
</script>
