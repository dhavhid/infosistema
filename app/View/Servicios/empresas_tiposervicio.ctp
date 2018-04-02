<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios Tecnol&oacute;gicos','/empresas/servicios',array('escape'=>false))?>
<?php $this->Html->addCrumb('Tipo de servicio tecnol&oacute;gico',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
                <li><a href="/empresas/servicios/perfil/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">1</span> Perfil</a></li>
                <li class="active"><a href="#tiposervicio" role="tab" data-toggle="tab"><span class="badge">2</span> Tipo de servicio tecnol&oacute;gico</a></li>
                <li><a href="/empresas/servicios/categorias/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">3</span> Categor&iacute;as</a></li>
                <li><a href="/empresas/servicios/sectores/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">4</span> Sectores de apoyo</a></li>
                <li><a href="/empresas/servicios/empresasservicio/<?php echo $this->request->data['ServicioTecnologico']['id']?>"><span class="badge">5</span> Servicio a empresas</a></li>
            
            </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tiposervicio">
                <?php echo $this->Form->create('TipoServicio')?>
                <?php echo ( array_key_exists('TipoServicio', $this->request->data) == TRUE )? $this->Form->hidden('id') : '' ;?>
                <?php echo $this->Form->hidden('servicio_id',array('value'=>$this->request->data['ServicioTecnologico']['id']))?>
                <div class="col-md-12">
                    Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
                    <br /><br />
                    <label>Tipo de servicio tecnol&oacute;gico: <span class="required">*</span></label>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[TipoServicio][servicio_tecnologico]" id="medio" data-validetta="minChecked[1]"
                        <?php if( array_key_exists('TipoServicio', $this->request->data) )echo ($this->request->data['TipoServicio']['servicio_tecnologico'] == 1)? 'checked' : '' ;?>
                        > Servicio tecnol&oacute;gico
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[TipoServicio][transferencia_tecnologia]" id="medio"
                        <?php if( array_key_exists('TipoServicio', $this->request->data) )echo ($this->request->data['TipoServicio']['transferencia_tecnologia'] == 1)? 'checked' : '' ;?>
                        > Transferencia de tecnolog&iacute;a
                       </label>
                    </div>  
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[TipoServicio][proyectos_id]" id="medio"
                        <?php if( array_key_exists('TipoServicio', $this->request->data) )echo ($this->request->data['TipoServicio']['proyectos_id'] == 1)? 'checked' : '' ;?>
                        > Proyectos I+D
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[TipoServicio][proyectos_especiales]" id="medio"
                        <?php if( array_key_exists('TipoServicio', $this->request->data) )echo ($this->request->data['TipoServicio']['proyectos_especiales'] == 1)? 'checked' : '' ;?>
                        > Proyectos especiales
                       </label>
                    </div>
                    <div class="checkbox">
                       <label>
                        <input type="checkbox" value="1" name="data[TipoServicio][desarrollo_rrhh]" id="medio"
                        <?php if( array_key_exists('TipoServicio', $this->request->data) )echo ($this->request->data['TipoServicio']['desarrollo_rrhh'] == 1)? 'checked' : '' ;?>
                        > Desarrollo de RRHH
                       </label>
                    </div>
                    <div class="form-group">
                        <label>Otros</label>
                        <?php echo $this->Form->input('otros',array('label'=>false,'div'=>false,'class'=>'form-control'))?>
                        <p class="help-block">Escriba los tipos separados por coma.</p>
                    </div>
                </div>
            </div>
            <!-- fin del panel de perfil -->
            <hr />
            <div class="col-md-12">
                <?php echo $this->Html->link('Cancelar','/empresas/servicios',array('class'=>'btn btn-default'))?>
                <input type="submit" value="Continuar &rarr;" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>
<style>
    .checkbox{margin-bottom:30px !important;}
</style>