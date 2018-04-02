<?php $this->Html->addCrumb('B&uacute;squedas','/busquedas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios tecnol&oacute;gicos',false,array('escape'=>false))?>
<?php echo $this->Html->script('buscar')?>
<div class="row">
    <div class="col-md-12 mensaje_principal"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary" id="btn_buscar"><i class="fa fa-search"></i> Buscar</button>
        <button class="btn btn-default" id="btn_avanzada"><i class="fa fa-expand"></i> B&uacute;squeda avanzada</button>
        <?php echo ( $ticket_id != 0 )? $this->Html->link('<i class="fa fa-tags"></i> Ir al ticket',array('controller'=>'tickets','action'=>'ver',$ticket_id),array('class'=>'btn btn-info','escape'=>false)) : '' ; ?>
    </div>
</div><br />
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Escriba una frase clave de la descripci&oacute;n, nombre del servicio tecnol&oacute;gico &oacute; nombre de la empresa <span class="required">*</span></label>
            <input type="text" class="form-control" id="filtro" placeholder="Escriba una frase clave de la descripci&oacute;n, nombre del servicio tecnol&oacute;gico &oacute; nombre de la empresa">
        </div>
    </div>
</div>
<div class="row avanzada">
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-primary"><i class="fa fa-check-square-o"></i> El servicio tecnol&oacute;gico debe pertenecer a alguno de los siguientes tipos:</label>
            <div class="checkbox">
                <?php
                    foreach( $tipo_servicio_x_defecto as $key => $value ){
                        ?>
                        <label>
                            <input type="checkbox" id="tiposervicio" value="<?php echo $key?>">
                            <?php echo $value?>
                        </label>
                        &nbsp;&nbsp; / &nbsp;&nbsp;
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->
        </div>
    </div>
</div>
<div class="row avanzada">
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-primary"><i class="fa fa-check-square-o"></i> El servicio tecnol&oacute;gico debe estar dirigido a alguno de los siguientes tipos de empresas:</label>
            <div class="checkbox">
                <?php
                    foreach( $tipoempresa_x_defecto as $key => $value ){
                        ?>
                        <label>
                            <input type="checkbox" id="tipoempresa" value="<?php echo $key?>">
                            <?php echo $value?>
                        </label>
                        &nbsp;&nbsp; / &nbsp;&nbsp;
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->    
        </div>
    </div>
</div>
<div class="row avanzada">
    <div class="col-md-12">
        <label class="text-primary"><i class="fa fa-check-square-o"></i> El servicio tecnol&oacute;gico debe pertenecer a alguno de los siguientes apoyos y categor&iacute;as:</label>
    </div>
    <?php
    foreach( $categorias_x_defecto as $categoria => $subcategorias ){
        ?>
        <div class="col-md-2">
            <u><?php echo $categoria?></u><br />
            <div class="checkbox">
                <?php
                    foreach( $subcategorias as $subcategoria ){
                        ?>
                        <label>
                            <input type="checkbox" id="subcategorias" value="<?php echo $subcategoria?>">
                            <?php echo $subcategoria?>
                        </label>
                        <br />
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->
        </div>
        <?php
    }
    ?>
</div>
<div class="row avanzada">    
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-primary"><i class="fa fa-check-square-o"></i> La empresa oferente debe contar con RRHH especializados en alguna de las siguientes &aacute;reas:</label>
            <div class="checkbox">
                <?php
                    foreach( $areas_especialidad_x_defecto as $key => $value ){
                        ?>
                        <label>
                            <input type="checkbox" id="areas" value="<?php echo $key?>">
                            <?php echo $value?>
                        </label>
                        &nbsp;&nbsp; / &nbsp;&nbsp;
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->
        </div>
    </div>
</div>
<div class="row avanzada">
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-primary"><i class="fa fa-check-square-o"></i> La empresa oferente debe contar con algunos de los siguientes tipos de laboratorios:</label>
            <div class="checkbox">
                <?php
                    foreach( $tipos_laboratorios_x_defecto as $key => $value ){
                        ?>
                        <label>
                            <input type="checkbox" id="laboratorios" value="<?php echo $key?>">
                            <?php echo $value?>
                        </label>
                        &nbsp;&nbsp; / &nbsp;&nbsp;
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->    
        </div>
    </div>
</div>
<div class="row avanzada">
    <div class="col-md-12">
        <div class="form-group">
            <label class="text-primary"><i class="fa fa-check-square-o"></i> La empresa oferente debe apoyar a alguno de los siguientes sectores:</label>
            <div class="checkbox">
                <?php
                    foreach( $sectores_x_defecto as $sector ){
                        ?>
                        <label>
                            <input type="checkbox" id="sectores" value="<?php echo $sector?>">
                            <?php echo $sector?>
                        </label>
                        &nbsp;&nbsp; / &nbsp;&nbsp;
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->    
        </div>
    </div>
</div>
<div class="row avanzada">
    <div class="col-md-12"> 
        <div class="form-group">
            <label class="text-primary"><i class="fa fa-check-square-o"></i> La empresa oferente debe estar ubicada en alguno de los siguientes departamentos:</label>
            <div class="checkbox">
                <?php
                    foreach( $departamentos as $id => $departamento ){
                        ?>
                        <label>
                            <input type="checkbox" id="departamentos" value="<?php echo $id?>">
                            <?php echo $departamento?>
                        </label>
                        &nbsp;&nbsp; / &nbsp;&nbsp;
                        <?php
                    }
                ?>
            </div><!-- fin de checkbox div -->    
        </div><!-- fin de form-group -->
    </div><!-- fin de col-md-12 -->
</div>
<hr />
<div class="row resultados">
    
</div>
<!-- ********************************************************** -->
<?php if( $ticket_id != 0 ):?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title" id="myModalLabel">Sugerir servicio tecnol&oacute;gico</h4>
			</div><!-- fin de modal-content -->
			<div class="modal-body">
				<?php echo $this->Form->create('Mensaje')?>
		        <?php echo $this->Form->hidden('ticket_id',array('value'=>$ticket_id))?>
		        <?php echo $this->Form->hidden('persona_id',array('value'=>$usuario['Usuario']['persona_id']))?>
		        <?php echo $this->Form->textarea('mensaje',array('id'=>'area_mensaje','style'=>'display:none;','data-validetta'=>'required'))?>
		        <?php echo $this->Form->hidden('MensajesServicio.servicio_id')?>
		        <div class="row"><div class="col-md-12" id="mensajes_alerta"></div></div>
		        <div class="row">
			        <div id="nombre_servicio" class="col-md-12 text-primary"></div>
		        </div><br />
		        <div class="row">
		        	<div class="col-md-12">
		        		Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
				        <br /><br />
				        <div class="form-group">
				            <label>Su comentario <span class="required">*</span></label>
				            <div class="mensaje"></div>
				        </div>
		        	</div><!-- fin de col-md-12 -->
		        </div>
		        <div class="row">
			        <div class="col-md-12">
			        	<input type="button" name="cancelar" id="btn_cancelar" value="Cancelar" class="btn btn-default" onclick="$('#myModal').modal('hide')">
			        	<input type="button" value="Sugerir" name="enviar" id="btn_submit" class="btn btn-primary">
			        </div><!-- fin de col-md-12 -->
		        </div>
		        <?php echo $this->Form->end()?>	
			</div><!-- fin de modal-body -->
		</div><!-- fin de modal-content -->
	</div><!-- fin de modal-dialog -->
</div><!-- fin de modal -->
<script type="text/javascript">
	var editor = null;
    $(document).ready(function(){
        editor = setEditor('.mensaje',{
            height: 70,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        });
        $('#btn_submit').click(function(){
	        var formulario = document.getElementById('MensajeVerForm');
            if( editor.code() != '<p><br></p>' ){
                $('#area_mensaje').html( editor.code() ); 
            }
            if( $('#area_mensaje').val().length < 5 ){
                $('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
				$(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
                	$(this).remove(); 
                });	
                return false;
            }
	        var params = {
		        "Mensaje": {
			        "ticket_id": $('#MensajeTicketId').val(),
			        "persona_id": $('#MensajePersonaId').val(),
			        "mensaje": $('#area_mensaje').html()
		        },
		        "MensajesServicio": {
			        "servicio_id": $('#MensajesServicioServicioId').val()
		        }
	        }
	        $(this).val('Sugerir ...');
	        $(this).attr('disabled','disabled');
	        $.ajax({
	            "url":"/tickets/adjuntar_servicio.json",
	            "data": params,
	            "type": "POST",
	            "dataType": "json",
	            "success": function(data,status,jqxhr){
	                console.log(data);
	                resetFormulario();
	                $('.mensaje_principal').empty().append( $('<div>',{"class":data.class}).html(data.mensaje) );
	                var body = $("html, body");
	                body.animate({scrollTop:0}, '500', 'swing', function() {
	                    $(".alert").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
	                        $(this).remove(); 
	                    });
	                });
	                //popularResultados(data);
	            },// fin de success
	            "error": function( data, textStatus, errorThrown){
	            	resetFormulario();
	            }//fin de error
	        });
        });
	});        
	function resetFormulario(){
		$('#area_mensaje').html('');
		editor.code('');
		$('#MensajesServicioServicioId').val('');
		$('#myModal').modal('hide');
		$('#btn_submit').val('Sugerir');
        $('#btn_submit').removeAttr('disabled');
	}
</script>        
<?php endif;?>