<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios Tecnol&oacute;gicos','/empresas/servicios',array('escape'=>false))?>
<?php $this->Html->addCrumb('Sectores de apoyo del servicio tecnol&oacute;gico',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
                <li><a href="/empresas/servicios/perfil/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">1</span> Perfil</a></li>
                <li><a href="/empresas/servicios/tiposervicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">2</span> Tipo de servicio tecnol&oacute;gico</a></li>
                <li><a href="/empresas/servicios/categorias/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">3</span> Categor&iacute;as</a></li>
                <li class="active"><a href="#sectores" role="tab" data-toggle="tab"><span class="badge">4</span> Sectores de apoyo</a></li>
                <li><a href="/empresas/servicios/empresasservicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">5</span> Servicio a empresas</a></li>
            
            </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="sectores">
                <?php echo $this->Form->create('SectoresApoyo')?>
                <div class="col-md-12">
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <label>Elija los sectores de apoyo del servicio tecnol&oacute;gico: <span class="required">*</span></label>
                    <br /><br />
                    <?php
                        $i = 0;
                        foreach( $sectores_defecto as $sector ){
                            ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="<?php echo $sector?>" name="data[<?php echo $i?>][SectoresApoyo][sector_nombre]" id="medio" data-validetta='minCheck[1]' 
                                    <?php if( is_array($seleccionadas) && count($seleccionadas) > 0 )echo ( in_array($sector, $seleccionadas) )? 'checked' : '' ;?>
                                    /> <?php echo $sector?>
                                    <input type="hidden" name="data[<?php echo $i?>][SectoresApoyo][servicio_id]" value="<?php echo $this->request->data['ServicioTecnologico']['id']?>">
                                </label>
                            </div>
                            <?php
                            $i = $i + 1;
                        }
                        $i++;
                    ?>
                    <div class="form-group">
                        <label>Otros (Especif&iacute;que)</label>
                        <input type="text" name="data[<?php echo $i?>][SectoresApoyo][sector_nombre]" class="form-control"
                        <?php if( array_key_exists('SectoresApoyo', $otros) )echo "value='".$otros['SectoresApoyo']['sector_nombre']."'"?>
                        >
                        <input type="hidden" name="data[<?php echo $i?>][SectoresApoyo][otros]" value="1">
                        <input type="hidden" name="data[<?php echo $i?>][SectoresApoyo][servicio_id]" value="<?php echo $this->request->data['ServicioTecnologico']['id']?>">
                        <p class="help-block">Escriba los sectores separados por coma.</p>
                    </div>
                </div>
            </div>
            <!-- fin del panel de perfil -->
            <hr />
            <div class="col-md-12">
                <?php echo $this->Html->link('Cancelar','/empresas/servicios',array('class'=>'btn btn-default'))?>
                <input type="button" id="btn_submit" value="Continuar &rarr;" class="btn btn-primary">
                <input type="submit" style="display:none;" />
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<style>
    .checkbox{margin-bottom:30px !important;}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('form').validetta().destroy();
        $('#btn_submit').click(function(){
            var ch = $('input:checkbox:checked');
            if( ch.length == 0 ){
                $('span.validetta-bubble').detach();
                $('div.checkbox:first').append('<span class="validetta-bubble">Por favor seleccione por lo menos 1 opci&oacute;n<br/><span class="validetta-bubbleClose">x</span></span>');
                $('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
                var body = $("html, body");
                body.animate({scrollTop:0}, '500', 'swing', function() {
                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                });
            }else{
                $('input[type="submit"]').click();
            }
        });
    });
</script>