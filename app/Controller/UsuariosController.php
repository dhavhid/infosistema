<?php
/*
 * Autor DIMH@09-08-2014
 * */
    class UsuariosController extends AppController{
        public $uses = array('Usuario','Persona','Empresa','Mensaje','CriteriosTicket');
        public $components = array('Session', 'Cookie','Paginator');
        public $helpers = array('Js','Form','Html','Session','Paginator');
        public $layout = 'default';
        
        public $paginate = array(
            'fields' => array('Persona.id','Persona.primer_nombre','Persona.segundo_nombre','Persona.tercer_nombre','Persona.primer_apellido','Persona.segundo_apellido','Persona.telefono_oficina','Persona.telefono_celular','Persona.telefono_casa','Persona.correo_electronico','Persona.correo_electronico_secundario','Persona.estado','Usuario.id','Usuario.usuario','Usuario.empresa_id','Usuario.modulo_administracion','Usuario.modulo_busqueda','Usuario.modulo_empresa','Usuario.modulo_reporte','Usuario.modulo_ticket','Usuario.isadmin'),
            'conditions' => array('Persona.estado' => 1),
            'joins' => array(
                array(
                    'alias' => 'Usuario',
                    'table' => 'usuarios',
                    'type' => 'INNER',
                    'conditions' => '`Usuario`.`persona_id` = `Persona`.`id`'
                )
            ),
            'limit' => PER_PAGE,
            'order' => array(
                'primer_nombre' => 'asc',
                'primer_apellido' => 'asc'
            )
        );
        
        public function beforeRender(){
            parent::beforeRender();
            $this->set('menu_activo','administracion');
        }
        
        public function admin_index( $filtro = '' ){
        	
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'index' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        	
            $this->Paginator->settings = $this->paginate;
            $this->set('personas',$this->Paginator->paginate($this->Persona,
                    array('OR' =>
                        array('Persona.primer_nombre LIKE'=>"{$filtro}%",'Persona.primer_apellido LIKE'=>"{$filtro}%",'Persona.correo_electronico LIKE'=>"{$filtro}%",'Usuario.usuario LIKE'=>"{$filtro}%")
                    )    
            ));
            $this->set('filtro',$filtro);
        }
        
        public function admin_perfil( $id = 0 ){
        	
        	// verificar permisos
        	$persona = $this->Cookie->read('persona');
        	if( $this->checkPermissions( 'administracion', 'perfil' ) === FALSE && $persona['Usuario']['id'] != $id ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->request->is('post') && ($id == 0 || !is_numeric($id)) ){
                $this->Persona->create();
                if( $this->Persona->save($this->request->data) ):
                    // crear nombre de usuario
                    $primer_nombre = $this->slugify($this->request->data['Persona']['primer_nombre']);
                    $primer_apellido = $this->slugify($this->request->data['Persona']['primer_apellido']);
                    $i = 1;
                    do{
                        $nombre_usuario = strtolower(substr($primer_nombre,0,$i) . '.' . $primer_apellido);
                        $i++;    
                    }while( $this->Usuario->find('count',array('conditions'=>array('Usuario.usuario'=>$nombre_usuario))) > 0 );
                    
                    // crear registro en la tabla de usuario.
                    $this->Usuario->create();
                    if($this->Usuario->save(array(
                        'Usuario' => array(
                            'usuario' => $nombre_usuario,
                            'contrasena' => md5($nombre_usuario),
                            'persona_id' => $this->Persona->id
                        )
                    ))){
                        $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del usuario se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                        $this->redirect(array('action'=>'admin_credenciales',$this->Usuario->id));
                    }else{
                        // no se pudo crear el usuario, eliminar persona
                        $this->Persona->delete($this->Persona->id);
                        $this->Session->setFlash('<strong>Error:</strong> No se pudo crear el registro del usuario. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                    }
                else:
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo crear el registro del usuario. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                endif;    
            }
            // edicion del registro.
            if( $this->request->is('put') ){
                if( $this->Persona->save($this->request->data) ):
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del usuario se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $usuario = $this->Usuario->find('first',array('conditions'=>array('Usuario.persona_id'=>$this->request->data['Persona']['id'])));
                    $this->redirect(array('action'=>'admin_credenciales',$usuario['Usuario']['id']));
                else:
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo crear el registro del usuario. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                endif; // fin de guardar edicion
            }
            if( is_numeric($id) && $id > 0 ){
                $usuario = $this->Usuario->find('first',array('conditions'=>array('Usuario.id'=>$id)));
                $persona = $this->Persona->findById($usuario['Usuario']['persona_id']);
                if( $persona ):
                    $this->request->data['Persona'] = $persona['Persona'];
                    $this->request->data['Usuario'] = $usuario['Usuario'];
                endif;    
            }
            
        }/* fin de la funcion perfil */
        
        public function admin_credenciales($id = 0){
        	//verificar permisos
            $persona = $this->Cookie->read('persona');    
            if( $this->checkPermissions( 'administracion', 'credenciales' ) === FALSE && $persona['Usuario']['id'] != $id ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
                //print_r($persona);
                //die('Hey whats wrong? ' . $persona['Usuario']['id'] . ' :' . $id);
        	endif;
            
            if( $id == 0 || !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del usuario.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'admin_index'));
            }
            
            if( $this->request->is('put') ){
                if( $this->Usuario->save($this->request->data) ):
                    if( $this->checkPermissions( 'administracion', 'credenciales' ) === TRUE ){
	                	$this->Session->setFlash('<strong>&Eacute;xito!</strong> Las credenciales del usuario se guardaron satisfactoriamente.','default',array('class'=>'alert alert-success'));
	                	$this->redirect(array('action'=>'admin_acceso',$id));    
                    }else{
                    	$this->Session->setFlash('<strong>&Eacute;xito!</strong> Su contrase&ntilde;a se guard&oacute; satisfactoriamente.','default',array('class'=>'alert alert-success'));
	                    header('Location: /busquedas/index');
						die();
                    }
                else:
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar las credenciales del usuario. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                endif;
            }
            
            $usuario = $this->Usuario->findById($id);
            $usuario['Usuario']['contrasena'] = '';
            $this->request->data = $usuario;
        }/* fin de la funcion credenciales */

        public function admin_acceso($id = 0){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'acceso' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            if( $id == 0 || !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del usuario.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'admin_index'));
            }
            
            if( $this->request->is('put') ){
                // lo primero es poner todos los módulos a 0 y el modulo de busqueda a 1
                $this->Usuario->save(array(
                    'Usuario'=>array(
                        'id' => $id,
                        'modulo_administracion' => 0,
                        'modulo_busqueda' => 1,
                        'modulo_empresa' => 0,
                        'modulo_reporte' => 0,
                        'modulo_ticket' => 0,
                        'isadmin' => 0
                    )
                ));
                if( $this->Usuario->save($this->request->data) ):
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El acceso del usuario se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'admin_index'));        
                else:
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el acceso del usuario. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                endif;    
            }
            
            $usuario = $this->Usuario->findById($id);
            $persona = $this->Persona->findById($usuario['Usuario']['persona_id']);
            $empresas = $this->Empresa->find('list',array('fields'=>array('Empresa.id','Empresa.nombre_empresa'),'order'=>array('Empresa.nombre_empresa ASC')));
            $this->set('empresas',$empresas);
            $this->request->data = array_merge($usuario,$persona);
        }/* fin de la funcion acceso */
        
        public function admin_ver($id){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'ver' ) === FALSE && $this->checkPermissions( 'reporte', 'usuarios' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $id == 0 || !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del usuario.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'admin_index'));
            }
            
            $persona = $this->Persona->findById($id);
            if( count($persona) == 0 ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del usuario.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'admin_index'));
            }
            $usuario = $this->Usuario->find('first',array('conditions'=>array('Usuario.persona_id'=>$persona['Persona']['id'])));
            $this->set('persona',$persona);
            $this->set('usuario',$usuario);
            $empresa = $this->Empresa->find('first',array('conditions'=>array('Empresa.id'=>$usuario['Usuario']['empresa_id'])));
            if( !array_key_exists('Empresa', $empresa) )$empresa = array('Empresa'=>array('nombre_empresa'=>''));
            $this->set('empresa',$empresa);
            $this->set('titulo_reporte','Reporte de Usuario');
            $this->layout = 'impresion';
        }/* fin de funcion ver */

        public function admin_eliminar($id){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'eliminar' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            if( $id == 0 || !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del usuario.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'admin_index'));
            }
            
            $persona = $this->Persona->findById($id);
            if( count($persona) == 0 ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del usuario.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'admin_index'));
            }
            
            // contar registros en mensajes
            $mensajes = $this->Mensaje->find('count',array('conditions'=>array('Mensaje.persona_id'=>$id)));
            // contar numero de criterios que haya llenado
            //$this->Criterioticket->useTable = 'criterios_tickets';
            //echo $this->Criterioticket->useTable;
            $criterios = $this->CriteriosTicket->find('count',array('conditions'=>array('CriteriosTicket.persona_id'=>$id)));
            if( $mensajes == 0 && $criterios == 0 ){ // es seguro borrar el registro.
                // borrar primero el usuario
                $this->Usuario->deleteAll(array('persona_id'=>$id));
                // borrar persona
                $this->Persona->delete($id);  
                $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del usuario se elimin&oacute; correctamente.','default',array('class'=>'alert alert-success')); 
            }else{
                $this->Session->setFlash('<strong>Error:</strong> No se pudo eliminar el registro del usuario debido a que existe informaci&oacute;n asociada a &eacute;l.','default',array('class'=>'alert alert-danger'));
            }
            $this->redirect(array('action'=>'admin_index')); 
            
        }/* fin de funcion eliminar */
        
        public function admin_imprimir( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'imprimir' ) === FALSE && $this->checkPermissions( 'reporte', 'usuarios' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
			
			$this->set('personas',$this->Persona->find('all',array(
				'fields' => array('Persona.*','Usuario.*'),
				'conditions' => array('OR' => array('Persona.primer_nombre LIKE'=>"{$filtro}%",'Persona.primer_apellido LIKE'=>"{$filtro}%",'Persona.correo_electronico LIKE'=>"{$filtro}%",'Usuario.usuario LIKE'=>"{$filtro}%")),
				'joins' => array(
					array(
						'alias' => 'Usuario',
						'table' => 'usuarios',
						'type' => 'INNER',
						'conditions' => 'Persona.id = Usuario.persona_id'
					)
				),
				'sort' => array('Persona.primer_nombre ASC','Persona.primer_apellido ASC')
			)));
            $this->layout = 'impresion';
        }
    }
?>