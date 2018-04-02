<?php
    /*
     * Autor DIMH@27-08-2014
     * */
     App::uses('CakeEmail', 'Network/Email');
     class TicketsController extends AppController{
        public $uses = array('Ticket','Empresa','Municipio','Departamento','ServicioTecnologico','Mensaje','MensajesAdjunto','MensajesServicio','CriteriosAceptacion','CriteriosCategoria','CriteriosSatisfaccion','CriteriosTicket','Contrato','Persona','Usuario','Correo');
        public $components = array('Session', 'Cookie','Paginator','RequestHandler');
        public $helpers = array('Js','Form','Html','Session','Paginator','Number','Time');
        public $layout = 'default';        
        public $paginate = array(
            'fields' => array('Ticket.*'),
            'limit' => PER_PAGE,
            'order' => array('Ticket.fecha_apertura DESC')
        );
        public $estados = array('abierto'=>'Abierto','cerrado'=>'Cerrado','en espera'=>'En espera','finalizado con exito'=>'Finalizado con &eacute;xito','cancelado por el administrador'=>'Cancelado por el administrador','cancelado por el cliente'=>'Cancelado por el cliente','cancelado por el oferente'=>'Cancelado por el oferente');
        public $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        public $evaluaciones = array('Deficiente','Regular','Bueno','Muy Bueno','Excelente');
        
        public function beforeRender(){
            parent::beforeRender();
            $this->set('menu_activo','tickets');
        }
        
        public function index( $filtro = '' ){
        	
        	$this->Paginator->settings = $this->paginate;

        	$persona= $this->Cookie->read('persona');
        	if( $persona['Usuario']['isadmin'] == 1 ){            
	            $this->set('tickets',$this->Paginator->paginate($this->Ticket,
	                array('Ticket.ficha_proyecto LIKE'=>"%{$filtro}%")
	            ));
	        }else{
	        	$oferente = $this->ticketsOferente();
	        	$cliente = $this->ticketsCliente();
	        	$ids = array_merge($oferente,$cliente);
	        	$ids = array_unique($ids);
	        	
	            $this->set('tickets',$this->Paginator->paginate($this->Ticket,array('Ticket.id'=>$ids)));
	        }
            $this->set('filtro',$filtro);
            $this->set('estados',$this->estados);
            
        }/* fin de funcion index */
        
        public function nuevo(){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'nuevo' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->request->is('post') ){
                // guardar ticket, obtener persona.
                $usuario = $this->Usuario->findByUsuario($this->Cookie->read('usuario'));
                if( array_key_exists('Usuario', $usuario) ){
                    $n = $this->Ticket->find('count');
                    $n += 1;
                    $this->request->data['Ticket']['ficha_proyecto'] = date('dmy') . 'PV' . sprintf('%04d', $n);
                    $this->Ticket->create();
                    if( $this->Ticket->save($this->request->data) ):
                        // guardar mensaje.
                        $this->request->data['Mensaje']['persona_id'] = $usuario['Usuario']['persona_id'];
                        $this->request->data['Mensaje']['ticket_id'] = $this->Ticket->id;
                        $this->Mensaje->create();
                        if( $this->Mensaje->save($this->request->data) ){
                            // si el ticket se creo correctamente entonces enviar email a la empresa solicitante.
                            $this->notificarSolicitante($this->request->data['Ticket']['empresa_id'], $this->request->data,$this->Ticket->id);
                            $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del ticket se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                            $this->redirect(array('action'=>'index'));
                        }// fin de guardar mensaje
                    endif;
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro del ticket. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }// fin de encontrar usuario
            }// fin de request post
            
            $persona = $this->Cookie->read('persona');
            if( $persona['Usuario']['isadmin'] == 0 && is_numeric($persona['Usuario']['empresa_id']) ){
                $this->set('empresas',$this->Empresa->find('list',array('conditions'=>array('Empresa.id'=>$persona['Usuario']['empresa_id']),'fields'=>array('Empresa.id','Empresa.nombre_empresa'),'order'=>array('Empresa.nombre_empresa ASC'))));
            }elseif( $persona['Usuario']['isadmin'] == 1 ){
                $this->set('empresas',$this->Empresa->find('list',array('fields'=>array('Empresa.id','Empresa.nombre_empresa'),'order'=>array('Empresa.nombre_empresa ASC'))));
            }else{
                $this->set('empresas',array());
            }
                
            
            
        }/* fin de funcion nuevo */
        
        public function editar( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'editar' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            $ticket = $this->Ticket->findById($id);
            
            if( $this->request->is('put') ){
				
				if( $this->request->data['Ticket']['estado'] == 'cerrado' || $this->request->data['Ticket']['estado'] == 'finalizado con exito' ){
					$this->request->data['Ticket']['fecha_cierre'] = date('Y-m-d G:i:s');
				}
				
				// si el nuevo estado es 'cerrado', se debe buscar si existe un st seleccionado.
				if( $this->request->data['Ticket']['estado'] == 'cerrado' ){
					$msj = array();
					$mensajes = $this->Mensaje->findAllByTicketId($id);
		        	foreach( $mensajes as $mensaje ){
		        		if( array_key_exists('Mensaje', $mensaje) )
				        	array_push($msj,$mensaje['Mensaje']['id']);
		        	}
		        	if( count($msj) > 0 )
			        	$n = $this->MensajesServicio->find('count',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_seleccionado'=>1))); 
					else
						$n = 0;
					
					if( $n != 1 ){
						$this->request->data['Ticket']['estado'] = $ticket['Ticket']['estado'];
						unset($this->request->data['Ticket']['fecha_cierre']);
					}
				}
				// si el nuevo estado es 'finalizado con exito', se debe buscar si existe un contrato para el ticket.
				if( $this->request->data['Ticket']['estado'] == 'finalizado con exito' ){
			        $n = $this->Contrato->find('count',array('conditions'=>array('Contrato.ticket_id'=>$id))); 
					if( $n != 1 ){
						$this->request->data['Ticket']['estado'] = $ticket['Ticket']['estado'];
						unset($this->request->data['Ticket']['fecha_cierre']);
					}	
				}
				
                if( $this->Ticket->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del ticket se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'ver',$id));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro del ticket. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }
            }// fin de put
            
            $ticket = $this->Ticket->findById($id);
            if( !array_key_exists('Ticket', $ticket) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            $this->request->data = $ticket;
            $this->set('empresas',$this->Empresa->find('list',array('fields'=>array('Empresa.id','Empresa.nombre_empresa'),'order'=>array('Empresa.nombre_empresa ASC'))));
            $this->set('estados',$this->estados);
            
        }/* fin de funcion editar */    
        
        public function ver( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'ver' ) === FALSE || $this->puedeVer($id) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') ):
            	
            	if( $this->puedeComentar( $this->request->data['Mensaje']['ticket_id']) == FALSE ){
            		$this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el comentario debido que no tiene permisos o el estado del ticket no es abierto o en espera.','default',array('class'=>'alert alert-danger'));
	            	$this->redirect(array('action'=>'ver',$id));
            	}
            	
                // asignar fecha del mensaje
                $this->request->data['Mensaje']['fecha_mensaje'] = date('Y-m-d G:i:s');
                $this->Mensaje->create();
                if( $this->Mensaje->save($this->request->data) ){
                    
                    $this->notificarMensaje($this->request->data);
                    // guardar adjuntos si los hubiera
                    $this->guardarAdjuntos($this->Mensaje->id);
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El comentario se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'ver',$id));    
                } // fin de guardar nuevo mensaje 
                else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el comentario. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }
            endif;
            //____________________________________________________________________________________________
            $ticket = $this->Ticket->findById($id);
            if( !array_key_exists('Ticket', $ticket) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            $this->set('ticket',$ticket);
            $this->set('mensajes',$this->Mensaje->find('all',array(
                    'recursive'=>2,
                    'fields'=>array('Mensaje.*','Persona.*','Empresa.*','Usuario.usuario'),
                    'conditions'=>array('Mensaje.ticket_id'=>$id),
                    'joins'=>array(
                        array(
                            'alias'=>'Persona',
                            'table'=>'personas',
                            'type'=>'INNER',
                            'conditions'=>'Mensaje.persona_id = Persona.id'
                        ),
                        array(
                            'alias'=>'Usuario',
                            'table'=>'usuarios',
                            'type'=>'LEFT',
                            'conditions'=>'Persona.id = Usuario.persona_id'
                        ),
                        array(
                            'alias'=>'Empresa',
                            'table'=>'empresas',
                            'type'=>'LEFT',
                            'conditions'=>'Usuario.empresa_id = Empresa.id'
                        )
                    ),
                    'order'=>array('Mensaje.fecha_mensaje DESC')
                ))
            );
            $this->set('usuario',$this->Usuario->findByUsuario($this->Cookie->read('usuario')));
            $this->set('empresa',$this->Empresa->findById($ticket['Ticket']['empresa_id']));
            $this->set('contrato',$this->Contrato->find('count',array('conditions'=>array('Contrato.ticket_id'=>$id))));
            $this->set('estados',$this->estados);
            $this->set('personac',$this->Cookie->read('persona'));
            
        }/* fin de funcion editar */
        
        public function imprimir_ticket( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'imprimir_ticket' ) === FALSE && $this->checkPermissions( 'reporte', 'tickets' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            $ticket = $this->Ticket->findById($id);
            if( !array_key_exists('Ticket', $ticket) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            $this->set('ticket',$ticket);
            $this->set('mensajes',$this->Mensaje->find('all',array(
                    'recursive'=>2,
                    'fields'=>array('Mensaje.*','Persona.*','Empresa.*','Usuario.usuario'),
                    'conditions'=>array('Mensaje.ticket_id'=>$id),
                    'joins'=>array(
                        array(
                            'alias'=>'Persona',
                            'table'=>'personas',
                            'type'=>'INNER',
                            'conditions'=>'Mensaje.persona_id = Persona.id'
                        ),
                        array(
                            'alias'=>'Usuario',
                            'table'=>'usuarios',
                            'type'=>'LEFT',
                            'conditions'=>'Persona.id = Usuario.persona_id'
                        ),
                        array(
                            'alias'=>'Empresa',
                            'table'=>'empresas',
                            'type'=>'LEFT',
                            'conditions'=>'Usuario.empresa_id = Empresa.id'
                        )
                    ),
                    'order'=>array('Mensaje.fecha_mensaje DESC')
                ))
            );
            $this->set('usuario',$this->Usuario->findByUsuario($this->Cookie->read('usuario')));
            $this->set('empresa',$this->Empresa->findById($ticket['Ticket']['empresa_id']));
            $this->set('estados',$this->estados);
            $this->layout = 'impresion';
            
        }/* fin de funcion imprimir_ticket */
        
        public function imprimir( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'imprimir' ) === FALSE && $this->checkPermissions( 'reporte', 'tickets' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            $this->set('tickets',$this->Ticket->find('all',array(
                'fields' => array('Ticket.*'),
                'conditions' => array('OR'=>array('Ticket.ficha_proyecto LIKE'=>"%{$filtro}%")),
                'order' => array('Ticket.fecha_apertura DESC')
            ))
            );
            $this->set('tickets',$this->Paginator->paginate($this->Ticket,
                array('OR'=>array('Ticket.ficha_proyecto LIKE'=>"%{$filtro}%")
                )
            ));
            $this->set('filtro',$filtro);
            $this->set('estados',$this->estados);
            $this->layout = 'impresion';
            
        }/* fin de funcion imprimir */
        
        public function eliminar( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'eliminar' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            // verificar que no tenga mensajes y que el ticket no este cerrado.
            if( $this->CriteriosTicket->find('count',array('conditions'=>array('CriteriosTicket.ticket_id'=>$id))) == 0 && 
                $this->Contrato->find('count',array('conditions'=>array('Contrato.ticket_id'=>$id))) == 0 &&
                $this->Mensaje->find('count',array('conditions'=>array('Mensaje.ticket_id'=>$id))) == 1){
                    // borrar mensaje inicial.
                    $this->Mensaje->deleteAll( array('ticket_id'=>$id) );
                    if( $this->Ticket->delete($id) ){
                        $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del ticket se elimin&oacute; satisfactoriamente.','default',array('class'=>'alert alert-success'));    
                    }else{
                        $this->Session->setFlash('<strong>Error:</strong> El registro del ticket no pudo ser eliminado debido a que existen comentarios &oacute; criterios relacionados a el.','default',array('class'=>'alert alert-danger'));
                    }
            }else{
                $this->Session->setFlash('<strong>Error:</strong> El registro del ticket no pudo ser eliminado debido a que existen comentarios &oacute; criterios relacionados a el.','default',array('class'=>'alert alert-danger'));
            }
            $this->redirect(array('action'=>'index')); 
        }/* fin de funcion eliminar */
        
        public function eliminar_mensaje( $id = '', $ticket_id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'eliminar_mensaje' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del mensaje.','default',array('class'=>'alert alert-danger'));
                if( is_numeric($ticket_id) )
                    $this->redirect(array('action'=>'ver',$ticket_id));
                else
                    $this->redirect(array('action'=>'index'));
            }

            // si es el primer mensaje no se puede borrar.
            $primer_mensaje = $this->Mensaje->find('first',array('conditions'=>array('Mensaje.ticket_id'=>$ticket_id),'limit'=>1,'order'=>array('Mensaje.fecha_mensaje ASC')));
            if( array_key_exists('Mensaje', $primer_mensaje) && $id == $primer_mensaje['Mensaje']['id'] ){
                
                $this->Session->setFlash('<strong>Error:</strong> Este comentario no puede ser eliminado.','default',array('class'=>'alert alert-danger'));
                if( is_numeric($ticket_id) )
                    $this->redirect(array('action'=>'ver',$ticket_id));
                else
                    $this->redirect(array('action'=>'index'));
            }
            
            // borrar adjuntos primero si los hubiera
            $directorio = WWW_ROOT . 'files' . DS . 'adjuntos' . DS . 'mensaje_' . $id;
            if( is_dir($directorio) ){
                $files = array_diff(scandir($directorio), array('.','..')); 
                foreach ($files as $file) { 
                  unlink("$directorio/$file"); 
                } 
                rmdir($directorio);
            }
            $this->MensajesAdjunto->deleteAll(array('mensaje_id'=>$id));
            $this->MensajesServicio->deleteAll(array('mensaje_id'=>$id));
            // borrar mensaje
            if( $this->Mensaje->delete($id) ){
                $this->Session->setFlash('<strong>&Eacute;xito!</strong> El comentario se elimin&oacute; satisfactoriamente.','default',array('class'=>'alert alert-success'));
                $this->redirect(array('action'=>'ver',$ticket_id));
            }else{
                $this->Session->setFlash('<strong>Error:</strong> No se pudo eliminar el registro del comentario.','default',array('class'=>'alert alert-danger'));
                if( is_numeric($ticket_id) )
                    $this->redirect(array('action'=>'ver',$ticket_id));
                else
                    $this->redirect(array('action'=>'index'));
            } 
            
        }/* fin de funcion eliminar_mensaje */
        
        public function adjuntar_servicio(){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'adjuntar_servicio' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        
        	$resultado = array('codigo'=>'500','class'=>'alert alert-danger','mensaje'=>'<strong>Error:</strong> No se pudo agregar el servicio tecnol&oacute;gico al ticket. Por favor intente nuevamente');
			if( array_key_exists('Mensaje', $_POST) && array_key_exists('MensajesServicio', $_POST) ){
				$this->Mensaje->create();
				$_POST['Mensaje']['fecha_mensaje'] = date('Y-m-d G:i:s');
				$_POST['Mensaje']['mensaje'] = html_entity_decode($_POST['Mensaje']['mensaje']);
				if( $this->Mensaje->save($_POST) ):
                    // notificar cliente del servicio sugerido.
                    $this->notificarClienteServicio($_POST);
					// guardar el servicio en el comentario
					$this->MensajesServicio->create();
					$_POST['MensajesServicio']['mensaje_id'] = $this->Mensaje->id;
					if( $this->MensajesServicio->save($_POST) ){
					    // notificar al oferente que su servicio fue sugerido.
					    $this->notificarOferenteServicio($_POST);
						$resultado = array('codigo'=>'200','class'=>'alert alert-success','mensaje'=>'<strong>&Eacute;xito!</strong> El servicio tecnol&oacute;gico se agreg&oacute; al ticket satisfactoriamente.');			
					}
				endif;
			}
        	$this->set(array('resultado'=>$resultado,'_serialize'=>'resultado'));
            
        }/* fin de funcion adjuntar_servicio */
        
        public function servicio_agregado(){
	        
	        $n = 0;
	        $msj = array();
	        if( isset($_POST['servicio_id']) && isset($_POST['ticket_id']) ):
	        	$mensajes = $this->Mensaje->findAllByTicketId($_POST['ticket_id']);
	        	foreach( $mensajes as $mensaje ){
	        		if( array_key_exists('Mensaje', $mensaje) )
			        	array_push($msj,$mensaje['Mensaje']['id']);
	        	}
	        	$n = $this->MensajesServicio->find('count',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_id'=>$_POST['servicio_id']))); 
	        	//$n = $this->MensajesServicio->query('SELECT count(id) FROM mensajes_servicios WHERE mensaje_id IN('.implode(',',$msj).') AND servicio_id = '.$_POST['servicio_id']);   
	        endif;
	        
	        $this->set(array('resultado'=>array('n_servicios'=>$n),'_serialize'=>'resultado'));
	        
        }/* fin de funcion servicio_agregado */
        
        public function seleccionar_servicio( $ticket_id, $mensaje_servicio_id ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'seleccionar_servicio' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        	
	        $sticket = $this->Ticket->findById($ticket_id);
	        if( (is_numeric($ticket_id) && is_numeric($mensaje_servicio_id)) && $sticket['Ticket']['estado'] != 'cerrado' && $sticket['Ticket']['estado'] != 'finalizado con exito' ){
		        // obtener todos los mensajes del ticket
		        $msj = array();
		        $mensajes = $this->Mensaje->findAllByTicketId($ticket_id);
		        foreach( $mensajes as $mensaje ){
	        		if( array_key_exists('Mensaje', $mensaje) )
			        	array_push($msj,$mensaje['Mensaje']['id']);
	        	}
	        	// actualizar todos los servicios sugeridos a servicio_seleccionado = 0
	        	$this->MensajesServicio->query('UPDATE mensajes_servicios SET servicio_seleccionado = 0 WHERE mensaje_id IN('.implode(',', $msj).');');
	        	$this->MensajesServicio->save(array('MensajesServicio'=>array('id'=>$mensaje_servicio_id,'servicio_seleccionado'=>1)));
	        	$this->Session->setFlash('<strong>&Eacute;xito!</strong> El servicio tecnol&oacute;gico se seleccion&oacute; satisfactoriamente.','default',array('class'=>'alert alert-success'));
	        }else{
		        $this->Session->setFlash('<strong>Error:</strong> No se pudo seleccionar el servicio tecnol&oacute;gico. Aseg&uacute;rese que el ticket tenga el estado abierto o en espera.','default',array('class'=>'alert alert-danger'));
	        }
	        $this->redirect(array('action'=>'ver',$ticket_id));
	        
        }/* fin de funcion seleccionar_servicio */
        
        public function criterios( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'criterios' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        	
        	if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') ):
            	if( is_array($this->request->data['criterios']) ){
            		foreach( $this->request->data['criterios'] as $criterio ):
		            	$this->CriteriosTicket->create();
		            	$this->CriteriosTicket->save($criterio);
		            endforeach;
		            $this->Session->setFlash('<strong>&Eacute;xito!</strong> Sus evaluaciones se guardaron satisfactoriamente.','default',array('class'=>'alert alert-success'));
					$this->redirect(array('action'=>'ver',$id));
				}else{
					$this->Session->setFlash('<strong>Error:</strong> No se pudo guardar sus evaluaciones.','default',array('class'=>'alert alert-danger'));
				}
            endif;
            
            $ticket = $this->Ticket->findById($id);
            $this->set('ticket',$ticket);
            $this->set('ticket_id',$id);
            $this->set('persona',$this->Usuario->findByUsuario($this->Cookie->read('usuario')));
            //si el usuario actual es oferente o cliente y si el ticket se termino con exito
            if( $ticket['Ticket']['estado'] == 'finalizado con exito' ){
	        	// si es cliente.
				$c_cliente = $this->Empresa->find('count',array(
					'conditions' => array('Empresa.id'=>$ticket['Ticket']['empresa_id'],'Usuario.usuario'=>$this->Cookie->read('usuario')),
					'joins' => array(
						array(
							'alias' => 'Usuario',
							'table' => 'usuarios',
							'type' => 'INNER',
							'conditions' => 'Empresa.id = Usuario.empresa_id'
						),
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				)); 
				if($c_cliente == 1){// es cliente
					//primero revisar si el cliente ya lleno el formulario
					$n = $this->CriteriosTicket->find('count',array(
						'conditions' => array('CriteriosTicket.ticket_id'=>$id,'CriteriosSatisfaccion.criterios_categorias_id'=>1),
						'joins' => array(
							array(
								'alias' => 'CriteriosSatisfaccion',
								'table' => 'criterios_satisfaccion',
								'type' => 'INNER',
								'conditions' => 'CriteriosSatisfaccion.id = CriteriosTicket.criterio_id'
							)
						)
					));
					if( $n == 0 )
						$this->set('criterios',$this->CriteriosSatisfaccion->findAllByCriteriosCategoriasId(1));
					else{
						$this->Session->setFlash('<strong>Error:</strong> El formulario de criterios de satisfacci&oacute;n ya ha sido completado por el solicitante.','default',array('class'=>'alert alert-danger'));
						$this->redirect(array('action'=>'ver',$id));
					}
				}else{
					//-------------------
					$msj = array();
			        $mensajes = $this->Mensaje->findAllByTicketId($id);
			        foreach( $mensajes as $mensaje ){
		        		if( array_key_exists('Mensaje', $mensaje) )
				        	array_push($msj,$mensaje['Mensaje']['id']);
		        	}
			        $servicio = $this->MensajesServicio->find('first',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_seleccionado'=>1))); 	
					// mediante el servicio buscar el registro y la empresa oferente.
					if( array_key_exists('MensajesServicio', $servicio) ){
						$oferente = $this->ServicioTecnologico->find('first',array(
							'fields' => array('Oferente.*','ServicioTecnologico.*','Municipio.*','Departamento.*'),
							'conditions' => array('ServicioTecnologico.id'=>$servicio['MensajesServicio']['servicio_id']),
							'joins' => array(
								array(
									'alias' => 'Oferente',
									'table' => 'empresas',
									'type' => 'INNER',
									'conditions' => 'Oferente.id = ServicioTecnologico.empresa_id'
								),
								array(
									'alias' => 'Municipio',
									'table' => 'municipios',
									'type' => 'INNER',
									'conditions' => 'Oferente.direccion_municipio = Municipio.id'
								),
								array(
									'alias' => 'Departamento',
									'table' => 'departamentos',
									'type' => 'INNER',
									'conditions' => 'Municipio.departamento = Departamento.id'
								)
							)
						));
						if( array_key_exists('Oferente', $oferente) ){
							$contactos_oferente = $this->Empresa->find('all',array(
								'fields' => array('Usuario.*'),
								'conditions' => array('Empresa.id'=>$oferente['Oferente']['id']),
								'joins' => array(
									array(
										'alias' => 'Usuario',
										'table' => 'usuarios',
										'type' => 'INNER',
										'conditions' => 'Empresa.id = Usuario.empresa_id'
									),
									array(
										'alias' => 'Persona',
										'table' => 'personas',
										'type' => 'INNER',
										'conditions' => 'Usuario.persona_id = Persona.id'
									)
								)
							));
							
						}// fin de seleccionar contactos
						$cc = array();
						foreach($contactos_oferente as $con){
							array_push($cc, $con['Usuario']['usuario']);
						}
						//if( array_search($this->Cookie->read('usuario'), $cc) !== FALSE ){
							//primero revisar si el oferente ya lleno el formulario
							$n = $this->CriteriosTicket->find('count',array(
								'conditions' => array('CriteriosTicket.ticket_id'=>$id,'CriteriosSatisfaccion.criterios_categorias_id'=>2),
								'joins' => array(
									array(
										'alias' => 'CriteriosSatisfaccion',
										'table' => 'criterios_satisfaccion',
										'type' => 'INNER',
										'conditions' => 'CriteriosSatisfaccion.id = CriteriosTicket.criterio_id'
									)
								)
							));
							if( $n == 0 )
								$this->set('criterios',$this->CriteriosSatisfaccion->findAllByCriteriosCategoriasId(2));
							else{
								$this->Session->setFlash('<strong>Error:</strong> El formulario de criterios de satisfacci&oacute;n ya ha sido completado por el oferente.','default',array('class'=>'alert alert-danger'));
								$this->redirect(array('action'=>'ver',$id));
							}
						/*}else{
							$this->Session->setFlash('<strong>Error:</strong> El formulario de criterios de satisfacci&oacute;n son exclusivos de los usuarios solicitantes y oferentes.','default',array('class'=>'alert alert-danger'));
							$this->redirect(array('action'=>'ver',$id));
						}*/
					}
					//-------------------
					
				}
            }// fin de finalizado con exito.
            
            
        }/* fin de funcion criterios */
        
        public function imprimir_contrato( $ticket_id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'ticket', 'imprimir_contrato' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        
        	if( !is_numeric($ticket_id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            $ticket = $this->Ticket->find('first',array(
            	'fields'=> array('Cliente.*','Ticket.*','Municipio.*','Departamento.*'),
            	'conditions' => array('Ticket.id'=>$ticket_id),
            	'joins' => array(
            		array(
            			'alias' => 'Cliente',
            			'table' => 'empresas',
            			'type' => 'INNER',
            			'conditions' => 'Cliente.id = Ticket.empresa_id'
            		),
					array(
						'alias' => 'Municipio',
						'table' => 'municipios',
						'type' => 'INNER',
						'conditions' => 'Cliente.direccion_municipio = Municipio.id'
					),
					array(
						'alias' => 'Departamento',
						'table' => 'departamentos',
						'type' => 'INNER',
						'conditions' => 'Municipio.departamento = Departamento.id'
					)
            	)
            ));
            
            if( array_key_exists('Cliente', $ticket) ){
				$contactos_cliente = $this->Empresa->find('all',array(
					'fields' => array('Usuario.*','Persona.*'),
					'conditions' => array('Empresa.id'=>$ticket['Cliente']['id']),
					'joins' => array(
						array(
							'alias' => 'Usuario',
							'table' => 'usuarios',
							'type' => 'INNER',
							'conditions' => 'Empresa.id = Usuario.empresa_id'
						),
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				));
			}
			$this->set('ticket',$ticket);
			$this->set('contactos_cliente',$contactos_cliente);
            
            // buscar oferente
            $msj = array();
	        $mensajes = $this->Mensaje->findAllByTicketId($ticket_id);
	        foreach( $mensajes as $mensaje ){
        		if( array_key_exists('Mensaje', $mensaje) )
		        	array_push($msj,$mensaje['Mensaje']['id']);
        	}
	        $servicio = $this->MensajesServicio->find('first',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_seleccionado'=>1))); 	
			// mediante el servicio buscar el registro y la empresa oferente.
			if( array_key_exists('MensajesServicio', $servicio) ){
				$oferente = $this->ServicioTecnologico->find('first',array(
					'fields' => array('Oferente.*','ServicioTecnologico.*','Municipio.*','Departamento.*'),
					'conditions' => array('ServicioTecnologico.id'=>$servicio['MensajesServicio']['servicio_id']),
					'joins' => array(
						array(
							'alias' => 'Oferente',
							'table' => 'empresas',
							'type' => 'INNER',
							'conditions' => 'Oferente.id = ServicioTecnologico.empresa_id'
						),
						array(
							'alias' => 'Municipio',
							'table' => 'municipios',
							'type' => 'INNER',
							'conditions' => 'Oferente.direccion_municipio = Municipio.id'
						),
						array(
							'alias' => 'Departamento',
							'table' => 'departamentos',
							'type' => 'INNER',
							'conditions' => 'Municipio.departamento = Departamento.id'
						)
					)
				));
				
				if( array_key_exists('Oferente', $oferente) ){
					$contactos_oferente = $this->Empresa->find('all',array(
						'fields' => array('Usuario.*','Persona.*'),
						'conditions' => array('Empresa.id'=>$oferente['Oferente']['id']),
						'joins' => array(
							array(
								'alias' => 'Usuario',
								'table' => 'usuarios',
								'type' => 'INNER',
								'conditions' => 'Empresa.id = Usuario.empresa_id'
							),
							array(
								'alias' => 'Persona',
								'table' => 'personas',
								'type' => 'INNER',
								'conditions' => 'Usuario.persona_id = Persona.id'
							)
						)
					));
				}
				
				$this->set('oferente',$oferente);
				$this->set('contactos_oferente',$contactos_oferente);
				
				// encontrar el registro del administrador
				$this->set('persona_administrador',$this->Usuario->find('first',array(
					'fields' => array('Usuario.*','Persona.*'),
					'conditions' => array('Usuario.usuario'=>$this->Cookie->read('usuario')),
					'joins' => array(
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				)));
				
			}// fin de buscar servicio seleccionado
			$this->set('contrato',$this->Contrato->findByTicketId($ticket_id));
			$this->set('meses',$this->meses);
			$this->layout = 'impresion';
				
        }/* fin de funcion contrato */
        
        public function contrato( $ticket_id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'contrato' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        
        	if( !is_numeric($ticket_id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') || $this->request->is('put') ){
	            if($this->request->is('post'))$this->Contrato->create();
	            $this->request->data['Contrato']['fecha_contrato'] = date('Y-m-d G:i:s');
	            $this->request->data['Contrato']['fecha_inicio'] = date('Y-m-d',strtotime( str_replace('/', '-',$this->request->data['Contrato']['fecha_inicio']) ));
	            if( $this->Contrato->save($this->request->data) ){
	            	// guardar el monto acordado
	            	$this->request->data['Ticket']['id'] = $this->request->data['Contrato']['ticket_id']; 
		            $this->Ticket->save($this->request->data);
		            $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del contrato se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'ver',$this->request->data['Contrato']['ticket_id']));
	            }else{
		            $this->Session->setFlash('<strong>Error:</strong> El registro del contrato no se pudo guardar. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
	            }
            }
            $this->request->data = $this->Contrato->findByTicketId($ticket_id);
            
            $ticket = $this->Ticket->find('first',array(
            	'fields'=> array('Cliente.*','Ticket.*'),
            	'conditions' => array('Ticket.id'=>$ticket_id),
            	'joins' => array(
            		array(
            			'alias' => 'Cliente',
            			'table' => 'empresas',
            			'type' => 'INNER',
            			'conditions' => 'Cliente.id = Ticket.empresa_id'
            		)
            	)
            ));
            
            if( array_key_exists('Cliente', $ticket) ){
				$contactos_cliente = $this->Empresa->find('all',array(
					'fields' => array('Persona.*'),
					'conditions' => array('Empresa.id'=>$ticket['Cliente']['id']),
					'joins' => array(
						array(
							'alias' => 'Usuario',
							'table' => 'usuarios',
							'type' => 'INNER',
							'conditions' => 'Empresa.id = Usuario.empresa_id'
						),
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				));
				$cc = array();
				foreach($contactos_cliente as $con){
					$nombre = $con['Persona']['primer_nombre']. ' ' . $con['Persona']['segundo_nombre']. ' ' . $con['Persona']['primer_apellido']. ' ' . $con['Persona']['segundo_apellido'];
					$cc[$nombre] = $nombre;
				}
			}
			$this->set('ticket',$ticket);
			$this->set('contactos_cliente',$cc);
            
            // buscar oferente
            $msj = array();
	        $mensajes = $this->Mensaje->findAllByTicketId($ticket_id);
	        foreach( $mensajes as $mensaje ){
        		if( array_key_exists('Mensaje', $mensaje) )
		        	array_push($msj,$mensaje['Mensaje']['id']);
        	}
	        $servicio = $this->MensajesServicio->find('first',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_seleccionado'=>1))); 	
			// mediante el servicio buscar el registro y la empresa oferente.
			if( array_key_exists('MensajesServicio', $servicio) ){
				$oferente = $this->ServicioTecnologico->find('first',array(
					'fields' => array('Oferente.*','ServicioTecnologico.*'),
					'conditions' => array('ServicioTecnologico.id'=>$servicio['MensajesServicio']['servicio_id']),
					'joins' => array(
						array(
							'alias' => 'Oferente',
							'table' => 'empresas',
							'type' => 'INNER',
							'conditions' => 'Oferente.id = ServicioTecnologico.empresa_id'
						)
					)
				));
				
				if( array_key_exists('Oferente', $oferente) ){
					$contactos_oferente = $this->Empresa->find('all',array(
						'fields' => array('Persona.*'),
						'conditions' => array('Empresa.id'=>$oferente['Oferente']['id']),
						'joins' => array(
							array(
								'alias' => 'Usuario',
								'table' => 'usuarios',
								'type' => 'INNER',
								'conditions' => 'Empresa.id = Usuario.empresa_id'
							),
							array(
								'alias' => 'Persona',
								'table' => 'personas',
								'type' => 'INNER',
								'conditions' => 'Usuario.persona_id = Persona.id'
							)
						)
					));
					$cc = array();
					foreach($contactos_oferente as $con){
						$nombre = $con['Persona']['primer_nombre']. ' ' . $con['Persona']['segundo_nombre']. ' ' . $con['Persona']['primer_apellido']. ' ' . $con['Persona']['segundo_apellido'];
						$cc[$nombre] = $nombre;
					}
				}
				
				$this->set('oferente',$oferente);
				$this->set('contactos_oferente',$cc);
				
				// encontrar el registro del administrador
				$persona_administrador = $this->Usuario->find('all',array(
					'fields' => array('Persona.*'),
					'conditions' => array('Usuario.isadmin'=>1),
					'joins' => array(
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				));
				$cc = array();
				foreach($persona_administrador as $con){
					$nombre = $con['Persona']['primer_nombre']. ' ' . $con['Persona']['segundo_nombre']. ' ' . $con['Persona']['primer_apellido']. ' ' . $con['Persona']['segundo_apellido'];
					$cc[$nombre] = $nombre;
				}
				$this->set('persona_administrador',$cc);
				
			}// fin de buscar servicio seleccionado
				
        }/* fin de funcion contrato */
        
        public function notificarSolicitante( $empresa_id, $data, $ticket_id ){
            
            $persona = $this->Cookie->read('persona');
            if( $persona['Usuario']['isadmin'] == 0 ){ // un contacto creo el ticket, notificar al administrador
                $personas = $this->Usuario->find('all',
                    array(
                        'conditions'=>array('Usuario.isadmin'=>1),
                        'fields'=>array('Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico','Persona.correo_electronico_secundario'),
                        'joins' => array(
                            array(
                                'alias' => 'Persona',
                                'table' => 'personas',
                                'type' => 'INNER',
                                'conditions' => 'Persona.id = Usuario.persona_id'
                            )
                        ),
                        'order' => array('Persona.primer_nombre ASC','Persona.primer_apellido ASC')                    
                    )
                 );     
                  
            }else{ // el administrador creó el ticket. notificar a todos los contactos de la empresa.
                $personas = $this->Empresa->find('all',
                    array(
                        'conditions'=>array('Empresa.id'=>$empresa_id),
                        'fields'=>array('Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico','Persona.correo_electronico_secundario'),
                        'joins' => array(
                            array(
                                'alias' => 'Usuario',
                                'table' => 'usuarios',
                                'type' => 'INNER',
                                'conditions' => 'Usuario.empresa_id = Empresa.id'
                            ),
                            array(
                                'alias' => 'Persona',
                                'table' => 'personas',
                                'type' => 'INNER',
                                'conditions' => 'Persona.id = Usuario.persona_id'
                            )
                        ),
                        'order' => array('Persona.primer_nombre ASC','Persona.primer_apellido ASC')                    
                    )
                 );
                 
            }
             $nombre = $persona['Persona']['primer_nombre'] . ' ' . $persona['Persona']['primer_apellido'];
             $url = Router::fullbaseUrl();
             foreach( $personas as $persona ):
                // enviar correo.
                $email = $persona['Persona']['correo_electronico'];
                $mensaje = $this->Correo->nuevo_ticket;
                $mensaje = sprintf($mensaje,$nombre,$url,$ticket_id,$data['Ticket']['ficha_proyecto'],$data['Mensaje']['mensaje']);
    
                $Email = new CakeEmail('smtp');
                $Email->emailFormat('html')
                    ->to($email)
                    ->subject('Nuevo ticket')
                    ->send($mensaje);
             endforeach;
             return TRUE;

        }/* fin de funcion notificarSolicitante */
        
        public function notificarMensaje( $data ){
            
            $autor = $this->Cookie->read('persona');
            $ticket = $this->Ticket->findById($data['Mensaje']['ticket_id']);
            $personas = $this->personasTicket($data['Mensaje']['ticket_id']);
            $ficha_proyecto = $ticket['Ticket']['ficha_proyecto'];
            $url = Router::fullbaseUrl();
            $autor = $autor['Persona']['primer_nombre'] . ' ' . $autor['Persona']['primer_apellido'];
            $ticket_id = $data['Mensaje']['ticket_id'];
            foreach( $personas as $persona ):
                // enviar correo
                $nombre = $persona['primer_nombre'] . ' ' . $persona['primer_apellido'];
                $email = $persona['correo_electronico'];
                $mensaje = $this->Correo->nuevo_mensaje;
                $mensaje = sprintf($mensaje,$nombre,$autor,$url,$ticket_id,$ficha_proyecto,$data['Mensaje']['mensaje']);
    
                $Email = new CakeEmail('smtp');
                $Email->emailFormat('html')
                    ->to($email)
                    ->subject('Nuevo comentario en ticket: ' . $ficha_proyecto)
                    ->send($mensaje);
             endforeach;
             return TRUE;
            
        }/* fin de funcion notificarMensaje */
        
        public function notificarClienteServicio( $data ){
            
            $ticket = $this->Ticket->findById($data['Mensaje']['ticket_id']);
            $clientes = $this->Persona->find('all',array(
                'fields'=>array('DISTINCT Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico'),
                'conditions'=>array('Ticket.id'=>$data['Mensaje']['ticket_id']),
                'joins'=>array(
                    array(
                        'alias'=>'Mensaje',
                        'table'=>'mensajes',
                        'type'=>'INNER',
                        'conditions'=>'Persona.id = Mensaje.persona_id'
                    ),
                    array(
                        'alias'=>'Usuario',
                        'table'=>'usuarios',
                        'type'=>'INNER',
                        'conditions'=>'Persona.id = Usuario.persona_id'
                    ),
                    array(
                        'alias'=>'Ticket',
                        'table'=>'tickets',
                        'type'=>'INNER',
                        'conditions'=>'Usuario.empresa_id = Ticket.empresa_id'
                    )
                )
            ));   
            $servicio = $this->ServicioTecnologico->findById($data['MensajesServicio']['servicio_id']);
            $nombre_servicio = $servicio['ServicioTecnologico']['nombre_servicio'];
            $autor = $this->Cookie->read('persona'); 
            $ficha_proyecto = $ticket['Ticket']['ficha_proyecto'];
            $url = Router::fullbaseUrl();
            $autor = $autor['Persona']['primer_nombre'] . ' ' . $autor['Persona']['primer_apellido'];
            $ticket_id = $data['Mensaje']['ticket_id'];
            foreach( $clientes as $cliente ):
                // enviar correo
                $nombre = $cliente['Persona']['primer_nombre'] . ' ' . $cliente['Persona']['primer_apellido'];
                $email = $cliente['Persona']['correo_electronico'];
                $mensaje = $this->Correo->servicio_sugerido_cliente;
                $mensaje = sprintf($mensaje,$nombre,$autor,$nombre_servicio,$url,$ticket_id,$ficha_proyecto,$data['Mensaje']['mensaje']);
    
                $Email = new CakeEmail('smtp');
                $Email->emailFormat('html')
                    ->to($email)
                    ->subject('Servicio Tecnológico sugerido en ticket: ' . $ficha_proyecto)
                    ->send($mensaje);
             endforeach;
             return TRUE;
            
        }/* fin de notificarClienteServicio */
        
        public function notificarOferenteServicio( $data ){
            $ticket = $this->Ticket->findById($data['Mensaje']['ticket_id']);
            $oferentes = $this->ServicioTecnologico->find('all',array(
                'fields'=>array('DISTINCT Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico'),
                'conditions'=>array('ServicioTecnologico.id'=>$data['MensajesServicio']['servicio_id']),
                'joins'=>array(
                    array(
                        'alias'=>'Empresa',
                        'table'=>'empresas',
                        'type'=>'INNER',
                        'conditions'=>'Empresa.id = ServicioTecnologico.empresa_id' 
                    ),
                    array(
                        'alias'=>'Usuario',
                        'table'=>'usuarios',
                        'type'=>'INNER',
                        'conditions'=>'Empresa.id = Usuario.empresa_id'
                    ),
                    array(
                        'alias'=>'Persona',
                        'table'=>'personas',
                        'type'=>'INNER',
                        'conditions'=>'Usuario.persona_id = Persona.id'
                    )
                )
            ));
            $servicio = $this->ServicioTecnologico->findById($data['MensajesServicio']['servicio_id']);
            $nombre_servicio = $servicio['ServicioTecnologico']['nombre_servicio'];
            $autor = $this->Cookie->read('persona'); 
            $ficha_proyecto = $ticket['Ticket']['ficha_proyecto'];
            $url = Router::fullbaseUrl();
            $autor = $autor['Persona']['primer_nombre'] . ' ' . $autor['Persona']['primer_apellido'];
            $ticket_id = $data['Mensaje']['ticket_id'];
            foreach( $oferentes as $oferente ):
                // enviar correo
                $nombre = $oferente['Persona']['primer_nombre'] . ' ' . $oferente['Persona']['primer_apellido'];
                $email = $oferente['Persona']['correo_electronico'];
                $mensaje = $this->Correo->servicio_sugerido_oferente;
                $mensaje = sprintf($mensaje,$nombre,$autor,$nombre_servicio,$url,$ticket_id,$ficha_proyecto,$data['Mensaje']['mensaje']);
    
                $Email = new CakeEmail('smtp');
                $Email->emailFormat('html')
                    ->to($email)
                    ->subject('Servicio Tecnológico sugerido en ticket: ' . $ficha_proyecto)
                    ->send($mensaje);
             endforeach;
             return TRUE;
        }
        
        protected function guardarAdjuntos( $mensaje_id ){
            
            $directorio = WWW_ROOT . 'files' . DS . 'adjuntos' . DS . 'mensaje_' . $mensaje_id;
            
            for( $i=0;$i<3;$i++ ){
                if( $_FILES["archivo{$i}"] && $_FILES["archivo{$i}"]['error'] == UPLOAD_ERR_OK ):
                    if( /*strtolower($archivo['type']) == 'image/jpeg' || 
                        strtolower($archivo['type']) == 'image/gif' || 
                        strtolower($archivo['type']) == 'image/png' || 
                        strtolower($archivo['type']) == 'image/pjpeg'*/ true ){
                        $archivo = $_FILES["archivo{$i}"];    
                        $paths = pathinfo($archivo['name']);     
                        $file_name = $this->slugify($archivo['name']) . '.' . $paths['extension'];
                        //verifico que el folder del mensaje exista y si no lo creo.
                        if( !is_dir($directorio) ){
                            mkdir($directorio);
                        }
                        if( move_uploaded_file($archivo['tmp_name'], $directorio . DS . $file_name) ){
                            // guardar el registro del archivo adjunto
                            $this->MensajesAdjunto->create();
                            $this->MensajesAdjunto->save(
                                array(
                                    'MensajesAdjunto'=>array(
                                        'mensaje_id'=>$mensaje_id,
                                        'nombre_archivo'=>$file_name,
                                        'mime_type'=>$archivo['type'],
                                        'tamano_archivo'=>$archivo['size']
                                    )
                                )
                            );
                            // no return, but keep going.
                        }    
                    }// verificar tipo de archivo.    
                endif;
            }// fin de for
            
        }/* fin de funcion guardarAdjuntos */
        
        public function descargarArchivo( $mensaje_id = '', $nombre_archivo ){
            if( empty($mensaje_id) )return null;
            $path = 'webroot' . 'files' . DS . 'adjuntos' . DS . 'mensaje_' . $mensaje_id . DS . $nombre_archivo;
            $this->response->file($path, array('download' => true, 'name' => $nombre_archivo));
            return $this->response;
        }/* fin de funcion descargarArchivo */
        
        protected function puedeComentar( $id = '' ){
        
	        if( !is_numeric($id) )return FALSE;
	        
	        
	        $ticket = $this->Ticket->findById($id);
	        // si el ticket esta abierto o en espera se puede comentar.
	        if( $ticket['Ticket']['estado'] == 'abierto' || $ticket['Ticket']['estado'] == 'en espera' ){
	        
		        $persona = $this->Cookie->read('persona');
		        // si es admin, return true
		        if( $persona['Usuario']['isadmin'] == 1 )
		        	return TRUE;
		        
		        //si es el cliente. return true
				if( array_key_exists('empresa_id', $persona['Usuario']) && $persona['Usuario']['empresa_id'] > 0 ){
					$n = $this->Ticket->find('count',array(
			        	'conditions'=>array('Empresa.id'=>$persona['Usuario']['empresa_id'],'Ticket.id'=>$id),
			        	'joins'=>array(
			        		array('alias'=>'Empresa','table'=>'empresas','type'=>'INNER','conditions'=>'Empresa.id = Ticket.empresa_id')
			        	)));
			        if( $n == 1 )
			        	return TRUE;
			    }
		    
				// verificar si es oferente en el ticket.
				$tickets_permitidos = $this->ticketsOferente();
				if( in_array($id, $tickets_permitidos) )
					return TRUE;
		    }
	        return FALSE;
	        
        }/* fin de puede comentar */
        
        protected function puedeVer( $id = '' ){
        
	        if( !is_numeric($id) )return FALSE;
	        
	        
	        $ticket = $this->Ticket->findById($id);
	        
	        //if( $ticket['Ticket']['estado'] == 'abierto' || $ticket['Ticket']['estado'] == 'en espera' ){
	        
		        $persona = $this->Cookie->read('persona');
		        // si es admin, return true
		        if( $persona['Usuario']['isadmin'] == 1 )
		        	return TRUE;
		        
		        //si es el cliente. return true
				if( array_key_exists('empresa_id', $persona['Usuario']) && $persona['Usuario']['empresa_id'] > 0 ){
			        if( $this->Ticket->find('count',array(
			        	'conditions'=>array('Empresa.id'=>$persona['Usuario']['empresa_id'],'Ticket.id'=>$id),
			        	'joins'=>array(
			        		array('alias'=>'Empresa','table'=>'empresas','type'=>'INNER','conditions'=>'Empresa.id = Ticket.empresa_id')
			        	))) == 1 )
			        	return TRUE;
			    }
		    
				// verificar si es oferente en el ticket.
				$tickets_permitidos = $this->ticketsOferente();
				if( in_array($id, $tickets_permitidos) )
					return TRUE;
		    //}
	        return FALSE;
	        
        }/* fin de puede ver */
        
        protected function ticketsOferente(){
	        
			$persona = $this->Cookie->read('persona');
            
			if( is_numeric($persona['Usuario']['empresa_id']) ){
		        $tickets = $this->Empresa->find('all',array(
		        	'fields' => array('DISTINCT Ticket.id'),
		        	'conditions' => array('Empresa.id'=>$persona['Usuario']['empresa_id']),
		        	'joins' => array(
		        		array(
		        			'alias' => 'ServicioTecnologico',
		        			'table' => 'servicio_tecnologico',
		        			'type' => 'INNER',
		        			'conditions' => 'ServicioTecnologico.empresa_id = Empresa.id'
		        		),
		        		array(
		        			'alias' => 'MensajesServicio',
		        			'table' => 'mensajes_servicios',
		        			'type' => 'INNER',
		        			'conditions' => 'ServicioTecnologico.id = MensajesServicio.servicio_id'
		        		),
		        		array(
		        			'alias' => 'Mensaje',
		        			'table' => 'mensajes',
		        			'type' => 'INNER',
		        			'conditions' => 'MensajesServicio.mensaje_id = Mensaje.id'
		        		),
		        		array(
		        			'alias' => 'Ticket',
		        			'table' => 'tickets',
		        			'type' => 'INNER',
		        			'conditions' => 'Mensaje.ticket_id = Ticket.id'
		        		)
		        	)
		        ));
		        $tk = array();
		        foreach( $tickets as $ticket ){ array_push($tk,$ticket['Ticket']['id']); }
		        
		        // obtener mis servicios tecnologicos
		        $st = $this->Empresa->find('all',array(
		        	'fields' => array('ServicioTecnologico.id'),
		        	'conditions' => array('Empresa.id'=>$persona['Usuario']['empresa_id']),
		        	'joins' => array(
		        		array(
		        			'alias' => 'ServicioTecnologico',
		        			'table' => 'servicio_tecnologico',
		        			'type' => 'INNER',
		        			'conditions' => 'Empresa.id = ServicioTecnologico.empresa_id'	
		        		)
		        	)
		        ));
		        $servicios = array();
		        foreach( $st as $servicio ){ array_push($servicios,$servicio['ServicioTecnologico']['id']); }
		        
		        // ahora busco los tickets que no tengan st seleccionados y los que lo tengan pero que sea del oferente logueado.
		        //servicios que tienen st seleccionado y es mio.
		        $mis_tickets = $this->Ticket->find('all',array(
		        	'fields'=>array('DISTINCT Ticket.id'),
		        	'conditions' => array('MensajesServicio.servicio_seleccionado'=>1,'MensajesServicio.servicio_id'=>$servicios,'Ticket.id'=>$tk),
					'joins' => array(
						array(
							'alias' => 'Mensaje',
							'table' => 'mensajes',
							'type' => 'INNER',
							'conditions' => 'Ticket.id = Mensaje.ticket_id'
						),
						array(
							'alias' => 'MensajesServicio',
							'table' => 'mensajes_servicios',
							'type' => 'INNER',
							'conditions' => 'Mensaje.id = MensajesServicio.mensaje_id'
						)
					)
		        ));
		        $mt = array();
		        foreach( $mis_tickets as $tick ){ array_push($mt,$tick['Ticket']['id']); }
                //obtener los tickets sin servicio seleccionado.
                foreach( $tk as $t ){
                    if( array_search($t, $mt) !== FALSE ){
                        $key = array_search($t, $mt);
                        unset($tk[$key]);    
                    }
                }
                foreach( $tk as $t ):
                    $msj = array();
                    $mensajes = $this->Mensaje->findAllByTicketId($t);
                    foreach( $mensajes as $mensaje ){
                        if( array_key_exists('Mensaje', $mensaje) )
                            array_push($msj,$mensaje['Mensaje']['id']);
                    }
                    if( count($msj) > 0 )
                        $n = $this->MensajesServicio->find('count',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_seleccionado'=>1))); 
                    else
                        $n = 0;
                    
                    if( $n == 0 ):
                        array_push($mt,$t);
                    endif;    
                endforeach;
		        return $mt;
			}// fin de si empresa_id
			return array(0);
			
        }/* fin de ticketsOferente */
        
        protected function ticketsCliente(){
        
        	$persona = $this->Cookie->read('persona');
	        //si es el cliente. return true
			if( array_key_exists('empresa_id', $persona['Usuario']) && $persona['Usuario']['empresa_id'] > 0 ){
		        $tickets = $this->Ticket->find('all',array(
		        	'fields' => array('Ticket.id'),
		        	'conditions'=>array('Empresa.id'=>$persona['Usuario']['empresa_id']),
		        	'joins'=>array(
		        		array('alias'=>'Empresa','table'=>'empresas','type'=>'INNER','conditions'=>'Empresa.id = Ticket.empresa_id'),	
				)));
				$tk = array();
				foreach( $tickets as $t ){ array_push($tk,$t['Ticket']['id']); }
				//print_r($tk);
				//die();
		        return $tk;	
		    }
		    return array(0);
        }/* fin de ticketsCliente */
        
        public function personasTicket($ticket_id, $include_admin = TRUE){
            
            //si se incluye a los administradores.
            $personas = array();
            $usuarios = array();
            $i = 0;
            /*if( $include_admin ):
                $admin = $this->Usuario->find('all',array(
                    'fields'=>array('Usuario.id','Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico','Usuario.isadmin'),
                    'conditions'=>array('Usuario.isadmin'=>1),
                    'joins'=>array(
                        array(
                            'alias'=>'Persona',
                            'table'=>'personas',
                            'type'=>'INNER',
                            'conditions'=>'Usuario.persona_id = Persona.id'
                            
                        )
                    )
                ));
                foreach( $admin as $ad ){
                    $usuarios[$i] = $ad['Usuario']['id'];
                    $personas[$i]['primer_nombre'] = $ad['Persona']['primer_nombre'];
                    $personas[$i]['primer_apellido'] = $ad['Persona']['primer_apellido'];
                    $personas[$i]['correo_electronico'] = $ad['Persona']['correo_electronico'];
                    $personas[$i]['isadmin'] = $ad['Usuario']['isadmin'];
                    $i++;
                }
            endif;*/
            //verificar si existe un servicio tecnologico seleccionado.
            $empresa = $this->ServicioTecnologico->query("select `Servicio`.`empresa_id` from servicio_tecnologico as `Servicio` where `Servicio`.id in (select distinct ms.servicio_id from mensajes_servicios ms join mensajes m on ms.mensaje_id = m.id join tickets t on m.ticket_id = t.id where t.id = {$ticket_id} and ms.servicio_seleccionado = 1);");
            if( count($empresa) == 1 ){ // hay servicio seleccionado
                // contactar con el contacto de la empresa si ha comentado en el ticket.
                $oferentes = $this->Persona->query("select DISTINCT `Persona`.*, `Usuario`.id, `Usuario`.isadmin from personas as `Persona` join usuarios `Usuario` on `Persona`.id = `Usuario`.persona_id join mensajes m on m.persona_id = `Persona`.id join tickets as `Ticket` on `Ticket`.id = m.ticket_id where m.ticket_id = {$ticket_id} and (`Usuario`.empresa_id = {$empresa[0]['Servicio']['empresa_id']} or `Usuario`.isadmin = 1 or `Ticket`.empresa_id = `Usuario`.empresa_id);");
            }else{// contactar a todos los oferentes involucrados.
               $oferentes = $this->Persona->find('all',array(
                    'fields'=>array('DISTINCT Usuario.id','Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico','Usuario.isadmin'),
                    'conditions'=>array('Mensaje.ticket_id'=>$ticket_id),
                    'joins'=>array(
                        array(
                            'alias'=>'Usuario',
                            'table'=>'usuarios',
                            'type'=>'INNER',
                            'conditions'=>'Persona.id = Usuario.persona_id'
                        ),
                        array(
                            'alias'=>'Mensaje',
                            'table'=>'mensajes',
                            'type'=>'INNER',
                            'conditions'=>'Persona.id = Mensaje.persona_id'
                        )
                    )
                )); 
            }
            foreach( $oferentes as $oferente ):
                $usuarios[$i] = $oferente['Usuario']['id'];
                $personas[$i]['primer_nombre'] = $oferente['Persona']['primer_nombre'];
                $personas[$i]['primer_apellido'] = $oferente['Persona']['primer_apellido'];
                $personas[$i]['correo_electronico'] = $oferente['Persona']['correo_electronico'];
                $personas[$i]['isadmin'] = $oferente['Usuario']['isadmin'];
                $i++;    
            endforeach;
            
            $personac = $this->Cookie->read('persona');
            if( array_search($personac['Usuario']['id'], $usuarios) !== FALSE ){
                $key = array_search($personac['Usuario']['id'], $usuarios);
                unset( $usuarios[$key] );
                unset( $personas[$key] );
            }  
 
            return $personas; 
            
        }/* fin de personasTicket */
        
        public function fichaproyecto($ticket_id = ''){
	        // verificar permisos
        	if( $this->checkPermissions( 'ticket', 'ver' ) === FALSE || $this->puedeVer($ticket_id) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            if( !is_numeric($ticket_id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del ticket.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            $ticket = $this->Ticket->find('first',array(
            	'fields'=> array('Cliente.*','Ticket.*','Municipio.*','Departamento.*'),
            	'conditions' => array('Ticket.id'=>$ticket_id),
            	'joins' => array(
            		array(
            			'alias' => 'Cliente',
            			'table' => 'empresas',
            			'type' => 'INNER',
            			'conditions' => 'Cliente.id = Ticket.empresa_id'
            		),
					array(
						'alias' => 'Municipio',
						'table' => 'municipios',
						'type' => 'INNER',
						'conditions' => 'Cliente.direccion_municipio = Municipio.id'
					),
					array(
						'alias' => 'Departamento',
						'table' => 'departamentos',
						'type' => 'INNER',
						'conditions' => 'Municipio.departamento = Departamento.id'
					)
            	)
            ));
            
            if( array_key_exists('Cliente', $ticket) ){
				$contactos_cliente = $this->Empresa->find('all',array(
					'fields' => array('Usuario.*','Persona.*'),
					'conditions' => array('Empresa.id'=>$ticket['Cliente']['id']),
					'joins' => array(
						array(
							'alias' => 'Usuario',
							'table' => 'usuarios',
							'type' => 'INNER',
							'conditions' => 'Empresa.id = Usuario.empresa_id'
						),
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				));
			}
			$this->set('ticket',$ticket);
			$this->set('contactos_cliente',$contactos_cliente);
            
            // buscar oferente
            $msj = array();
	        $mensajes = $this->Mensaje->findAllByTicketId($ticket_id);
	        foreach( $mensajes as $mensaje ){
        		if( array_key_exists('Mensaje', $mensaje) )
		        	array_push($msj,$mensaje['Mensaje']['id']);
        	}
	        $servicio = $this->MensajesServicio->find('first',array('conditions'=>array('MensajesServicio.mensaje_id'=>$msj,'MensajesServicio.servicio_seleccionado'=>1))); 	
			// mediante el servicio buscar el registro y la empresa oferente.
			if( array_key_exists('MensajesServicio', $servicio) ){
				$oferente = $this->ServicioTecnologico->find('first',array(
					'fields' => array('Oferente.*','ServicioTecnologico.*','Municipio.*','Departamento.*'),
					'conditions' => array('ServicioTecnologico.id'=>$servicio['MensajesServicio']['servicio_id']),
					'joins' => array(
						array(
							'alias' => 'Oferente',
							'table' => 'empresas',
							'type' => 'INNER',
							'conditions' => 'Oferente.id = ServicioTecnologico.empresa_id'
						),
						array(
							'alias' => 'Municipio',
							'table' => 'municipios',
							'type' => 'INNER',
							'conditions' => 'Oferente.direccion_municipio = Municipio.id'
						),
						array(
							'alias' => 'Departamento',
							'table' => 'departamentos',
							'type' => 'INNER',
							'conditions' => 'Municipio.departamento = Departamento.id'
						)
					)
				));
				
				if( array_key_exists('Oferente', $oferente) ){
					$contactos_oferente = $this->Empresa->find('all',array(
						'fields' => array('Usuario.*','Persona.*'),
						'conditions' => array('Empresa.id'=>$oferente['Oferente']['id']),
						'joins' => array(
							array(
								'alias' => 'Usuario',
								'table' => 'usuarios',
								'type' => 'INNER',
								'conditions' => 'Empresa.id = Usuario.empresa_id'
							),
							array(
								'alias' => 'Persona',
								'table' => 'personas',
								'type' => 'INNER',
								'conditions' => 'Usuario.persona_id = Persona.id'
							)
						)
					));
				}
				
				$this->set('oferente',$oferente);
				$this->set('contactos_oferente',$contactos_oferente);
				
				// encontrar el registro del administrador
				$this->set('persona_administrador',$this->Usuario->find('first',array(
					'fields' => array('Usuario.*','Persona.*'),
					'conditions' => array('Usuario.usuario'=>$this->Cookie->read('usuario')),
					'joins' => array(
						array(
							'alias' => 'Persona',
							'table' => 'personas',
							'type' => 'INNER',
							'conditions' => 'Usuario.persona_id = Persona.id'
						)
					)
				)));
				
			}// fin de buscar servicio seleccionado
			// criterios de evaluacion si existen del cliente.
			$satisfaccion_cliente = $this->CriteriosTicket->find('all',array(
				'fields'=>array('CriteriosTicket.criterio_id','CriteriosSatisfaccion.nombre_criterio','CriteriosTicket.evaluacion'),
				'conditions'=>array('CriteriosTicket.ticket_id'=>$ticket_id,'CriteriosCategoria.id'=>1),
				'joins'=>array(
					array(
						'alias'=>'CriteriosSatisfaccion',
						'table'=>'criterios_satisfaccion',
						'type'=>'INNER',
						'conditions'=>'CriteriosTicket.criterio_id = CriteriosSatisfaccion.id'
					),
					array(
						'alias'=>'CriteriosCategoria',
						'table'=>'criterios_categorias',
						'type'=>'INNER',
						'conditions'=>'CriteriosCategoria.id = CriteriosSatisfaccion.criterios_categorias_id'
					)
				)
			));
			//promedio.
			if( count($satisfaccion_cliente) > 0 ){
				$suma = 0;
				foreach( $satisfaccion_cliente as $sc ):
					switch( $sc['CriteriosTicket']['evaluacion'] ){
						case "deficiente":
							$suma += 1;
							break;
						case "regular":
							$suma += 2;
							break;
						case "bueno":
							$suma += 3;
							break;
						case "muy bueno":
							$suma += 4;
							break;
						case "excelente":
							$suma += 5;
							break;
						default:
							$suma += 0;
							break;
					}
				endforeach;
				$promedio_cliente = ceil($suma / count($satisfaccion_cliente));
				$promedio_cliente = $this->evaluaciones[ ($promedio_cliente-1) ];
				$apoyo_cliente = $this->CriteriosTicket->find('first',array('conditions'=>array('CriteriosTicket.criterio_id'=>14,'CriteriosTicket.ticket_id'=>$ticket_id)));
			}else{ $promedio_cliente = '&mdash;'; $apoyo_cliente = array(); }
			// criterios de evaluacion si existen del oferente.
			$satisfaccion_oferente = $this->CriteriosTicket->find('all',array(
				'fields'=>array('CriteriosTicket.criterio_id','CriteriosSatisfaccion.nombre_criterio','CriteriosTicket.evaluacion'),
				'conditions'=>array('CriteriosTicket.ticket_id'=>$ticket_id,'CriteriosCategoria.id'=>2),
				'joins'=>array(
					array(
						'alias'=>'CriteriosSatisfaccion',
						'table'=>'criterios_satisfaccion',
						'type'=>'INNER',
						'conditions'=>'CriteriosTicket.criterio_id = CriteriosSatisfaccion.id'
					),
					array(
						'alias'=>'CriteriosCategoria',
						'table'=>'criterios_categorias',
						'type'=>'INNER',
						'conditions'=>'CriteriosCategoria.id = CriteriosSatisfaccion.criterios_categorias_id'
					)
				)
			));
			//promedio.
			if( count($satisfaccion_oferente) > 0 ){
				$suma = 0;
				foreach( $satisfaccion_oferente as $sc ):
					switch( $sc['CriteriosTicket']['evaluacion'] ){
						case "deficiente":
							$suma += 1;
							break;
						case "regular":
							$suma += 2;
							break;
						case "bueno":
							$suma += 3;
							break;
						case "muy bueno":
							$suma += 4;
							break;
						case "excelente":
							$suma += 5;
							break;
						default:
							$suma += 0;
							break;
					}
				endforeach;
				$promedio_oferente = ceil($suma / count($satisfaccion_cliente));
				$promedio_oferente = $this->evaluaciones[ ($promedio_oferente-1) ];
				$apoyo_oferente = $this->CriteriosTicket->find('first',array('conditions'=>array('CriteriosTicket.criterio_id'=>27,'CriteriosTicket.ticket_id'=>$ticket_id)));
			}else{ $promedio_oferente = '&mdash;'; $apoyo_oferente = array(); }
			$this->set('promedio_cliente',$promedio_cliente);
			$this->set('promedio_oferente',$promedio_oferente);
			$this->set('apoyo_cliente',$apoyo_cliente);
			$this->set('apoyo_oferente',$apoyo_oferente);
			$this->set('satisfaccion_cliente',$satisfaccion_cliente);
			$this->set('satisfaccion_oferente',$satisfaccion_oferente);
			$this->set('contrato',$this->Contrato->findByTicketId($ticket_id));
			$this->set('meses',$this->meses);
			$this->layout = 'impresion';
            
        }/* fin de funcion fichaproyecto */
        
     }
?>