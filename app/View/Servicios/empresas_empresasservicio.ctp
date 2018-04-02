<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios Tecnol&oacute;gicos','/empresas/servicios',array('escape'=>false))?>
<?php $this->Html->addCrumb('Empresas a las que se provee el servicio tecnol&oacute;gico',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
                <li><a href="/empresas/servicios/perfil/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">1</span> Perfil</a></li>
                <li><a href="/empresas/servicios/tiposervicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">2</span> Tipo de servicio tecnol&oacute;gico</a></li>
                <li><a href="/empresas/servicios/categorias/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">3</span> Categor&iacute;as</a></li>
                <li><a href="/empresas/servicios/sectores/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">4</span> Sectores de apoyo</a></li>
                <li class="active"><a href="#empresaservicio" role="tab" data-toggle="tab"><span class="badge">5</span> Servicio a empresas</a></li>
            
            </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="empresaservicio">
                <?php echo $this->Form->create('EmpresasServicio')?>
                <?php echo ( array_key_exists('EmpresasServicio', $this->request->data) == TRUE )? $this->Form->hidden('id') : '' ;?>
                <?php echo $this->Form->hidden('servicio_id',array('value'=>$this->request->data['ServicioTecnologico']['id']))?>
                <div class="col-md-12">
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <label>Elija los tipos de empresas a las que provee el servicio tecnol&oacute;gico: <span class="required">*</span></label>
                    <br /><br />
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[EmpresasServicio][microempresa]" id="medio"
                        <?php if( array_key_exists('EmpresasServicio', $this->request->data) )echo ($this->request->data['EmpresasServicio']['microempresa'] == 1)? 'checked' : '' ;?>
                        > Micro empresa
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[EmpresasServicio][pequenaempresa]" id="medio"
                        <?php if( array_key_exists('EmpresasServicio', $this->request->data) )echo ($this->request->data['EmpresasServicio']['pequenaempresa'] == 1)? 'checked' : '' ;?>
                        > Peque&ntilde;a empresa
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[EmpresasServicio][medianaempresa]" id="medio"
                        <?php if( array_key_exists('EmpresasServicio', $this->request->data) )echo ($this->request->data['EmpresasServicio']['medianaempresa'] == 1)? 'checked' : '' ;?>
                        > Mediana empresa
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[EmpresasServicio][granempresa]" id="medio"
                        <?php if( array_key_exists('EmpresasServicio', $this->request->data) )echo ($this->request->data['EmpresasServicio']['granempresa'] == 1)? 'checked' : '' ;?>
                        > Gran empresa
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[EmpresasServicio][emprendedores]" id="medio"
                        <?php if( array_key_exists('EmpresasServicio', $this->request->data) )echo ($this->request->data['EmpresasServicio']['emprendedores'] == 1)? 'checked' : '' ;?>
                        > Emprendimiento / Incubaci&oacute;n
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[EmpresasServicio][instituciones]" id="medio"
                        <?php if( array_key_exists('EmpresasServicio', $this->request->data) )echo ($this->request->data['EmpresasServicio']['instituciones'] == 1)? 'checked' : '' ;?>
                        > Instituciones
                       </label>
                    </div>
                </div>
            </div>
            <!-- fin del panel de perfil -->
            <hr />
            <div class="col-md-12">
                <?php echo $this->Html->link('Cancelar','/empresas/servicios',array('class'=>'btn btn-default'))?>
                <input type="button" id="btn_submit" value="Terminar" class="btn btn-primary">
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