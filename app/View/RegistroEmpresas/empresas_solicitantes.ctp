<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Empresas solicitantes',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/empresas/registroempresas/perfil/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">1</span> Perfil</a></li>
            <li><a href="/empresas/registroempresas/areas/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">2</span> &Aacute;reas de conocimiento y especialidad</a></li>
            <li><a href="/empresas/registroempresas/laboratorios/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">3</span> Laboratorios</a></li>
            <li><a href="/empresas/registroempresas/recursos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">4</span> Recursos para administraci&oacute;n</a></li>
            <li><a href="/empresas/registroempresas/infraestructuras/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">5</span> Infraestructura</a></li>
            <li class="active"><a href="#solicitantes" role="tab" data-toggle="tab"><span class="badge">6</span> Empresas solicitantes</a></li>
            <li><a href="/empresas/registroempresas/contactos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">7</span> Medios de contacto</a></li>
            <li><a href="/empresas/registroempresas/pagos/<?php echo $this->request->data['Empresa']['id']?>"><span class="badge">8</span> Medios de pago</a></li>
        </ul>   
        <br />
        <div class="tab-content">
            <div class="tab-pane fade in active" id="solicitantes">
                <?php echo $this->Form->create('EmpresasSolicitante')?>
                <?php echo ( array_key_exists('EmpresasSolicitante', $this->request->data) == TRUE )? $this->Form->hidden('id') : '' ;?>
                <?php echo $this->Form->hidden('empresa_id',array('value'=>$this->request->data['Empresa']['id']))?>
                <div class="col-md-12">
                   <div class="form-group">
                       <label>&iquest;Qu&eacute; tipo de empresa le solicita m&aacute;s su servicio&#63; <span class="required">*</span></label>
                   </div>
                   <div class="form-group">
                       <label>Micro empresa</label>
                       <?php echo $this->Form->input('microempresa',array('placeholder'=>'cantidad','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                   </div>
                   <div class="form-group">
                       <label>Peque&ntilde;a empresa</label>
                       <?php echo $this->Form->input('pequenaempresa',array('placeholder'=>'cantidad','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                   </div>
                   <div class="form-group">
                       <label>Mediana empresa</label>
                       <?php echo $this->Form->input('medianaempresa',array('placeholder'=>'cantidad','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                   </div>
                   <div class="form-group">
                       <label>Gran empresa</label>
                       <?php echo $this->Form->input('granempresa',array('placeholder'=>'cantidad','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                   </div>
                   <div class="form-group">
                       <label>Emprendedores</label>
                       <?php echo $this->Form->input('emprendedores',array('placeholder'=>'cantidad','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                   </div>
                   <div class="form-group">
                       <label>Instituciones</label>
                       <?php echo $this->Form->input('instituciones',array('placeholder'=>'cantidad','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
                   </div>  
                </div>
            </div>
            <!-- fin del panel de perfil -->
            <hr />
            <div class="col-md-12">
                <?php echo $this->Html->link('Cancelar','/empresas/registroempresas',array('class'=>'btn btn-default'))?>
                <input type="submit" value="Continuar &rarr;" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end()?>