<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios Tecnol&oacute;gicos','/empresas/servicios',array('escape'=>false))?>
<?php $this->Html->addCrumb('Perfil',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if( array_key_exists('ServicioTecnologico', $this->request->data) ){?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#perfil" role="tab" data-toggle="tab"><span class="badge">1</span> Perfil</a></li>
                <li><a href="/empresas/servicios/tiposervicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">2</span> Tipo de servicio tecnol&oacute;gico</a></li>
                <li><a href="/empresas/servicios/categorias/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">3</span> Categor&iacute;as</a></li>
                <li><a href="/empresas/servicios/sectores/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">4</span> Sectores de apoyo</a></li>
                <li><a href="/empresas/servicios/empresasservicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">5</span> Servicio a empresas</a></li>
            
            </ul>
        <?php }else{?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#perfil" role="tab" data-toggle="tab"><span class="badge">1</span> Perfil</a></li>
                <li class="disabled"><a href="#"><span class="badge">2</span> Tipo de servicio tecnol&oacute;gico</a></li>
                <li class="disabled"><a href="#"><span class="badge">3</span> Categor&iacute;as</a></li>
                <li class="disabled"><a href="#"><span class="badge">4</span> Sectores de apoyo</a></li>
                <li class="disabled"><a href="#"><span class="badge">5</span> Servicio a empresas</a></li>
            </ul>
        <?php }?>    
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="perfil">
                <div class="col-md-12">
                    <?php echo $this->Form->create('ServicioTecnologico')?>
                    <?php if( array_key_exists('ServicioTecnologico', $this->request->data) )echo $this->Form->hidden('id')?>
                    <?php echo $this->Form->textarea('descripcion_servicio',array('label'=>false,'class'=>'form-control','rows'=>'10','data-validetta'=>'required','style'=>'display:none;'))?>
                    <?php echo $this->Form->textarea('pasos_servicio',array('label'=>false,'class'=>'form-control','data-validetta'=>'required','rows'=>'10','style'=>'display:none;'))?>
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <div class="form-group">
                        <label>Empresa a la que pertenece el servicio tecnol&oacute;gico <span class="required">*</span></label>
                        <?php echo $this->Form->select('empresa_id',$empresas,array('label'=>false,'div'=>false,'data-validetta'=>'required','empty'=>true,'class'=>'form-control'))?>
                    </div>
                    <div class="form-group">
                        <label>Nombre del servicio tecnol&oacute;gico <span class="required">*</span></label>
                        <?php echo $this->Form->input('nombre_servicio',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                    </div>
                    <div class="form-group">
                        <label>Descripci&oacute;n del servicio tecnol&oacute;gico <span class="required">*</span></label>
                        <div class="descripcion_servicio"><?php echo (array_key_exists('ServicioTecnologico', $this->request->data))? $this->request->data['ServicioTecnologico']['descripcion_servicio'] : '' ;?></div>
                    </div>
                    <div class="form-group">
                        <label>Describa los pasos que sigue para proporcionar el servicio tecnol&oacute;gico <span class="required">*</span></label>
                        <div class="pasos_servicio"><?php echo (array_key_exists('ServicioTecnologico', $this->request->data))? $this->request->data['ServicioTecnologico']['pasos_servicio'] : '' ;?></div>
                    </div>
                    <div class="form-group">
                        <label>Precio del servicio tecnol&oacute;gico <span class="required">*</span></label>
                        <?php echo $this->Form->input('precio_servicio',array('type'=>'text','label'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                    </div>
                    <div class="form-group">
                        <label>Capacidad de servicios tecnol&oacute;gicos por mes <span class="required">*</span></label>
                        <?php echo $this->Form->input('capacidad_por_mes',array('type'=>'text','label'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                    </div>
                    <div class="form-group">
                        <label>Promedio de servicios tecnol&oacute;gicos actuales provistos por mes <span class="required">*</span></label>
                        <?php echo $this->Form->input('servicios_por_mes',array('type'=>'text','label'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                    </div>
                    <div class="form-group">
                        <label>Tiempo de respuesta o de tr&aacute;mite para brindar el servicio tecnol&oacute;gico</label>
                        <?php echo $this->Form->input('tiempo_respuesta',array('type'=>'text','label'=>false,'class'=>'form-control','data-validetta'=>'number'))?>
                        <p class="help-block">Por favor especif&iacute;que el tiempo en d&iacute;as</p>
                    </div>
                    <div class="form-group">
                        <label>Tiempo en la realizaci&oacute;n del servicio tecnol&oacute;gico y entrega de resultados</label>
                        <?php echo $this->Form->input('tiempo_realizacion',array('type'=>'text','label'=>false,'class'=>'form-control','data-validetta'=>'number'))?>
                        <p class="help-block">Por favor especif&iacute;que el tiempo en d&iacute;as</p>
                    </div>
                    <div class="form-group">
                        <label>Elegibilidad del servicio</label>
                        <?php echo $this->Form->input('eligibilidad',array('label'=>false,'class'=>'form-control'))?>
                    </div>
                    <div class="form-group">
                        <label>Clientes actuales (reales)</label>
                        <?php echo $this->Form->textarea('clientes_actuales',array('label'=>false,'class'=>'form-control','rows'=>'10'))?>
                    </div>
                    <div class="form-group">
                        <label>Clientes potenciales</label>
                        <?php echo $this->Form->textarea('clientes_potenciales',array('label'=>false,'class'=>'form-control','rows'=>'10'))?>
                    </div>
                    <div class="form-group">
                        <label>Precisi&oacute;n (de ser aplicable)</label>
                        <?php echo $this->Form->input('precision',array('label'=>false,'class'=>'form-control'))?>
                    </div>
                    <div class="form-group">
                        <label>Tiempo de ofertar el servicio tecnol&oacute;gico en el mercado</label>
                        <?php echo $this->Form->input('tiempo_en_mercado',array('type'=>'text','label'=>false,'class'=>'form-control'))?>
                        <p class="help-block">Por favor especif&iacute;que el tiempo en meses &oacute; a&ntilde;os</p>
                    </div>
                    <div class="form-group">
                        <label>Si ofrece su servicio tecnol&oacute;gico solo a la Gran Empresa, &iquest;ofrecer&iacute;a sus servicios a medias, peque&ntilde;as y micro empresas?</label>
                        <div class="radio">
                            <label>
                                <input type="radio" id="granempresasi" name="data[ServicioTecnologico][gran_empresa]" value="1"
                                <?php if(array_key_exists('ServicioTecnologico', $this->request->data)){
                                    echo ($this->request->data['ServicioTecnologico']['gran_empresa'] == 1)? 'checked' : '' ;
                                }?>
                                > 
                                Si
                            </label>
                            <br />
                            <label>
                                <input type="radio" id="granempresano" name="data[ServicioTecnologico][gran_empresa]" value="0"
                                <?php if(array_key_exists('ServicioTecnologico', $this->request->data)){
                                    echo ($this->request->data['ServicioTecnologico']['gran_empresa'] == 0)? 'checked' : '' ;
                                }else{
                                    echo 'checked';
                                }?>
                                > 
                                No
                            </label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">&iquest;Por qu&eacute;?</span>
                            <?php echo $this->Form->input('gran_empresa_porque',array('label'=>false,'div'=>false,'class'=>'form-control'))?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Si contest&oacute; &ldquo;si&rdquo; a la pregunta anterior, &iquest;ofrecer&iacute;a alg&uacute;n tipo de oferta para que adquieran su servicio tecnol&oacute;gico?</label>
                        <div class="radio">
                            <label>
                                <input type="radio" id="granempresasi" name="data[ServicioTecnologico][ofreceria_oferta]" value="1"
                                <?php if(array_key_exists('ServicioTecnologico', $this->request->data)){
                                    echo ($this->request->data['ServicioTecnologico']['ofreceria_oferta'] == 1)? 'checked' : '' ;
                                }?>
                                > 
                                Si
                            </label>
                            <br />
                            <label>
                                <input type="radio" id="granempresano" name="data[ServicioTecnologico][ofreceria_oferta]" value="0"
                                <?php if(array_key_exists('ServicioTecnologico', $this->request->data)){
                                    echo ($this->request->data['ServicioTecnologico']['ofreceria_oferta'] == 0)? 'checked' : '' ;
                                }else{
                                    echo 'checked';
                                }?>
                                > 
                                No
                            </label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">&iquest;Por qu&eacute;?</span>
                            <?php echo $this->Form->input('ofreceria_oferta_porque',array('label'=>false,'div'=>false,'class'=>'form-control'))?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Comentarios adicionales</label>
                        <?php echo $this->Form->textarea('comentarios',array('label'=>false,'class'=>'form-control','rows'=>'10'))?>
                    </div>
                </div>
                <hr />
                <div class="col-md-12">
                    <?php echo $this->Html->link('Cancelar','/empresas/servicios',array('class'=>'btn btn-default'))?>
                    <input type="button" id="btn_submit" value="Continuar &rarr;" class="btn btn-primary" />
                </div>
            </div>
            <!-- fin del panel de perfil -->
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<script type="text/javascript">
    $(document).ready(function(){
        desc_editor = setEditor('.descripcion_servicio',{
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        });
        pas_editor = setEditor('.pasos_servicio',{
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        });
        //desc_editor.code( $('#ServicioTecnologicoDescripcionServicio').html() );
        //pas_editor.code( $('#ServicioTecnologicoPasosServicio').html() );
        
        $('#btn_submit').click(function(){
            if( desc_editor.code() != '<p><br></p>' ){
                $('#ServicioTecnologicoDescripcionServicio').html( desc_editor.code() );
            }
            if( pas_editor.code() != '<p><br></p>' ){
                $('#ServicioTecnologicoPasosServicio').html( pas_editor.code() );
            }
            $('#ServicioTecnologicoEmpresasPerfilForm').submit();
        });
    });
</script>
