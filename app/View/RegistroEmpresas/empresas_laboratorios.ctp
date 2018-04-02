<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Laboratorios',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/empresas/registroempresas/perfil/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li><a href="/empresas/registroempresas/areas/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
            <li class="active"><a href="#laboratorios" role="tab" data-toggle="tab"><span class="badge">3</span> Laboratorios</a></li>
            <li><a href="/empresas/registroempresas/recursos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
            <li><a href="/empresas/registroempresas/infraestructuras/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">5</span> Infraestructura</a></li>
            <li><a href="/empresas/registroempresas/solicitantes/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">6</span> Empresas solicitantes</a></li>
            <li><a href="/empresas/registroempresas/contactos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">7</span> Medios de contacto</a></li>
            <li><a href="/empresas/registroempresas/pagos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">8</span> Medios de pago</a></li>
        </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="laboratorios">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target=".modal">Agregar laboratorio</button> 
                </div>
                <br /><br />
                <div class="col-md-12">
                    <table class="table table-bordered table-striped footable">
                        <thead>
                            <tr>
                                <th width="20px"><i class="fa fa-cogs"></i></th>
                                <th>Laboratorio</th>
                                <th data-hide="phone,tablet">Experimentaci&oacute;n &oacute; Pr&aacute;cticas</th>
                                <th data-hide="phone,tablet">Investigaci&oacute;n</th>
                                <th data-hide="phone,tablet">Investigaci&oacute;n y Desarrollo</th>
                                <th data-hide="phone,tablet">Pruebas y Ensayos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach( $laboratorios as $laboratorio ):
                                ?>
                                <tr id="laboratorio<?php echo $laboratorio['Laboratorio']['id']?>">
                                    <td><a href="javascript:void(0);" onclick="eliminarLaboratorio('<?php echo $laboratorio['Laboratorio']['id']?>');"><i class="fa fa-trash-o fa-2x"></i></a></td>
                                    <td><?php echo $laboratorio['Laboratorio']['nombre_laboratorio']?></td>
                                    <td>
                                        <ul>
                                            <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['experimentacion']?></li>
                                            <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_experimentacion']?></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['investigacion']?></li>
                                            <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_investigacion']?></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['investigacion_desarrollo']?></li>
                                            <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_investigacion_desarrollo']?></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Cantidad de laboritorios: <?php echo $laboratorio['Laboratorio']['pruebas_ensayos']?></li>
                                            <li>Cantidad de RRHH: <?php echo $laboratorio['Laboratorio']['rrhh_pruebas_ensayos']?></li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>    
                    <hr />
                </div>
                
            </div>
            <!-- fin del panel de perfil -->
            <hr />
            <div class="col-md-12">
                <?php echo $this->Html->link('Cancelar','/empresas/registroempresas',array('class'=>'btn btn-default'))?>
                <?php echo $this->Html->link('Continuar &rarr;',array('controller'=>'registroempresas','action'=>'recursos',$this->request->data['Empresa']['id']),array('class'=>'btn btn-primary','escape'=>false))?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<!-- ___________________________________________________________________________________________________________ -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Laboratorios</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12" id="mensajes_alerta"></div>
                <?php echo $this->Form->create('Laboratorio')?>
                <?php echo $this->Form->hidden('empresa_id',array('value'=>$this->request->data['Empresa']['id']))?>
                Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                <br /><br />
                <div class="form-group">
                    <label>Laboratorio <span class="required">*</span></label>
                    <?php echo $this->Form->input('nombre_laboratorio',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                </div>
                <div class="form-group">
                    <label>Experimentaci&oacute;n &oacute; Pr&aacute;cticas <span class="required">*</span></label>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Cantidad de laboratorios</th>
                                <th>Cantidad de RRHH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $this->Form->input('experimentacion',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                                <td><?php echo $this->Form->input('rrhh_experimentacion',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <label>Investigaci&oacute;n <span class="required">*</span></label>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Cantidad de laboratorios</th>
                                <th>Cantidad de RRHH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $this->Form->input('investigacion',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                                <td><?php echo $this->Form->input('rrhh_investigacion',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <label>Investigaci&oacute;n y Desarrollo <span class="required">*</span></label>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Cantidad de laboratorios</th>
                                <th>Cantidad de RRHH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $this->Form->input('investigacion_desarrollo',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                                <td><?php echo $this->Form->input('rrhh_investigacion_desarrollo',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <label>Pruebas y Ensayos <span class="required">*</span></label>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Cantidad de laboratorios</th>
                                <th>Cantidad de RRHH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $this->Form->input('pruebas_ensayos',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                                <td><?php echo $this->Form->input('rrhh_pruebas_ensayos',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr />
                <div class="form-group">
                    <button class="btn btn-default" onclick="$('.modal').modal('hide');">Cancelar</button>
                    <input type="submit" id="btn_submit" value="Guardar" class="btn btn-primary" />
                </div>
                <!-- Fin de formulario -->
            </div>
        </div>
    </div>
</div>
<!-- ___________________________________________________________________________________________________________ -->
<script type="text/javascript">
    function eliminarLaboratorio(id){
        if( confirm('Está seguro que desea eliminar el registro del laboratorio de la empresa?') ){
            $.ajax({
                url: '/empresas/registroempresas/eliminar_laboratorio/'+id+'.json',
                type: 'json',    
                success: function(data,status,jqxhr){
                    $.each(data, function (i, item) {
                        $('#laboratorio'+id).slideUp(1500).detach();
                    });
                }
            });
        }
    }
</script>