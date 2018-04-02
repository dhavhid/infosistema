<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios Tecnol&oacute;gicos','/empresas/servicios',array('escape'=>false))?>
<?php $this->Html->addCrumb('Categor&iacute;as del servicio tecnol&oacute;gico',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
                <li><a href="/empresas/servicios/perfil/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">1</span> Perfil</a></li>
                <li><a href="/empresas/servicios/tiposervicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">2</span> Tipo de servicio tecnol&oacute;gico</a></li>
                <li class="active"><a href="#categorias" role="tab" data-toggle="tab"><span class="badge">3</span> Categor&iacute;as</a></li>
                <li><a href="/empresas/servicios/sectores/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">4</span> Sectores de apoyo</a></li>
                <li><a href="/empresas/servicios/empresasservicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">5</span> Servicio a empresas</a></li>
            
            </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="categorias">
                <?php echo $this->Form->create('CategoriasApoyo')?>
                
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <label>Elija las categor&iacute;as del servicio tecnol&oacute;gico: <span class="required">*</span></label>
                    <br /><br />
                    <?php
                        $i = 0;
                        foreach( $categorias_defecto as $categoria => $subcategorias ):
                            ?>
                            <div class="col-md-2">
                            <?php
                            echo '<label>' . $categoria . '</label><br />';
                            foreach( $subcategorias as $subcategoria ){
                                ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="<?php echo $subcategoria?>" name="data[<?php echo $i?>][CategoriasApoyo][subcategoria_nombre]" id="medio" data-validetta='minCheck[1]' 
                                        <?php if( is_array($seleccionadas) && count($seleccionadas) > 0 )echo ( in_array($subcategoria.'__'.$categoria, $seleccionadas) )? 'checked' : '' ;?>
                                        /> <?php echo $subcategoria?>
                                        <input type="hidden" name="data[<?php echo $i?>][CategoriasApoyo][servicio_id]" value="<?php echo $this->request->data['ServicioTecnologico']['id']?>">
                                        <input type="hidden" name="data[<?php echo $i?>][CategoriasApoyo][categoria_nombre]" value="<?php echo $categoria?>" />
                                    </label>
                                </div>
                                <?php
                                $i = $i + 1;
                            }
                            echo '<br />';
                            ?>
                            </div>
                            <?php
                        endforeach;
                    ?>
                
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
    .checkbox{margin-bottom:50px !important;}
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