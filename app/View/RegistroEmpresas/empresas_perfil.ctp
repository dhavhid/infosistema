<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Perfil',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if( array_key_exists('Empresa', $this->request->data) ){?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#perfil" role="tab" data-toggle="tab"><span class="badge">1</span> Perfil</a></li>
                <li><a href="/empresas/registroempresas/areas/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
                <li><a href="/empresas/registroempresas/laboratorios/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">3</span> Laboratorios</a></li>
                <li><a href="/empresas/registroempresas/recursos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
                <li><a href="/empresas/registroempresas/infraestructuras/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">5</span> Infraestructura</a></li>
                <li><a href="/empresas/registroempresas/solicitantes/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">6</span> Empresas solicitantes</a></li>
                <li><a href="/empresas/registroempresas/contactos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">7</span> Medios de contacto</a></li>
                <li><a href="/empresas/registroempresas/pagos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">8</span> Medios de pago</a></li>
            </ul>
        <?php }else{?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#perfil" role="tab" data-toggle="tab"><span class="badge">1</span> Perfil</a></li>
                <li class="disabled"><a href="#"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
                <li class="disabled"><a href="#"><span class="badge">3</span> Laboratorios</a></li>
                <li class="disabled"><a href="#"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
                <li class="disabled"><a href="#"><span class="badge">5</span> Infraestructura</a></li>
                <li class="disabled"><a href="#"><span class="badge">6</span> Empresas solicitantes</a></li>
                <li class="disabled"><a href="#"><span class="badge">7</span> Medios de contacto</a></li>
                <li class="disabled"><a href="#"><span class="badge">8</span> Medios de pago</a></li>
            </ul>
        <?php }?>    
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="perfil">
                <div class="col-md-12">
                    <?php echo $this->Form->create('Empresa',array('type'=>'file'))?>
                    <?php if( array_key_exists('Empresa', $this->request->data) )echo $this->Form->hidden('id')?>
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <div class="form-group">
                        <label>NIT <span class="required">*</span></label>
                        <div id="remote-nit">
                            <?php echo $this->Form->input('nit',array('label'=>false,'class'=>'form-control typeahead','data-validetta'=>'required'))?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre de la empresa <span class="required">*</span></label>
                        <?php echo $this->Form->input('nombre_empresa',array('label'=>false,'class'=>'form-control typeahead','data-validetta'=>'required'))?>
                    </div>
                    <div class="form-group">
                        <label>N&uacute;mero de registro <span class="required">*</span></label>
                        <?php echo $this->Form->input('numero_registro',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                    </div>
                    <div class="form-group">
                        <label>Actividad / Giro de la empresa <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-info" id="btn_seleccionar" data-toggle="modal" data-target=".bs-example-modal-sm" type="button"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;Seleccionar</button>
                            </span>
                            <input name="data[Empresa][giro]" id="giro" value="<?php echo (array_key_exists('Empresa', $this->request->data))? $this->request->data['Empresa']['giro'] : '' ; ?>" class="form-control" readonly />
                        </div>
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <label>Direcci&oacute;n <span class="required">*</span></label>
                            <?php echo $this->Form->select('departamentos',$departamentos,array('default'=>$departamento,'class'=>'form-control','id'=>'departamentos','empty'=>'-- Seleccione el departamento --'))?>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="data[Empresa][direccion_municipio]" id="municipios">
                                <option value="">-- Seleccione el municipio --</option>
                                <?php foreach($municipios as $key=>$value): if( $municipio == $key ){ $selected = 'selected'; }else{ $selected = ''; } echo "<option value='{$key}' {$selected}>{$value}</option>"; endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">    
                            <?php echo $this->Form->input('direccion_final',array('label'=>false,'class'=>'form-control','data-validetta'=>'required','placeholder'=>'Calle/Barrio/Colonia, No., etc.'))?>
                        </div>
                    </fieldset>    
                    <div class="form-group">
                        <label>Tel&eacute;fono <span class="required">*</span></label>
                        <?php echo $this->Form->input('telefono',array('label'=>false,'class'=>'form-control','data-validetta'=>'required','placeholder'=>'2228-0099','data-inputmask'=>'telefono'))?>
                    </div>
                    <div class="form-group">
                        <label>Fax</label>
                        <?php echo $this->Form->input('fax',array('label'=>false,'class'=>'form-control','placeholder'=>'2228-0099','data-inputmask'=>'telefono'))?>
                    </div>
                    <div class="form-group">
                        <label>Correo electr&oacute;nico <span class="required">*</span></label>
                        <?php echo $this->Form->input('correo_electronico',array('label'=>false,'class'=>'form-control','data-validetta'=>'required,email','placeholder'=>'usuario@ejemplo.com'))?>
                    </div>
                    <div class="form-group">
                        <label>Direcci&oacute;n de sitio web</label>
                        <?php echo $this->Form->input('website',array('label'=>false,'class'=>'form-control','placeholder'=>'usuario@ejemplo.com'))?>
                    </div>
                    <div class="form-group">
                        <label>Ingrese la direcci&oacute;n de la cuenta de las redes sociales que utiliza</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-facebook-square"></i></span>
                            <input type="text" name="data[Empresa][facebook]" class="form-control" placeholder="https://www.facebook.com/usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                            <input type="text" name="data[Empresa][twitter]" class="form-control" placeholder="https://www.twitter.com/usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                            <input type="text" name="data[Empresa][google+]" class="form-control" placeholder="https://plus.google.com/9999999999">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-skype"></i></span>
                            <input type="text" name="data[Empresa][skype]" class="form-control" placeholder="Skype ID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Seleccione el archivo del logo de la empresa</label>
                        <br />
                        <?php if( array_key_exists('Empresa', $this->request->data) && strlen($this->request->data['Empresa']['logotipo']) > 0 ){?>
                            <img data-src="" class="img-thumbnail" align="Logo" src="<?php echo FULL_BASE_URL . DS . 'files' . DS . 'logos' . DS . $this->request->data['Empresa']['logotipo']?>" width="140">
                        <?php }else{?>    
                            <img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 140px; height: 140px;">
                        <?php }?>
                        <br />
                        <input style="display:none;" name="archivo" id="archivo" type="file" />
                        <br />
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button class="btn btn-info" id="btn_logo" type="button"><i class="fa fa-file-photo-o"></i>&nbsp;&nbsp;Seleccionar</button>
                          </span>
                          <input type="text" class="form-control" id="archivo_seleccionado" placeholder="archivo con extensi&oacute;n .png, .jpg &oacute; .gif">
                        </div>
                        <p class="help-block">Por favor seleccione un archivo <strong>.png, .jpg &oacute; .gif</strong> para el logo de la empresa</p>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label>Descripci&oacute;n de la empresa</label>
                            <?php echo $this->Form->input('comentario_adicional',array('label'=>false,'div'=>false,'class'=>'form-control'))?>
                            <span class="help-block">D&iacute;gite una descripci&oacute;n breve de la empresa.</span>
                        </div>
                    </div>
                    <hr />
                </div>
                <div class="col-md-12">
                    <?php echo $this->Html->link('Cancelar','/empresas/registroempresas',array('class'=>'btn btn-default'))?>
                    <input type="button" id="btn_submit" value="Continuar &rarr;" class="btn btn-primary" />
                </div>
            </div>
            <!-- fin del panel de perfil -->
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<!-- ___________________________________________________________________________________________________________ -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Actividades Econ&oacute;micas</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php echo $this->Form->select('actividad_principal',$actividades_principales,array('class'=>'form-control','id'=>'actividad_principal','empty'=>'-- Categor&iacute;a principal --','escape'=>false))?>
                </div>
                <div class="form-group">
                    <select id="subactividad" class="form-control">
                        <option value="">-- Subcategor&iacute;a --</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="actividad_seleccionada" class="form-control">
                        <option value="">-- Actividad econ&oacute;mica --</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" onclick="$('.modal').modal('hide');">Cancelar</button>
                    <button class="btn btn-primary" id="seleccionar_actividad"><i class="fa fa-check"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ___________________________________________________________________________________________________________ -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_submit').click(function(){
            $('input.tt-hint').removeAttr('data-validetta');
            var formulario = document.getElementById('EmpresaEmpresasPerfilForm');
            if( $('#archivo_seleccionado').val().length > 0 ){
                if( validar_file(formulario, [".png",".jpg",".jpeg",".gif",".PNG",".JPG",".JPEG",".GIF"]) == true && $('#archivo_seleccionado').val().length > 0 ){
                    formulario.submit();
                }else return false;
            }
            
            $('form').submit();
        });
        $('#departamentos').change(function(){
            getOptions( 'municipios', '#municipios', $(this).val(), '-- Seleccione el municipio --');
        });
        $('#actividad_principal').change(function(){
            $('#actividad_seleccionada').empty();
            $('#actividad_seleccionada').append("<option value=''>-- Actividad económica --</option>");
            getOptions('subactividad','#subactividad',$(this).val(),'-- Subcategoría --');
        });
        $('#subactividad').change(function(){
            getOptions('actividades','#actividad_seleccionada',$(this).val(),'-- Actividad económica --');
        });
        $('#seleccionar_actividad').click(function(){
            if( $('#actividad_seleccionada').val().length > 1 ){
                $('#giro').val($('#actividad_seleccionada').val());
                $('.modal').modal('hide');
            }
        });
        var Nits = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nit'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '/utilidades/contribuyentes/nit.json',
            remote: '/utilidades/contribuyentes/nit.json'
        });
         
        Nits.initialize();
        $('#EmpresaNit').typeahead(null, {
            name: 'nit_contribuyentes',
            displayKey: 'nit',
            source: Nits.ttAdapter()
        }).on('typeahead:selected',function(e,item,dataset){
            $('#EmpresaNombreEmpresa').val(item.nombre);
        });
        
        $('#btn_logo').click(function(){
            $('#archivo').click();
        });
        $('#archivo').change(function(){
            $('#archivo_seleccionado').val($('#archivo').val());    
        });
        $('#archivo_seleccionado').change(function(){
            $('#archivo').val($('#archivo_seleccionado').val());    
        });
    });
</script>