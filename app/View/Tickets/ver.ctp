<?php $this->Html->addCrumb('Tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb($ticket['Ticket']['ficha_proyecto'],false,array('escape'=>false))?>
<div class="row"><div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div></div>
<div class="row">
	<?php if( $usuario['Usuario']['empresa_id'] == $empresa['Empresa']['id'] || $usuario['Usuario']['isadmin'] == 1 ){?>
	    <div class="col-md-5">
	        Empresa solicitante: <br /><strong><?php echo $empresa['Empresa']['nombre_empresa']?></strong>
	    </div>
	<?php }?>    
    <div class="col-md-3">
        Estado: <br /><strong><?php echo $estados[$ticket['Ticket']['estado']]?></strong>
    </div>
    <div class="col-md-2">
        Prioridad: <br /><strong><?php echo ucfirst($ticket['Ticket']['prioridad'])?></strong>
    </div>
    <div class="col-md-2">
        Fecha de apertura: <br /><strong><?php echo date('d-m-Y',strtotime($ticket['Ticket']['fecha_apertura']))?></strong>
    </div>
</div>
<br />
<div class="row">
	<div class="col-md-12 servicioseleccionado"></div>
</div>
<hr />
<!-- ********************************************** -->
<div class="row">
    <div class="col-md-12">
    	<?php if( $ticket['Ticket']['estado'] == 'cerrado' && $usuario['Usuario']['isadmin'] == 1 ):?>
        	<?php echo $this->Html->link('<i class="fa fa-file-text-o"></i> Redactar contrato',array('controller'=>'tickets','action'=>'contrato',$ticket['Ticket']['id']),array('class'=>'btn btn-primary','escape'=>false));?>
        <?php endif;?>
        <?php if( $ticket['Ticket']['estado'] == 'finalizado con exito' && $usuario['Usuario']['isadmin'] == 0 ):?>
        	<?php echo $this->Html->link('<i class="fa fa-star"></i> Evaluar servicio tecnol&oacute;gico',array('controller'=>'tickets','action'=>'criterios',$ticket['Ticket']['id']),array('class'=>'btn btn-primary','escape'=>false));?>
        <?php endif;?>
        <?php if( $ticket['Ticket']['estado'] == 'abierto' || $ticket['Ticket']['estado'] == 'en espera' ):?>
        	<button class="btn btn-primary" id="agregar_comentario"><i class="fa fa-comments"></i> Comentar</button>
        	<?php if( $usuario['Usuario']['isadmin'] == 1 ){?>
        	   <?php echo $this->Html->link('<i class="fa fa-search"></i> Buscar',array('controller'=>'busquedas','action'=>'index',$ticket['Ticket']['id']),array('escape'=>false,'class'=>'btn btn-info'))?>
            <?php }?>
        <?php endif;?>
        <?php if( $usuario['Usuario']['isadmin'] == 1 ){?>
        	<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Editar ticket',array('controller'=>'tickets','action'=>'editar',$ticket['Ticket']['id']),array('escape'=>false,'class'=>'btn btn-default'))?>
        <?php }?>
        <div class="btn-group">
        	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        		<i class="fa fa-print"></i> Imprimir <span class="caret"></span>
        	</button>
        	<ul class="dropdown-menu" role="menu">
	        	<li><?php echo $this->Html->link('Ticket',array('controller'=>'tickets','action'=>'imprimir_ticket',$ticket['Ticket']['id']),array('escape'=>false))?></li>
				<li><?php echo $this->Html->link('Ficha de Proyecto',array('controller'=>'tickets','action'=>'fichaproyecto',$ticket['Ticket']['id']),array('escape'=>false))?></li>
				<?php if( $contrato == 1 ){?>
					<li><?php echo $this->Html->link('Contrato',array('controller'=>'tickets','action'=>'imprimir_contrato',$ticket['Ticket']['id']),array('escape'=>false))?></li>
				<?php }?>
        	</ul>
        </div><!-- fin de imprimir grupo -->	
    </div>
</div>
<br />
<div class="row" id="comentario">
    <div class="col-md-12">
        <?php echo $this->Form->create('Mensaje',array('type'=>'file'))?>
        <?php echo $this->Form->hidden('ticket_id',array('value'=>$ticket['Ticket']['id']))?>
        <?php echo $this->Form->hidden('persona_id',array('value'=>$usuario['Usuario']['persona_id']))?>
        <?php echo $this->Form->textarea('mensaje',array('id'=>'area_mensaje','style'=>'display:none;','data-validetta'=>'required'))?>
        <input style="display:none;" name="archivo0" id="archivo1" type="file" />
        <input style="display:none;" name="archivo1" id="archivo2" type="file" />
        <input style="display:none;" name="archivo2" id="archivo3" type="file" />
        Los campos marcados con <font color="#FF0000">*</font> son obligatorios.
        <br /><br />
        <div class="form-group">
            <label>Su comentario <span class="required">*</span></label>
            <div class="mensaje"></div>
            <p class="help-block">Los archivos adjuntos pueden ser de los siguientes tipos: pdf, word, excel, powerpoint, csv &oacute; imagen tipo png, jpg, gif</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" id="btn_seleccionar1" type="button"><i class="fa fa-paperclip"></i></button>
              </span>
              <input type="text" class="form-control" id="archivo_seleccionado1" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-3">    
        <div class="form-group">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" id="btn_seleccionar2" type="button"><i class="fa fa-paperclip"></i></button>
              </span>
              <input type="text" class="form-control" id="archivo_seleccionado2" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-3">    
        <div class="form-group">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" id="btn_seleccionar3" type="button"><i class="fa fa-paperclip"></i></button>
              </span>
              <input type="text" class="form-control" id="archivo_seleccionado3" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <input type="button" class="btn btn-default" id="cancelar" value="Cancelar">
        <input class="btn btn-primary" id="btn_submit" type="button" value="Enviar">
    </div>    
    <?php echo $this->Form->end()?>        
</div>        
<hr />
<div class="row">
    <div class="col-md-12" id="mensajes">
        <?php 
        foreach( $mensajes as $mensaje ):
            $timeago = $this->Time->timeAgoInWords(strtotime($mensaje['Mensaje']['fecha_mensaje']));
            $timeago = str_replace(
                array('ago','years','year','months','month','days','day','hours','hour','minutes','minute','seconds','second','just now'), 
                array('','a&ntilde;os','a&ntilde;o','meses','mes','d&iacute;as','d&iacute;a','horas','hora','minutos','minuto','segundos','segundo','un momento'), 
                $timeago);  
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                	<?php $text_color = ( $personac['Usuario']['usuario'] == $mensaje['Usuario']['usuario'] )? '' : 'text-primary' ;?>
                    <?php if( ($personac['Usuario']['usuario'] == $mensaje['Usuario']['usuario'] || $personac['Usuario']['isadmin'] == 1) && ($ticket['Ticket']['estado'] == 'abierto' || $ticket['Ticket']['estado'] == 'en espera') ){
                        echo $this->Html->link('<i class="fa fa-times pull-right"></i>',array('controller'=>'tickets','action'=>'eliminar_mensaje',$mensaje['Mensaje']['id'],$ticket['Ticket']['id']),array('escape'=>false),'¿Está seguro que desea eliminar este mensaje? Esta acción no se puede deshacer.');
                    }?>
                    <i class=" pull-left fa fa-comment <?php echo $text_color?>"></i>
                    <strong class="<?php echo $text_color?>"><?php echo $mensaje['Persona']['primer_nombre'] . ' ' . $mensaje['Persona']['primer_apellido'] ?></strong> <small class="<?php echo $text_color?>">dijo</small><br />
                    <em class="<?php echo $text_color?>">hace <?php echo $timeago?></em>
                </div>
                <div class="panel-body"><?php echo $mensaje['Mensaje']['mensaje']?></div>   
                <!-- Lista de adjuntos si existen -->
                <?php if( is_array($mensaje['MensajesAdjunto']) && count($mensaje['MensajesAdjunto']) > 0 ){?>
                <ul class="list-group">
                    <?php
                        foreach($mensaje['MensajesAdjunto'] as $adjunto){
                            ?>
                            <li class="list-group-item">
                                <?php echo $this->Html->link('<i class="fa fa-download"></i> '.$adjunto['nombre_archivo'],array('controller'=>'tickets','action'=>'descargarArchivo',$mensaje['Mensaje']['id'],$adjunto['nombre_archivo']),array('escape'=>false))?>
                                <small>(<?php echo $this->Number->toReadableSize($adjunto['tamano_archivo'])?>)</small>
                            </li>
                            <?php
                        }
                    ?>
                </ul> 
                <?php }?>
                <?php if( is_array($mensaje['MensajesServicio']) && count($mensaje['MensajesServicio']) > 0 ){?>
            	<ul class="list-group">
            		<?php
						foreach( $mensaje['MensajesServicio'] as $servicio ){
							$seleccionado = ($servicio['servicio_seleccionado'] == 1)? 'list-group-item-info' : 'list-group-item-warning' ;
							?>
							<li class="list-group-item <?php echo $seleccionado?>">
								<?php if( $servicio['servicio_seleccionado'] == 0 && ($ticket['Ticket']['estado'] == 'abierto' || $ticket['Ticket']['estado'] == 'en espera') ):
									echo $this->Html->link('<i class="fa fa-square-o"></i>',array('controller'=>'tickets','action'=>'seleccionar_servicio',$ticket['Ticket']['id'],$servicio['id']),array('escape'=>false,'class'=>'pull-right','id'=>'tooltip','data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Seleccionar este servicio'),'¿Está seguro que desea escoger este servicio tecnológico para su adquisición? Esta opción puede ser modificada.');
								endif;
								if( $servicio['servicio_seleccionado'] == 1 ):
									echo '<i class="fa fa-check-square-o pull-right"></i>';
									$servicio_seleccionado = $servicio['ServicioTecnologico']['nombre_servicio'];
									$servicio_seleccionado_id = $servicio['ServicioTecnologico']['id'];
								endif;
								?>
								<?php echo $this->Html->link($servicio['ServicioTecnologico']['nombre_servicio'],array('controller'=>'empresas/servicios','action'=>'ver',$servicio['ServicioTecnologico']['id']),array('escape'=>false))?>
							</li>	
							<?php
						}                    		
            		?>
            	</ul>
                <?php }?>
            </div>   
            <?php
        endforeach;
        ?>
    </div>
</div>
<script type="text/javascript">
	<?php
	if( isset($servicio_seleccionado) && isset($servicio_seleccionado_id) )
		echo "var servicio_nombre = '{$servicio_seleccionado}'; var servicio_id = '{$servicio_seleccionado_id}';";
	else echo "var servicio_id = undefined;";
	?>
    var editor = null;
    $(document).ready(function(){
        $('#tooltip').tooltip();
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
             
            if( $('#archivo1').val().length > 0 || $('#archivo2').val().length > 0 || $('#archivo3').val().length > 0 ){
                if( validar_file(formulario, [".png",".jpeg",".jpg",".gif",".xls",".xlsx",".doc",".docx",".ppt",".pptx",".pdf",".csv"] ) == true ){
                    // TODO: nada
                }else{
                    return false;
                }       
            }
            if( $('#area_mensaje').val().length < 5 ){
                $('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
                var body = $("html, body");
                body.animate({scrollTop:0}, '500', 'swing', function() {
                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                });
                return false;
            }
            formulario.submit(); 
        });
        $('#archivo1').change(function(){
            $('#archivo_seleccionado1').val($('#archivo1').val());    
        });
        $('#archivo2').change(function(){
            $('#archivo_seleccionado2').val($('#archivo2').val());    
        });
        $('#archivo3').change(function(){
            $('#archivo_seleccionado3').val($('#archivo3').val());    
        });
        $('#btn_seleccionar1').click(function(){
            $('#archivo1').click();
        });
        $('#btn_seleccionar2').click(function(){
            $('#archivo2').click();
        });
        $('#btn_seleccionar3').click(function(){
            $('#archivo3').click();
        });
        $('#comentario').toggle();
        $('#agregar_comentario,#cancelar').click(function(){
            $('#comentario').slideToggle('slow');
            document.getElementById('MensajeVerForm').reset();
            editor.code('');
        });
        if( !isNaN(servicio_id) ){
        	$('.servicioseleccionado').html('Servicio tecnol&oacute;gico seleccionado: <br />');
			$('.servicioseleccionado').append( $('<a>',{"href":"/empresas/servicios/ver/"+servicio_id}).html(servicio_nombre) );
		}	
    });
</script>