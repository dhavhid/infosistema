<?php
    /*
     * Autor DIMH@22-08-2014
     * */
     class ServiciosController extends AppController{
        public $uses = array('Empresa','TipoServicio','SectoresApoyo','CategoriasApoyo','EmpresasServicio','ServicioTecnologico','MensajesServicio','RecursosServicio','Area','Infraestructura','Laboratorio','EmpresasSolicitante',
                        'FormasPago','FormasContacto');
        public $components = array('Session', 'Cookie','Paginator','RequestHandler');
        public $helpers = array('Js','Form','Html','Session','Paginator','Number');
        public $layout = 'default';
        public $paginate = array(
            'fields' => array('ServicioTecnologico.*','Empresa.id','Empresa.nombre_empresa'),
            'joins' => array(
                array(
                    'alias' => 'Empresa',
                    'table' => 'empresas',
                    'type' => 'INNER',
                    'conditions' => 'Empresa.id = ServicioTecnologico.empresa_id'
                )
            ),
            'limit' => PER_PAGE,
            'order' => array('ServicioTecnologico.nombre_servicio'=>'asc')
        );
        public $categorias_x_defecto = array(
            'Recursos Humanos' => array('Asesoría Técnica','Capacitación','Becas','Certificación','Formación','Consultoría'),
            'Financiamiento y Aspectos Legales' => array('Asesoría Financiera','Auditoría','Créditos','Cofinanciamientos','Donaciones','Fondos/Grants','Asesoría Legal','Capacitación','Formalización','Empresas/Entidades','Propiedad Intelectual','Contratos','Mercado de Capitales'),
            'Comercialización y Mercado' => array('Consultoría','Inteligencia Mercado','Inteligencia Competitiva','Intermediación (Brokerage)','Comercio Electrónico','Logística','Marketing','Capacitación'),
            'Servicios Técnicos/Tecnológicos' => array('Pruebas Laboratorio','Certificación','I+D','Transferencia de Tecnolog&iacute;a','Consultoría','Servicios de TI','Adapt. de tecnología','Áreas Sistema nacional de Calidad (NMPART)'),
            'Generación Empresas' => array('Incubación de Empresas','Emprendimiento'),
            'Redes' => array('Contactos Temáticos y de Negocios en el Exterior','Contactos Asociaciones Internacionales','Contactos Redes de proveedores')
        );
        public $sectores_x_defecto = array('Alimentos y Bebidas','Industria Farmacéutica','Acuaindustria (Acuicultura)','Diseño','Energía','Agroindustria','Metalmecánica','Textiles y Confección','TICs','Mecatrónica','Servicios','Salud','Comercial','Logística');
        public $empresas_x_defecto = array('Micro empresa','Pequeña empresa','Mediana empresa','Gran empresa','Emprendimiento / Incubación','Instituciones');
        
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
            $this->set('servicios',$this->Paginator->paginate($this->ServicioTecnologico,array(
                    'OR' => 
                        array('ServicioTecnologico.nombre_servicio LIKE'=>"%{$filtro}%",'ServicioTecnologico.descripcion_servicio LIKE'=>"%{$filtro}%",'Empresa.nombre_empresa LIKE'=>"{$filtro}%")
                )
            ));
            $this->set('filtro',$filtro);
            
        }/* fin de funcion index */
        
        public function empresas_perfil( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'perfil' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;

            if( $this->request->is('post') ){
                
                $this->ServicioTecnologico->create();
                if( $this->ServicioTecnologico->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del servicio tecnol&oacute;gico se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'tiposervicio',$this->ServicioTecnologico->id));
                }// exito al guardar
                else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro del servicio tecnol&oacute;gico. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }
                
            } /* Post request = INSERTING */
            
            if( $this->request->is('put') ){
                if( $this->ServicioTecnologico->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del servicio tecnol&oacute;gico se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'tiposervicio',$id));
                }// exito al guardar
                else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro del servicio tecnol&oacute;gico. Por favor intente nuevamente.','default',array('class'=>'alert alert-danger'));
                }

            }/* Put request = EDITING */
            
            if( is_numeric($id) && $id > 0 && $this->ServicioTecnologico->find('count',array('conditions'=>array('ServicioTecnologico.id'=>$id))) > 0 ){
                $this->request->data = $this->ServicioTecnologico->findById($id);
            }
            $empresas = $this->Empresa->find('list',array('fields'=>array('Empresa.id','Empresa.nombre_empresa'),'order'=>array('Empresa.nombre_empresa ASC'))); 
            $this->set('empresas',$empresas);
            
        }/* fin de funcion perfil */
        
        public function empresas_tiposervicio( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'tiposervicio' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('put') ):
                // primero ponemos a cero todas los tipos de servicios.
                $this->TipoServicio->save(
                    array(
                        'TipoServicio' => array(
                            'servicio_tecnologico' => 0,
                            'transferencia_tecnologia' => 0,
                            'proyectos_id' => 0,
                            'proyectos_especiales' => 0,
                            'desarrollo_rrhh' => 0,
                            'id' => $this->request->data['TipoServicio']['id']
                        )
                    )
                );
            endif;    
            
            if( $this->request->is('post') || $this->request->is('put') ):
                
                if( $this->TipoServicio->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del tipo de servicio tecnol&oacute;gico se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'categorias',$id));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro del tipo de servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                }  
            endif;    
            
            $servicio = $this->ServicioTecnologico->findById($id);
            if( !array_key_exists('ServicioTecnologico', $servicio) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $tiposervicio = $this->TipoServicio->findByServicioId($id);
                if( array_key_exists('TipoServicio', $tiposervicio) )$this->request->data['TipoServicio'] = $tiposervicio['TipoServicio'];
                $this->request->data['ServicioTecnologico'] = $servicio['ServicioTecnologico'];
            }
            
            
        }/* fin de funcion tiposervicio */
        
        public function empresas_categorias( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'categorias' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('put') || $this->request->is('post') ){

                $this->CategoriasApoyo->deleteAll(array('servicio_id'=>$id));
                foreach( $this->request->data as $categorias ):
                    if( array_key_exists('CategoriasApoyo', $categorias) ){
                        if( array_key_exists('subcategoria_nombre', $categorias['CategoriasApoyo']) && strlen($categorias['CategoriasApoyo']['subcategoria_nombre']) > 1 && !empty($categorias['CategoriasApoyo']['subcategoria_nombre'])): 
                            $this->CategoriasApoyo->create();
                            $this->CategoriasApoyo->save($categorias);
                        endif;
                    }
                endforeach;
                $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de las categor&iacute;as de apoyo se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                $this->redirect(array('action'=>'sectores',$id));
            }
            
            $servicio = $this->ServicioTecnologico->findById($id);
            if( !array_key_exists('ServicioTecnologico', $servicio) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $categorias = $this->CategoriasApoyo->findAllByServicioId($id);
                $seleccionadas = array();
                if( count($categorias) > 0 ):
                    foreach($categorias as $categoria){
                        array_push($seleccionadas,$categoria['CategoriasApoyo']['subcategoria_nombre'] . '__' . $categoria['CategoriasApoyo']['categoria_nombre']);
                    }
                endif;
                $this->set('seleccionadas',$seleccionadas);
                $this->request->data['ServicioTecnologico'] = $servicio['ServicioTecnologico'];
                $this->set('categorias_defecto',$this->categorias_x_defecto);
            }
            
        }/* fin de funcion categorias */
        
        public function empresas_sectores( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'sectores' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('put') || $this->request->is('post') ){

                $this->SectoresApoyo->deleteAll(array('servicio_id'=>$id));
                foreach( $this->request->data as $categorias ):
                    if( array_key_exists('SectoresApoyo', $categorias) ){
                        if( array_key_exists('sector_nombre', $categorias['SectoresApoyo']) && strlen($categorias['SectoresApoyo']['sector_nombre']) > 1 && !empty($categorias['SectoresApoyo']['sector_nombre'])): 
                            $this->SectoresApoyo->create();
                            $this->SectoresApoyo->save($categorias);
                        endif;
                    }
                endforeach;
                $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro de los sectores de apoyo se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                $this->redirect(array('action'=>'empresasservicio',$id));
            }
            
            $servicio = $this->ServicioTecnologico->findById($id);
            if( !array_key_exists('ServicioTecnologico', $servicio) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $categorias = $this->SectoresApoyo->findAllByServicioId($id);
                $seleccionadas = array();
                if( count($categorias) > 0 ):
                    foreach($categorias as $categoria){
                        array_push($seleccionadas,$categoria['SectoresApoyo']['sector_nombre']);
                    }
                endif;
                $this->set('otros',$this->SectoresApoyo->find('first',array('conditions'=>array('SectoresApoyo.otros'=>1))));
                $this->set('seleccionadas',$seleccionadas);
                $this->request->data['ServicioTecnologico'] = $servicio['ServicioTecnologico'];
                $this->set('sectores_defecto',$this->sectores_x_defecto);
            }
            
        }/* fin de funcion sectores */
        
        public function empresas_empresasservicio( $id = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'empresa', 'empresasservicio' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }
            
            if( $this->request->is('put') ):
                // primero ponemos a cero todas las formas de contacto de la empresa.
                $this->EmpresasServicio->save(
                    array(
                        'EmpresasServicio' => array(
                            'microempresa' => 0,
                            'pequenaempresa' => 0,
                            'medianaempresa' => 0,
                            'granempresa' => 0,
                            'emprendedores' => 0,
                            'instituciones' => 0,
                            'id' => $this->request->data['EmpresasServicio']['id']
                        )
                    )
                );
            endif;    
            
            if( $this->request->is('post') || $this->request->is('put') ):
                
                if( $this->EmpresasServicio->save($this->request->data) ){
                    $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del servicio a las empresas se guardo satisfactoriamente.','default',array('class'=>'alert alert-success'));
                    $this->redirect(array('action'=>'index'));
                }else{
                    $this->Session->setFlash('<strong>Error:</strong> No se pudo guardar el registro del servicio a las empresas.','default',array('class'=>'alert alert-danger'));
                }  
            endif;    
            
            $servicio = $this->ServicioTecnologico->findById($id);
            if( !array_key_exists('ServicioTecnologico', $servicio) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirec(array('action'=>'index'));
            }else{
                $empresaservicio = $this->EmpresasServicio->findByServicioId($id);
                if( array_key_exists('EmpresasServicio', $empresaservicio) )$this->request->data['EmpresasServicio'] = $empresaservicio['EmpresasServicio'];
                $this->request->data['ServicioTecnologico'] = $servicio['ServicioTecnologico'];
            }
            
        }/* fin de funcion empresasservicio */
                
        public function empresas_ver( $id = '', $cerrar = '1' ){
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            } 
            
            $servicio = $this->ServicioTecnologico->find('first',
                array(
                    'fields' => array('ServicioTecnologico.*','Empresa.id','Empresa.nombre_empresa'),
                    'conditions' => array('ServicioTecnologico.id'=>$id),
                    'joins' => array(
                        array(
                            'alias' => 'Empresa',
                            'table' => 'empresas',
                            'type' => 'INNER',
                            'conditions' => 'Empresa.id = ServicioTecnologico.empresa_id'
                        )
                    ),
                    'order' => array('ServicioTecnologico.nombre_servicio'=>'asc')
                )
            );
            $empresa_id = $servicio['Empresa']['id'];
            $this->set('servicio',$servicio);
            $this->set('tiposervicio',$this->TipoServicio->findByServicioId($id));
            $this->set('categorias',$this->CategoriasApoyo->findAllByServicioId($id));
            $this->set('sectores',$this->SectoresApoyo->findAllByServicioId($id));
            $this->set('empresaservicio',$this->EmpresasServicio->findByServicioId($id));
            // --------
            $this->set('areas',$this->Area->find('all',array('conditions'=>array('Area.empresa_id'=>$empresa_id),'order'=>array('Area.nombre_area ASC'))));
            $this->set('recursos',$this->RecursosServicio->find('all',array('conditions'=>array('RecursosServicio.empresa_id'=>$empresa_id),'order'=>array('RecursosServicio.nombre_recurso ASC'))));
            $this->set('infraestructuras',$this->Infraestructura->find('all',array('conditions'=>array('Infraestructura.empresa_id'=>$empresa_id),'order'=>array('Infraestructura.nombre_infraestructura ASC'))));
            $this->set('laboratorios',$this->Laboratorio->find('all',array('conditions'=>array('Laboratorio.empresa_id'=>$empresa_id),'order'=>array('Laboratorio.nombre_laboratorio ASC'))));
            $this->set('solicitante',$this->EmpresasSolicitante->find('first',array('conditions'=>array('EmpresasSolicitante.empresa_id'=>$empresa_id))));
            $this->set('contacto',$this->FormasContacto->find('first',array('conditions'=>array('FormasContacto.empresa_id'=>$empresa_id))));
            $this->set('pago',$this->FormasPago->find('first',array('conditions'=>array('FormasPago.empresa_id'=>$empresa_id))));
            $this->set('serviciostecnologicos',$this->ServicioTecnologico->find('all',array('conditions'=>array('ServicioTecnologico.empresa_id'=>$empresa_id),'order'=>array('ServicioTecnologico.nombre_servicio ASC'))));
            // --------
            $this->set('cerrar',$cerrar);
            $this->set('persona',$this->Cookie->read('persona'));
            $this->layout = 'impresion';
            
            
        }/* fin de funcion ver */
        
        public function empresas_imprimir( $filtro = '' ){
            
            $servicios = $this->ServicioTecnologico->find('all',
                array(
                    'fields' => array('ServicioTecnologico.*','Empresa.id','Empresa.nombre_empresa'),
                    'conditions' => array('OR' => array('ServicioTecnologico.nombre_servicio LIKE'=>"%{$filtro}%",'ServicioTecnologico.descripcion_servicio LIKE'=>"%{$filtro}%",'Empresa.nombre_empresa LIKE'=>"{$filtro}%")),
                    'joins' => array(
                        array(
                            'alias' => 'Empresa',
                            'table' => 'empresas',
                            'type' => 'INNER',
                            'conditions' => 'Empresa.id = ServicioTecnologico.empresa_id'
                        )
                    ),
                    'order' => array('ServicioTecnologico.nombre_servicio'=>'asc')
                )
            );
            $this->set('servicios',$servicios);
            $this->layout = 'impresion';
            
        }/* fin de funcion imprimir */
        
        public function empresas_eliminar( $id = '' ){
            
            if( !is_numeric($id) ){
                $this->Session->setFlash('<strong>Error:</strong> No se pudo encontrar el registro del servicio tecnol&oacute;gico.','default',array('class'=>'alert alert-danger'));
                $this->redirect(array('action'=>'index'));
            }   
            
            $ms = $this->MensajesServicio->find('count',array('conditions'=>array('MensajesServicio.servicio_id'=>$id)));
            if( $ms == 0 ){
                // eliminar empresa.
                $this->TipoServicio->deleteAll(array('TipoServicio.servicio_id'=>$id),false);
                $this->CategoriasApoyo->deleteAll(array('CategoriasApoyo.servicio_id'=>$id),false);
                $this->SectoresApoyo->deleteAll(array('SectoresApoyo.servicio_id'=>$id),false);
                $this->EmpresasServicio->deleteAll(array('EmpresasServicio.servicio_id'=>$id),false);
                $this->ServicioTecnologico->delete($id);
                $this->Session->setFlash('<strong>&Eacute;xito!</strong> El registro del servicio tecnol&oacute;gico se elimin&oacute; satisfactoriamente.','default',array('class'=>'alert alert-success'));
            }else{
                $this->Session->setFlash('<strong>Error:</strong> No se pudo eliminar el registro del servicio tecnol&oacute;gico debido a que existen tickets que dependen de el.','default',array('class'=>'alert alert-danger'));
            }
            $this->redirect(array('action'=>'index'));     
                
        }/* fin de funcion eliminar */

     }
?>