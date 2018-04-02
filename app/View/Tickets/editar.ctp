<?php $this->Html->addCrumb('Tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb($this->request->data['Ticket']['ficha_proyecto'],'/tickets/ver/'.$this->request->data['Ticket']['id'],array('escape'=>false))?>
<?php $this->Html->addCrumb('Editar',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->create('Ticket')?>
        <?php echo $this->Form->hidden('id')?>
        Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
        <br /><br />
        <div class="form-group">
            <label>Empresa solicitante <span class="required">*</span></label>
            <?php echo $this->Form->select('empresa_id',$empresas,array('class'=>'form-control','data-validetta'=>'required','label'=>false,'div'=>false))?>
        </div>
        <div class="form-group">
            <label>Estado <span class="required">*</span></label>
            <?php echo $this->Form->select('estado',$estados,array('class'=>'form-control','data-validetta'=>'required','escape'=>false,'label'=>false,'div'=>false))?>
        </div>
        <div class="form-group">
            <label>Prioridad <span class="required">*</span></label>
            <?php echo $this->Form->select('prioridad',array('alta'=>'Alta','media'=>'Media','baja'=>'Baja'),array('class'=>'form-control','data-validetta'=>'required','label'=>false,'div'=>false))?>
        </div>
        <div class="form-group">
            <label>Monto acordado en USD <span class="required">*</span></label>
            <?php echo $this->Form->input('monto_acordado',array('label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
        </div>
        <div class="form-group">
            <label>Monto final en USD <span class="required">*</span></label>
            <?php echo $this->Form->input('monto_final',array('label'=>false,'div'=>false,'class'=>'form-control','data-validetta'=>'required,number'))?>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="data[Ticket][financiamiento]" value="1"
                <?php echo ( $this->request->data['Ticket']['financiamiento'] == 1 )? 'checked' : '' ;?>
                > La solicitud tiene financiamiento
            </label>
        </div>
        <br />
        <div class="form-group">
            <label>Observaciones acerca del financiamiento</label>
            <?php echo $this->Form->textarea('observaciones_financiamiento',array('class'=>'form-control','rows'=>3))?>
        </div>
    </div>
    <hr />
    <div class="col-md-12">
        <?php echo $this->Html->link('Cancelar',array('controller'=>'tickets','action'=>'ver',$this->request->data['Ticket']['id']),array('class'=>'btn btn-default','escape'=>false))?>
        <input type="submit" id="btn_submit" value="Guardar" class="btn btn-primary">
    </div>
    <?php echo $this->Form->hidden('fecha_apertura')?>
    <?php echo $this->Form->hidden('fecha_cierre')?>
    <?php echo $this->Form->end()?>
</div>