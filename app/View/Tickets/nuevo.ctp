<?php $this->Html->addCrumb('Tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb('Nuevo ticket',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->create('Ticket')?>
        Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
        <br /><br />
        <div class="form-group">
            <label>Descripci&oacute;n del ticket <span class="required">*</span></label>
            <?php echo $this->Form->textarea('Mensaje.mensaje',array('rows'=>6,'class'=>'form-control','id'=>'contenido_mensaje','data-validetta'=>'required','style'=>'display:none;'))?>
            <?php echo $this->Form->hidden('Mensaje.fecha_mensaje',array('value'=>date('Y-m-d G:i:s')))?>
            <div class="mensaje"></div>
        </div>
        <div class="form-group">
            <label>Empresa solicitante <span class="required">*</span></label>
            <?php echo $this->Form->select('empresa_id',$empresas,array('class'=>'form-control','data-validetta'=>'required','label'=>false,'div'=>false))?>
        </div>
        <div class="form-group">
            <label>Prioridad <span class="required">*</span></label>
            <?php echo $this->Form->select('prioridad',array('alta'=>'Alta','media'=>'Media','baja'=>'Baja'),array('class'=>'form-control','data-validetta'=>'required','label'=>false,'div'=>false))?>
        </div>
    </div>
    <hr />
    <div class="col-md-12">
        <?php echo $this->Html->link('Cancelar',array('controller'=>'tickets','action'=>'index'),array('class'=>'btn btn-default','escape'=>false))?>
        <input type="button" id="btn_submit" value="Guardar" class="btn btn-primary">
    </div>
    <?php echo $this->Form->hidden('estado',array('value'=>'abierto'))?>
    <?php echo $this->Form->hidden('fecha_apertura',array('value'=>date('Y-m-d G:i:s')))?>
    <?php echo $this->Form->end()?>
</div>
<script type="text/javascript">
    var editor = null;
    $(document).ready(function(){
        editor = setEditor('.mensaje');
        $('#btn_submit').click(function(){
            if( editor.code() != '<p><br></p>' ){
                $('#contenido_mensaje').html( editor.code() ); 
            }   
            $('#TicketNuevoForm').submit(); 
        });
    });
</script>