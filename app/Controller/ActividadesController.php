<?php
    /*
     * Autor DIMH@13-08-2014
     * */
    class ActividadesController extends AppController{
        public $uses = array('ActividadesEconomica');
        public $components = array('Session', 'Cookie','Paginator');
        public $helpers = array('Js','Form','Html','Session','Paginator');
        public $layout = 'default';
        public $paginate = array(
                'fields' => array('ActividadesEconomica.actividad_principal','ActividadesEconomica.subactividad','ActividadesEconomica.actividad_nombre','ActividadesEconomica.actividad_codigo'),
                'limit' => PER_PAGE,
                'order' => array('actividad_codigo' => 'asc')
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
           $this->set('actividades',$this->Paginator->paginate($this->ActividadesEconomica,array(
                'OR' => array(
                    'ActividadesEconomica.actividad_principal LIKE'=>"%{$filtro}%",
                    'ActividadesEconomica.subactividad LIKE'=>"%{$filtro}%",
                    'ActividadesEconomica.actividad_nombre LIKE'=>"%{$filtro}%",
                    'ActividadesEconomica.actividad_codigo LIKE'=>"%{$filtro}%"
                )
           )));
           $this->set('filtro',$filtro);
            
        }/* fin de funcion index */
        
        public function admin_importar(){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'importar' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            if( $this->request->is('post') ){
                if( $_FILES['archivo'] && $_FILES['archivo']['error'] == UPLOAD_ERR_OK ):
                   
                    if(strtolower($_FILES['archivo']['type']) == 'text/csv'){
                        $data = $this->Csv->import($_FILES['archivo']['tmp_name'],
                            array(
                                'ActividadesEconomica.actividad_codigo',
                                'ActividadesEconomica.actividad_nombre',
                                'ActividadesEconomica.subactividad',
                                'ActividadesEconomica.actividad_principal'
                            )
                        );
                        if( is_array($data) && count($data) > 1 ){
                            // guardar datos
                            array_shift($data); // se remueve la fila de cabeceras.
                            foreach( $data as $actividad ):
                                $this->ActividadesEconomica->deleteAll(array('actividad_codigo'=>$actividad['ActividadesEconomica']['actividad_codigo']));
                                $this->ActividadesEconomica->create();
                                $this->ActividadesEconomica->save($actividad);
                            endforeach;   
                            $this->Session->setFlash('<strong>&Eacute;xito!</strong> Las actividades econ&oacute;micas se importaron correctamente.','default',array('class'=>'alert alert-success'));
                            $this->redirect(array('action'=>'admin_index')); 
                        }else{
                            $this->Session->setFlash('<strong>Error:</strong> El archivo que est&aacute; tratando de adjuntar no contiene el formato v&aacute;lido de importaci&oacute;n.','default',array('class'=>'alert alert-danger'));
                        }
                    }else{
                        $this->Session->setFlash('<strong>Error:</strong> El archivo que est&aacute; tratando de adjuntar no es v&aacute;lido.','default',array('class'=>'alert alert-danger'));
                    }
                endif;
            }
             
        }/* fin de funcion importar */
        
        public function admin_imprimir( $filtro = ''){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'imprimir' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
               
           $this->set('actividades',$this->ActividadesEconomica->find('all',array(
                'conditions'=>array(
                    'OR' => array(
                        'ActividadesEconomica.actividad_principal LIKE'=>"%{$filtro}%",
                        'ActividadesEconomica.subactividad LIKE'=>"%{$filtro}%",
                        'ActividadesEconomica.actividad_nombre LIKE'=>"%{$filtro}%",
                        'ActividadesEconomica.actividad_codigo LIKE'=>"%{$filtro}%"
                    )
                ),
                'order' => array('actividad_codigo' => 'asc')
           )));
           $this->layout = 'impresion';
        }
    }
?>