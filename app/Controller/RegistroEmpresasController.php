<?php
    /*
     * Autor DIMH@14-08-2014
     * */
     class RegistroEmpresasController extends AppController{
        public $uses = array('Contribuyente','ActividadesEconomica',
                        'Empresa','RecursosServicio','Area','Infraestructura','Laboratorio','EmpresasSolicitante',
                        'FormasPago','FormasContacto','Departamento','Municipio','Persona','Usuario','ServicioTecnologico');
        public $components = array('Session', 'Cookie','Paginator','RequestHandler');
        public $helpers = array('Js','Form','Html','Session','Paginator');
        public $layout = 'default';
        public $paginate = array(
            'fields' => array(
                'Empresa.*','Persona.id','Persona.primer_nombre','Persona.primer_apellido','Departamento.nombre_departamento','Municipio.nombre_municipio'
            ),
            'joins' => array(
                array(
                    'alias' => 'Municipio',
                    'table' => 'municipios',
                    'type' => 'INNER',
                    'conditions' => '`Municipio`.`id` = `Empresa`.`direccion_municipio`'
                ),
                array(
                    'alias' => 'Departamento',
                    'table' => 'departamentos',
                    'type' => 'INNER',
                    'conditions' => '`Departamento`.`id` = `Municipio`.`departamento`'
                ),
                array(
                    'alias' => 'Usuario',
                    'table' => 'usuarios',
                    'type' => 'LEFT',
                    'conditions' => '`Usuario`.`empresa_id` = `Empresa`.`id`'
                ),
                array(
                    'alias' => 'Persona',
                    'table' => 'personas',
                    'type' => 'LEFT',
                    'conditions' => '`Usuario`.`persona_id` = `Persona`.`id`'
                )
            ),
            'limit' => PER_PAGE,
            'order' => array('Empresa.nombre_empresa'=>'asc')
        );
        
        public function beforeRender(){
            parent::beforeRender();
            $this->set('menu_activo','empresas');
        }
        
        public function empresas_index( $filtro = '' ){
            // verificar permisos
        	if( $this->checkPermissions( 'empresa', 'index' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            $this->Paginator->settings = $this->paginate;
            $this->set('empresas',$this->Paginator->paginate($this->Empresa,array(
                    'OR' => 
                        array('Empresa.nombre_empresa LIKE'=>"%{$filtro}%",'Empresa.nit LIKE'=>"%{$filtro}%",'Empresa.numero_registro LIKE'=>"%{$filtro}%")
                )
            ));
            $this->set('filtro',$filtro);
            
        }/* fin de funcion index */
        
        public function empresas_perfil( $id = 0 ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'perfil' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->request->is('post') ){
                $this->Empresa->create();
                $this->procesarImagen();
                if( $this->Empresa->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de la empresa se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'empresas_areas',$this->Empresa->id));
                }// exito al guardar
                else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro de la empresa. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }
            } /* Post request = INSERTING */
            
            if( $this->request->is('put') ){
                $this->procesarImagen();
                if( $this->Empresa->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de la empresa se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'empresas_areas',$this->Empresa->id));
                }// exito al guardar
                else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro de la empresa. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }
            }/* Put request = EDITING */
            
            if( is_numeric($id) && $id > 0 && $this->Empresa->find('count',array('conditions'=>array('Empresa.id'=>$id))) > 0 ){
                $this->request->data = $this->Empresa->findById($id);
                $municipio = $this->Municipio->findById($this->request->data['Empresa']['direccion_municipio']);
                $municipios = $this->Municipio->find('list',array('fields'=>array('Municipio.id','Municipio.nombre_municipio'),'conditions'=>array('Municipio.departamento'=>$municipio['Municipio']['departamento']),'order'=>array('Municipio.nombre_municipio ASC')));
                $departamento = $municipio['Municipio']['departamento'];
                $municipio = $this->request->data['Empresa']['direccion_municipio'];
            }else{ $municipios = array(); $departamento = ''; $municipio = ''; }
            $actividades = $this->ActividadesEconomica->find('all',array('fields'=>array('DISTINCT ActividadesEconomica.actividad_principal'),'order'=>array('ActividadesEconomica.actividad_principal ASC')));
            $items = array();
            foreach( $actividades as $actividad ):
                $items[$actividad['ActividadesEconomica']['actividad_principal']] = $actividad['ActividadesEconomica']['actividad_principal'];
                //$i++;
            endforeach;   
            $this->set('municipio',$municipio);
            $this->set('municipios',$municipios); 
            $this->set('departamento',$departamento);
            $this->set('actividades_principales',$items);
            $this->set('departamentos',$this->Departamento->find('list',array('fields'=>array('Departamento.id','Departamento.nombre_departamento'),'order'=>array('Departamento.nombre_departamento ASC'))));
        }/* fin de funcion perfil */
        
        public function empresas_areas( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'areas' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') ):
                $this->Area->create();
                if( $this->Area->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El &aacute;rea se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el &aacute;rea de la empresa.','default',array('class'=>'alert alert-danger'));
                }    
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $this->set('areas',$this->Area->find('all',
                    array(
                        'fields' => array('Area.*'),
                        'conditions'=>array('Area.empresa_id'=>$id),
                        'order' => array('Area.nombre_area ASC')
                    )
                ));
                $this->request->data = $empresa;
            }
            
        }/* fin de funcion areas */
        
        public function empresas_eliminar_area( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'eliminar_area' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->Area->delete($id) ){
                $this->set(array('item'=>array('resultado'=>1),'_serialize'=>'item'));
            }else{
                $this->set(array('item'=>array('resultado'=>0),'_serialize'=>'item'));
            }
            
        }/* Fin de eliminar areas */
        
        public function empresas_laboratorios( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'laboratorios' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') ):
                $this->Laboratorio->create();
                if( $this->Laboratorio->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El laboratorio se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el laboratorio de la empresa.','default',array('class'=>'alert alert-danger'));
                }    
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $this->set('laboratorios',$this->Laboratorio->find('all',
                    array(
                        'fields' => array('Laboratorio.*'),
                        'conditions'=>array('Laboratorio.empresa_id'=>$id),
                        'order' => array('Laboratorio.nombre_laboratorio ASC')
                    )
                ));
                $this->request->data = $empresa;
            }
            
        }/* fin de funcion laboratorios */
        
        public function empresas_eliminar_laboratorio( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'laboratorio' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->Laboratorio->delete($id) ){
                $this->set(array('item'=>array('resultado'=>1),'_serialize'=>'item'));
            }else{
                $this->set(array('item'=>array('resultado'=>0),'_serialize'=>'item'));
            }
            
        }/* Fin de eliminar laboratorios */
        
        public function empresas_solicitantes( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'solicitantes' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
                
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') || $this->request->is('put') ):
                //$this->EmpresasSolicitante->create();
                if( $this->EmpresasSolicitante->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de empresas solicitantes se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'contactos',$id));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro de empresas solicitantes.','default',array('class'=>'alert alert-danger'));
                }    
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $solicitante = $this->EmpresasSolicitante->find('first',
                    array(
                        'conditions'=>array('EmpresasSolicitante.empresa_id'=>$id)
                    )
                );
                if( array_key_exists('EmpresasSolicitantes', $solicitante) )$this->request->data['EmpresasSolicitante'] = $solicitante['EmpresasSolicitante'];
                $this->request->data['Empresa'] = $empresa['Empresa'];
            }
        }/* fin de funcion solicitantes */
        
        public function empresas_recursos( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'recursos' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') ):
                $this->RecursosServicio->create();
                if( $this->RecursosServicio->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El recurso para la administraci&oacute;n se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el recurso para la administraci&oacute;n de la empresa.','default',array('class'=>'alert alert-danger'));
                }    
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $this->set('recursos',$this->RecursosServicio->find('all',
                    array(
                        'fields' => array('RecursosServicio.*'),
                        'conditions'=>array('RecursosServicio.empresa_id'=>$id),
                        'order' => array('RecursosServicio.nombre_recurso ASC')
                    )
                ));
                $this->request->data = $empresa;
            }
            
        }/* fin de funcion recursos */
        
        public function empresas_eliminar_recurso( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'eliminar_recurso' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->RecursosServicio->delete($id) ){
                $this->set(array('item'=>array('resultado'=>1),'_serialize'=>'item'));
            }else{
                $this->set(array('item'=>array('resultado'=>0),'_serialize'=>'item'));
            }
            
        }/* Fin de eliminar recursos */
        
        public function empresas_infraestructuras( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'infraestructuras' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('post') ):
                $this->Infraestructura->create();
                if( $this->Infraestructura->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> La infraestructura se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar la infraestructura de la administraci&oacute;n de la empresa.','default',array('class'=>'alert alert-danger'));
                }    
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $this->set('infraestructuras',$this->Infraestructura->find('all',
                    array(
                        'fields' => array('Infraestructura.*'),
                        'conditions'=>array('Infraestructura.empresa_id'=>$id),
                        'order' => array('Infraestructura.nombre_infraestructura ASC')
                    )
                ));
                $this->request->data = $empresa;
            }
            
        }/* fin de funcion infraestructuras */
        
        public function empresas_eliminar_infraestructura( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'eliminar_infraestructura' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->Infraestructura->delete($id) ){
                $this->set(array('item'=>array('resultado'=>1),'_serialize'=>'item'));
            }else{
                $this->set(array('item'=>array('resultado'=>0),'_serialize'=>'item'));
            }
            
        }/* Fin de eliminar recursos */
        
        public function empresas_pagos( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'eliminar_pagos' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('put') ):
                // primero ponemos a cero todas las formas de contacto de la empresa.
                $this->FormasPago->save(
                    array(
                        'FormasPago' => array(
                            'enefectivo' => 0,
                            'tarjetacredito' => 0,
                            'depositocuenta' => 0,
                            'cheque' => 0,
                            'transferencia' => 0,
                            'paypal' => 0,
                            'id' => $this->request->data['FormasPago']['id']
                        )
                    )
                );
            endif;    
            
            if( $this->request->is('post') || $this->request->is('put') ):
                
                if( $this->FormasPago->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de medios de pagos se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'index'));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro de medios de pagos.','default',array('class'=>'alert alert-danger'));
                }  
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $pago = $this->FormasPago->find('first',
                    array(
                        'conditions'=>array('FormasPago.empresa_id'=>$id)
                    )
                );
                if( array_key_exists('FormasPago', $pago) )$this->request->data['FormasPago'] = $pago['FormasPago'];
                $this->request->data['Empresa'] = $empresa['Empresa'];
            }
            
        }/* fin de funcion pagos */
        
        public function empresas_contactos( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'contactos' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('put') ):
                // primero ponemos a cero todas las formas de contacto de la empresa.
                $this->FormasContacto->save(
                    array(
                        'FormasContacto' => array(
                            'enoficina' => 0,
                            'viatelefono' => 0,
                            'viaemail' => 0,
                            'viawebsite' => 0,
                            'viaskype' => 0,
                            'eventual' => 0,
                            'extensionismo' => 0,
                            'id' => $this->request->data['FormasContacto']['id']
                        )
                    )
                );
            endif;    
            
            if( $this->request->is('post') || $this->request->is('put') ):
                
                if( $this->FormasContacto->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de medios de atenci&oacute;n al cliente se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'pagos',$id));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro de medios de atenci&oacute;n al cliente.','default',array('class'=>'alert alert-danger'));
                }  
            endif;    
            
            $empresa = $this->Empresa->findById($id);
            if( !array_key_exists('Empresa', $empresa) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $contacto = $this->FormasContacto->find('first',
                    array(
                        'conditions'=>array('FormasContacto.empresa_id'=>$id)
                    )
                );
                if( array_key_exists('FormasContacto', $contacto) )$this->request->data['FormasContacto'] = $contacto['FormasContacto'];
                $this->request->data['Empresa'] = $empresa['Empresa'];
            }
            
        }/* fin de funcion contactos */
        
        public function empresas_ver( $id = '', $cerrar = '1' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'ver' ) === FALSE && $this->checkPermissions( 'reporte', 'empresas' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            } 
            $empresa = $this->Empresa->find('first',
                array(
                    'fields' => array(
                        'Empresa.*','Persona.id','Persona.primer_nombre','Persona.primer_apellido','Departamento.nombre_departamento','Municipio.nombre_municipio'
                    ),
                    'conditions' => array('Empresa.id'=>$id),
                    'joins' => array(
                        array(
                            'alias' => 'Municipio',
                            'table' => 'municipios',
                            'type' => 'INNER',
                            'conditions' => '`Municipio`.`id` = `Empresa`.`direccion_municipio`'
                        ),
                        array(
                            'alias' => 'Departamento',
                            'table' => 'departamentos',
                            'type' => 'INNER',
                            'conditions' => '`Departamento`.`id` = `Municipio`.`departamento`'
                        ),
                        array(
                            'alias' => 'Usuario',
                            'table' => 'usuarios',
                            'type' => 'LEFT',
                            'conditions' => '`Usuario`.`empresa_id` = `Empresa`.`id`'
                        ),
                        array(
                            'alias' => 'Persona',
                            'table' => 'personas',
                            'type' => 'LEFT',
                            'conditions' => '`Usuario`.`persona_id` = `Persona`.`id`'
                        )
                    )
                )
            );
            $this->set('empresa',$empresa);
            $this->set('areas',$this->Area->find('all',array('conditions'=>array('Area.empresa_id'=>$id),'order'=>array('Area.nombre_area ASC'))));
            $this->set('recursos',$this->RecursosServicio->find('all',array('conditions'=>array('RecursosServicio.empresa_id'=>$id),'order'=>array('RecursosServicio.nombre_recurso ASC'))));
            $this->set('infraestructuras',$this->Infraestructura->find('all',array('conditions'=>array('Infraestructura.empresa_id'=>$id),'order'=>array('Infraestructura.nombre_infraestructura ASC'))));
            $this->set('laboratorios',$this->Laboratorio->find('all',array('conditions'=>array('Laboratorio.empresa_id'=>$id),'order'=>array('Laboratorio.nombre_laboratorio ASC'))));
            $this->set('solicitante',$this->EmpresasSolicitante->find('first',array('conditions'=>array('EmpresasSolicitante.empresa_id'=>$id))));
            $this->set('contacto',$this->FormasContacto->find('first',array('conditions'=>array('FormasContacto.empresa_id'=>$id))));
            $this->set('pago',$this->FormasPago->find('first',array('conditions'=>array('FormasPago.empresa_id'=>$id))));
            $this->set('serviciostecnologicos',$this->ServicioTecnologico->find('all',array('conditions'=>array('ServicioTecnologico.empresa_id'=>$id),'order'=>array('ServicioTecnologico.nombre_servicio ASC'))));
            $this->set('cerrar',$cerrar);
            $this->layout = 'impresion';
            
            
        }/* fin de funcion ver */
        
        public function empresas_imprimir( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'imprimir' ) === FALSE && $this->checkPermissions( 'reporte', 'empresas' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            $empresas = $this->Empresa->find('all',
                array(
                    'fields' => array(
                        'Empresa.*','Persona.id','Persona.primer_nombre','Persona.primer_apellido','Departamento.nombre_departamento','Municipio.nombre_municipio'
                    ),
                    'conditions' => array('OR' => array('Empresa.nombre_empresa LIKE'=>"%{$filtro}%",'Empresa.nit LIKE'=>"%{$filtro}%",'Empresa.numero_registro LIKE'=>"%{$filtro}%")),
                    'joins' => array(
                        array(
                            'alias' => 'Municipio',
                            'table' => 'municipios',
                            'type' => 'INNER',
                            'conditions' => '`Municipio`.`id` = `Empresa`.`direccion_municipio`'
                        ),
                        array(
                            'alias' => 'Departamento',
                            'table' => 'departamentos',
                            'type' => 'INNER',
                            'conditions' => '`Departamento`.`id` = `Municipio`.`departamento`'
                        ),
                        array(
                            'alias' => 'Usuario',
                            'table' => 'usuarios',
                            'type' => 'LEFT',
                            'conditions' => '`Usuario`.`empresa_id` = `Empresa`.`id`'
                        ),
                        array(
                            'alias' => 'Persona',
                            'table' => 'personas',
                            'type' => 'LEFT',
                            'conditions' => '`Usuario`.`persona_id` = `Persona`.`id`'
                        )
                    ),
                    'order' => array('Empresa.nombre_empresa'=>'asc')
                )
            );
            $this->set('empresas',$empresas);
            $this->layout = 'impresion';
            
        }/* fin de funcion imprimir */
        
        public function empresas_eliminar( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'eliminar' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro de la empresa.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }   
            
            $servicios = $this->ServicioTecnologico->find('count',array('conditions'=>array('ServicioTecnologico.empresa_id'=>$id)));
            if( $servicios == 0 ){
                // eliminar empresa.
                $this->Area->deleteAll(array('Area.empresa_id'=>$id),false);
                $this->RecursosServicio->deleteAll(array('RecursosServicio.empresa_id'=>$id),false);
                $this->Infraestructura->deleteAll(array('Infraestructura.empresa_id'=>$id),false);
                $this->Laboratorio->deleteAll(array('Laboratorio.empresa_id'=>$id),false);
                $this->EmpresasSolicitante->deleteAll(array('EmpresasSolicitante.empresa_id'=>$id),false);
                $this->FormasContacto->deleteAll(array('FormasContacto.empresa_id'=>$id),false);
                $this->FormasPago->deleteAll(array('FormasPago.empresa_id'=>$id),false);
                $this->Usuario->query('UPDATE usuarios SET empresa_id = null WHERE empresa_id = '.$id);
                $this->Empresa->delete($id);
                $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de la empresa se elimin&oacute; satisfactoriamente.','default',array('class'=>'alert alert-success'));
            }else{
                $this->Session->setFlash('<strong>Error:</strong> No se pudo eliminar el registro de la empresa debido a que existen servicios tecnol&oacute;gicos que dependen de el.','default',array('class'=>'alert alert-danger'));
            }
            $this->redirect(array('action'=>'index'));     
                
        }/* fin de funcion eliminar */
        
        protected function procesarImagen(){
            
            if( $_FILES['archivo'] && $_FILES['archivo']['error'] == UPLOAD_ERR_OK ):
                if( strtolower($_FILES['archivo']['type']) == 'image/jpeg' || strtolower($_FILES['archivo']['type']) == 'image/gif' || strtolower($_FILES['archivo']['type']) == 'image/png' || strtolower($_FILES['archivo']['type']) == 'image/pjpeg' ){
                    $paths = pathinfo($_FILES['archivo']['name']);     
                    $file_name = $this->slugify($_FILES['archivo']['name']) . '.' . $paths['extension'];
                    if( move_uploaded_file($_FILES['archivo']['tmp_name'], WWW_ROOT . 'files' . DS . 'logos' . DS . $file_name) ){
                    	//die(WWW_ROOT . 'files' . DS . 'logos' . DS . $file_name);
                        //eliminar el logo anterior, si la empresa existe
                        if( array_key_exists('id', $this->request->data['Empresa']) && is_numeric($this->request->data['Empresa']['id']) ){
                            $empresa_r = $this->Empresa->findById($this->request->data['Empresa']['id']);
                            unlink(WWW_ROOT . 'files' . DS . 'logos' . DS . $empresa_r['Empresa']['logotipo']);
                        }    
                        $this->request->data['Empresa']['logotipo'] = $file_name;    
                        return true;
                    }else
                        return false;    
                }// verificar tipo de archivo.
            endif;
            return false;
        }/* fin de funcion procesarImagen */
     }
?>     