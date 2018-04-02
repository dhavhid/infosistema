<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('&Aacute;reas de conocimiento y especialidad',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/empresas/registroempresas/perfil/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li class="active"><a href="#areas" role="tab" data-toggle="tab"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
            <li><a href="/empresas/registroempresas/laboratorios/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">3</span> Laboratorios</a></li>
            <li><a href="/empresas/registroempresas/recursos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
            <li><a href="/empresas/registroempresas/infraestructuras/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">5</span> Infraestructura</a></li>
            <li><a href="/empresas/registroempresas/solicitantes/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">6</span> Empresas solicitantes</a></li>
            <li><a href="/empresas/registroempresas/contactos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">7</span> Medios de contacto</a></li>
            <li><a href="/empresas/registroempresas/pagos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">8</span> Medios de pago</a></li>
        </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="areas">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target=".modal">Agregar &aacute;rea</button> 
                </div>
                <br /><br />
                <div class="col-md-12">
                    <table class="table table-bordered table-striped footable">
                        <thead>
                            <tr>
                                <th width="20px"><i class="fa fa-cogs"></i></th>
                                <th>&Aacute;rea</th>
                                <th data-hide="phone">Bachillerato &oacute; T&eacute;cnico</th>
                                <th data-hide="phone">Doctorado</th>
                                <th data-hide="phone">Licenciatura &oacute; Ingenier&iacute;a</th>
                                <th data-hide="phone">Maestr&iacute;a</th>
                                <th data-hide="phone,tablet">Subareas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach( $areas as $area ):
                                ?>
                                <tr id="area<?php echo $area['Area']['id']?>">
                                    <td><a href="javascript:void(0);" onclick="eliminarArea('<?php echo $area['Area']['id']?>');"><i class="fa fa-trash-o fa-2x"></i></a></td>
                                    <td><?php echo $area['Area']['nombre_area']?></td>
                                    <td><?php echo $area['Area']['bachillerato_tecnico']?></td>
                                    <td><?php echo $area['Area']['doctorado']?></td>
                                    <td><?php echo $area['Area']['licenciatura']?></td>
                                    <td><?php echo $area['Area']['maestria']?></td>
                                    <td><?php echo $area['Area']['subareas']?></td>
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
                <?php echo $this->Html->link('Continuar &rarr;',array('controller'=>'registroempresas','action'=>'laboratorios',$this->request->data['Empresa']['id']),array('class'=>'btn btn-primary','escape'=>false))?>
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
                <h4 class="modal-title" id="myModalLabel">&Aacute;reas de conocimiento y especialidad</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12" id="mensajes_alerta"></div>
                <?php echo $this->Form->create('Area')?>
                <?php echo $this->Form->hidden('empresa_id',array('value'=>$this->request->data['Empresa']['id']))?>
                Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                <br /><br />
                <div class="form-group">
                    <label>&Aacute;rea <span class="required">*</span></label>
                    <?php echo $this->Form->input('nombre_area',array('name'=>'data[Area][nombre_area]','label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
                </div>
                <div class="form-group">
                    <label>Cantidad de RRHH por especialidad <span class="required">*</span></label>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="tex-align:center;">Bachillerato<br />&oacute;<br />T&eacute;cnico</th>
                                <th style="tex-align:center;">Doctorado</th>
                                <th style="tex-align:center;">Licenciatura<br />&oacute;<br />Ingenier&iacute;a</th>
                                <th style="tex-align:center;">Maestr&iacute;a</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $this->Form->input('bachillerato_tecnico',array('value'=>0,'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?></td>
                                <td><?php echo $this->Form->input('doctorado',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number','value'=>0))?></td>
                                <td><?php echo $this->Form->input('licenciatura',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number','value'=>0))?></td>
                                <td><?php echo $this->Form->input('maestria',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number','value'=>0))?></td>
                            </tr>
                        </tbody>
                    </table>    
                </div>
                <div class="form-group">
                    <label>Subareas</label>
                    <?php echo $this->Form->input('subareas',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control'))?>
                    <p class="help-block">Ingrese las subareas separadas por coma. Ej. Contabilidad, Recepci&oacute;n, Compras, Caja</p>
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
    function eliminarArea(id){
        if( confirm('Está seguro que desea eliminar el registro del área de la empresa?') ){
            $.ajax({
                url: '/empresas/registroempresas/eliminar_area/'+id+'.json',
                type: 'json',    
                success: function(data,status,jqxhr){
                    $.each(data, function (i, item) {
                        $('#area'+id).slideUp(1500).detach();
                    });
                }
            });
        }
    }
</script>