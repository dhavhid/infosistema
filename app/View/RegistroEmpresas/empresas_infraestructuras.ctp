<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Infraestructura',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/empresas/registroempresas/perfil/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li><a href="/empresas/registroempresas/areas/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
            <li><a href="/empresas/registroempresas/laboratorios/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">3</span> Laboratorios</a></li>
            <li><a href="/empresas/registroempresas/recursos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
            <li class="active"><a href="#infraestructura" role="tab" data-toggle="tab"><span class="badge">5</span> Infraestructura</a></li>
            <li><a href="/empresas/registroempresas/solicitantes/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">6</span> Empresas solicitantes</a></li>
            <li><a href="/empresas/registroempresas/contactos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">7</span> Medios de contacto</a></li>
            <li><a href="/empresas/registroempresas/pagos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">8</span> Medios de pago</a></li>
        </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="infraestructura">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target=".modal">Agregar infraestructura</button> 
                </div>
                <br /><br />
                <div class="col-md-12">
                    <table class="table table-bordered table-striped footable">
                        <thead>
                            <tr>
                                <th width="20px"><i class="fa fa-cogs"></i></th>
                                <th>Infraestructura</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach( $infraestructuras as $infraestructura ):
                                ?>
                                <tr id="infraestructura<?php echo $infraestructura['Infraestructura']['id']?>">
                                    <td><a href="javascript:void(0);" onclick="eliminarInfraestructura('<?php echo $infraestructura['Infraestructura']['id']?>');"><i class="fa fa-trash-o fa-2x"></i></a></td>
                                    <td><?php echo $infraestructura['Infraestructura']['nombre_infraestructura']?></td>
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
                <?php echo $this->Html->link('Continuar &rarr;',array('controller'=>'registroempresas','action'=>'solicitantes',$this->request->data['Empresa']['id']),array('class'=>'btn btn-primary','escape'=>false))?>
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
                <h4 class="modal-title" id="myModalLabel">Infraestructuras</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12" id="mensajes_alerta"></div>
                <?php echo $this->Form->create('Infraestructura')?>
                <?php echo $this->Form->hidden('empresa_id',array('value'=>$this->request->data['Empresa']['id']))?>
                Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                <br /><br />
                <div class="form-group">
                    <label>Nombre de la infraestructura <span class="required">*</span></label>
                    <?php echo $this->Form->input('nombre_infraestructura',array('label'=>false,'class'=>'form-control','data-validetta'=>'required'))?>
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
    function eliminarInfraestructura(id){
        if( confirm('Está seguro que desea eliminar el registro de la infraestructura de la empresa?') ){
            $.ajax({
                url: '/empresas/registroempresas/eliminar_infraestructura/'+id+'.json',
                type: 'json',    
                success: function(data,status,jqxhr){
                    $.each(data, function (i, item) {
                        $('#infraestructura'+id).slideUp(1500).detach();
                    });
                }
            });
        }
    }
</script>