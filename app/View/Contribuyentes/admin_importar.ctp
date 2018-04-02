<?php $this->Html->addCrumb('Administraci&oacute;n','/admin',array('escape'=>false))?>
<?php $this->Html->addCrumb('Contribuyentes','/admin/contribuyentes/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Importaci&oacute;n',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
        <br /><br />
        <?php echo $this->Form->create('Contribuyente',array('type'=>'file'))?>
        <div class="form-group">
            <label>Seleccione el archivo de contribuyentes <span class="required">*</span></label>
            <input style="display:none;" name="archivo" id="archivo" type="file" data-validetta="required" />
            <br />
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-success" id="btn_seleccionar" type="button"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Seleccionar</button>
              </span>
              <input type="text" class="form-control" id="archivo_seleccionado" placeholder="archivo con extensi&oacute;n .csv" readonly>
            </div>
            <p class="help-block">Por favor seleccione un archivo <strong>CSV</strong> con el formato mostrado en este <a href="<?php echo FULL_BASE_URL . DS . 'files' . DS . 'muestras' . DS . 'Contribuyentes.csv';?>">archivo de muestra</a></p>
        </div>
        <?php echo $this->Form->end()?>
    </div>
    <div class="col-md-12">
        <?php echo $this->Html->link('Cancelar','/admin/contribuyentes',array('class'=>'btn btn-default'))?>
        <input type="button" value="Importar" id="btn_enviar" class="btn btn-primary" />
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_seleccionar').click(function(){
            $('#archivo').click();
        });
        $('#archivo').change(function(){
            $('#archivo_seleccionado').val($('#archivo').val());    
        });
        $('#btn_enviar').click(function(){
            var formulario = document.getElementById('ContribuyenteAdminImportarForm');
            if( validar_file(formulario, [".csv"]) == true && $('#archivo_seleccionado').val().length > 0 ){
                formulario.submit();
            }
        });
    });
</script>