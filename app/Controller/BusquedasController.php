<?php
    /*
     * Autor DIMH@28-08-2014
     * */
     class BusquedasController extends AppController{
         
        public $uses = array('Contribuyente','ActividadesEconomica',
                        'Empresa','RecursosServicio','Area','Infraestructura','Laboratorio','EmpresasSolicitante',
                        'FormasPago','FormasContacto','Departamento','Municipio','Persona','Usuario',
                        'ServicioTecnologico','TipoServicio','SectoresApoyo','CategoriasApoyo','EmpresasServicio','Ticket');
                        
        public $components = array('Session', 'Cookie','Paginator','RequestHandler');
        public $helpers = array('Js','Form','Html','Session','Paginator','Number','Time');
        public $layout = 'default';        
        public $tipo_servicio_x_defecto = array('servicio_tecnologico'=>'Servicio Tecnol&oacute;gico','transferencia_tecnologia'=>'Transferencia de Tecnolog&iacute;a','proyectos_id'=>'Proyectos I+D','proyectos_especiales'=>'Proyectos Especiales','desarrollo_rrhh'=>'Desarrollo de RRHH');
        public $areas_especialidad_x_defecto = array('bachillerato_tecnico'=>'Bachillerato &oacute; T&eacute;nico','licenciatura'=>'Licenciatura (o Ingenier&iacute;a)','maestria'=>'Maestr&iacute;a','doctorado'=>'Doctorado');
        public $tipos_laboratorios_x_defecto = array('experimentacion'=>'Experimentaci&oacute;n &oacute; Pr&aacute;cticas','investigacion'=>'Investigaci&oacute;n','investigacion_desarrollo'=>'Investigaci&oacute;n y Desarrollo','pruebas_ensayos'=>'Pruebas y Ensayos');
        public $categorias_x_defecto = array(
            'Recursos Humanos' => array('Asesoría Técnica','Capacitación','Becas','Certificación','Formación','Consultoría'),
            'Financiamiento y Aspectos Legales' => array('Asesoría Financiera','Auditoría','Créditos','Cofinanciamientos','Donaciones','Fondos/Grants','Asesoría Legal','Capacitación','Formalización','Empresas/Entidades','Propiedad Intelectual','Contratos','Mercado de Capitales'),
            'Comercialización y Mercado' => array('Consultoría','Inteligencia Mercado','Inteligencia Competitiva','Intermediación (Brokerage)','Comercio Electrónico','Logística','Marketing','Capacitación'),
            'Servicios Técnicos/Tecnológicos' => array('Pruebas Laboratorio','Certificación','I+D','Transferencia de Tecnolog&iacute;a','Consultoría','Servicios de TI','Adapt. de tecnología','Áreas Sistema nacional de Calidad (NMPART)'),
            'Generación Empresas' => array('Incubación de Empresas','Emprendimiento'),
            'Redes' => array('Contactos Temáticos y de Negocios en el Exterior','Contactos Asociaciones Internacionales','Contactos Redes de proveedores')
        );
        public $sectores_x_defecto = array('Alimentos y Bebidas','Industria Farmacéutica','Acuaindustria (Acuicultura)','Diseño','Energía','Agroindustria','Metalmecánica','Textiles y Confección','TICs','Mecatrónica','Servicios','Salud','Comercial','Logística');
        public $tipoempresa_x_defecto = array('microempresa'=>'Micro empresa','pequenaempresa'=>'Peque&ntilde;a empresa','medianaempresa'=>'Mediana empresa','granempresa'=>'Gran empresa','emprendedores'=>'Emprendedores','instituciones'=>'Instituciones');
        
        public function beforeRender(){
            parent::beforeRender();
            $this->set('menu_activo','buscar');
        }
        
        public function index( $ticket_id = 0 ){
            
            $this->set('tipo_servicio_x_defecto',$this->tipo_servicio_x_defecto);
            $this->set('areas_especialidad_x_defecto',$this->areas_especialidad_x_defecto);
            $this->set('tipos_laboratorios_x_defecto',$this->tipos_laboratorios_x_defecto);
            $this->set('categorias_x_defecto',$this->categorias_x_defecto);
            $this->set('sectores_x_defecto',$this->sectores_x_defecto);
            $this->set('tipoempresa_x_defecto',$this->tipoempresa_x_defecto);
            $this->set('departamentos',$this->Departamento->find('list',array('fields'=>array('Departamento.id','Departamento.nombre_departamento'),'order'=>array('Departamento.nombre_departamento ASC'))));
            $this->set('ticket_id',$ticket_id);
            $this->set('usuario',$this->Usuario->findByUsuario($this->Cookie->read('usuario')));
            
        }/* fin de funcion index */
        
        public function buscar(){
            
            $persona = $this->Cookie->read('persona');
            $modulos = $this->Cookie->read('modulos');
            //excluir empresa solicitante.
            if( $_POST['ticket_id'] != 0 ){
            	$ticket = $this->Ticket->findById($_POST['ticket_id']);
            	$excluir_empresa = $ticket['Ticket']['empresa_id'];
            }else{
                $excluir_empresa = 0;
            }
            if($persona['Usuario']['isadmin'] == 1){
                $fields = array('ServicioTecnologico.*','Empresa.*');
            }else{
                $fields = array('ServicioTecnologico.*');
            }
            // se verifica que existan filtros, de lo contrario es busqueda simple 
            if( !array_key_exists('tipo_servicio', $_POST) &&
                    !array_key_exists('areas', $_POST) &&
                    !array_key_exists('laboratorios', $_POST) &&
                    !array_key_exists('sectores', $_POST) &&
                    !array_key_exists('subcategorias', $_POST) &&
                    !array_key_exists('departamentos', $_POST) &&
                    !array_key_exists('tipo_empresa', $_POST) ){ // busqueda simple
                
                $filtro = $_POST['filtro'];
                
				if( in_array('empresa', $modulos) ){
	                $resultados = $this->ServicioTecnologico->find('all',array(
	                        'fields' => array('ServicioTecnologico.*','Empresa.*'),
	                        'conditions' => array(
	                            'OR' => array(
	                                'Empresa.nombre_empresa LIKE'=>"{$filtro}%",
	                                'Empresa.nit LIKE'=>"{$filtro}%",
	                                'ServicioTecnologico.nombre_servicio LIKE'=>"%{$filtro}%",
	                                'ServicioTecnologico.descripcion_servicio LIKE'=>"%{$filtro}%"
	                            ),
	                            'NOT' => array(
	                            	'Empresa.id' => $excluir_empresa
	                            )
	                        ),
	                        'joins' => array(
	                            array(
	                                'alias'=>'Empresa',
	                                'table'=>'empresas',
	                                'type'=>'INNER',
	                                'conditions'=>'ServicioTecnologico.empresa_id = Empresa.id'
	                            )
	                        ),
	                        'order' => array('ServicioTecnologico.nombre_servicio ASC','Empresa.nombre_empresa ASC')
	                    )
	                );
	        	}else{
		        	$resultados = $this->ServicioTecnologico->find('all',array(
	                        'fields' => array('ServicioTecnologico.*'),
	                        'conditions' => array(
	                            'OR' => array(
	                                'Empresa.nombre_empresa LIKE'=>"{$filtro}%",
	                                'Empresa.nit LIKE'=>"{$filtro}%",
	                                'ServicioTecnologico.nombre_servicio LIKE'=>"%{$filtro}%",
	                                'ServicioTecnologico.descripcion_servicio LIKE'=>"%{$filtro}%"
	                            ),
	                            'NOT' => array(
	                            	'Empresa.id' => $excluir_empresa
	                            )
	                        ),
	                        'joins' => array(
	                            array(
	                                'alias'=>'Empresa',
	                                'table'=>'empresas',
	                                'type'=>'INNER',
	                                'conditions'=>'ServicioTecnologico.empresa_id = Empresa.id'
	                            )
	                        ),
	                        'order' => array('ServicioTecnologico.nombre_servicio ASC')
	                    )
	                );
	        	}        
            }else{ // busqueda avanzada
                $filtro = $_POST['filtro'];
                $servicios = array();
                $empresas = array();
                
                // 1. tipo de servicio
                if( array_key_exists('tipo_servicio', $_POST) ){
                    $c_tiposervicio = array();
                    foreach($_POST['tipo_servicio'] as $ts){ $c_tiposervicio["TipoServicio.{$ts}"] = 1; }
                    $tiposervicio = $this->TipoServicio->find('all',array(
                        'conditions'=>array('OR'=>$c_tiposervicio),
                        'fields'=>array('DISTINCT TipoServicio.servicio_id')
                    ));
                    foreach( $tiposervicio as $tipo_s ){
                        if( array_search($tipo_s['TipoServicio']['servicio_id'], $servicios) === FALSE ):
                            array_push($servicios,$tipo_s['TipoServicio']['servicio_id']);
                        endif;    
                    }// fin de agregar valores
                }
                // 2. areas de especialidad
                if( array_key_exists('areas', $_POST) ){
                    $c_areas = array();
                    foreach($_POST['areas'] as $ars){ $c_areas["Area.{$ars} >"] = 0; }
                    $areas = $this->Area->find('all',array(
                        'conditions'=>array('OR'=>$c_areas),
                        'fields'=>array('DISTINCT Area.empresa_id')
                    ));
                    foreach( $areas as $area ){
                        if( array_search($area['Area']['empresa_id'],$empresas) === FALSE ):
                            array_push($empresas,$area['Area']['empresa_id']);
                        endif;
                    }// fin de agregar valores
                }
                // 3. laboratorios
                if( array_key_exists('laboratorios', $_POST) ){
                    $c_laboratorios = array();
                    foreach($_POST['laboratorios'] as $lab){ $c_laboratorios["Laboratorio.{$lab}"] = 1; }
                    $laboratorios = $this->Laboratorio->find('all',array(
                        'conditions'=>array('OR'=>$c_laboratorios),
                        'fields'=>array('DISTINCT Laboratorio.empresa_id')
                    ));
                    foreach( $laboratorios as $laboratorio ){
                        if( array_search($laboratorio['Laboratorio']['empresa_id'],$empresas) === FALSE ):
                            array_push($empresas,$laboratorio['Laboratorio']['empresa_id']);
                        endif;
                    }// fin de agregar valores
                }
                // 4. sectores
                if( array_key_exists('sectores', $_POST) ){
                    $sectores = $this->SectoresApoyo->find('all',array(
                        'conditions'=>array('SectoresApoyo.sector_nombre'=>$_POST['sectores']),
                        'fields'=>array('DISTINCT SectoresApoyo.servicio_id')
                    ));
                    foreach( $sectores as $sector ){
                        if( array_search($sector['SectoresApoyo']['servicio_id'],$servicios) === FALSE ):
                            array_push($servicios,$sector['SectoresApoyo']['servicio_id']);
                        endif;
                    }//fin de agregar valores
                }
                // 5. subcategorias
                if( array_key_exists('subcategorias', $_POST) ){
                    $subcategorias = $this->CategoriasApoyo->find('all',array(
                        'conditions'=>array('CategoriasApoyo.subcategoria_nombre'=>$_POST['subcategorias']),
                        'fields'=>array('DISTINCT CategoriasApoyo.servicio_id')
                    ));
                    foreach( $subcategorias as $subcategoria ){
                        if( array_search($subcategoria['CategoriasApoyo']['servicio_id'],$servicios) === FALSE ):
                            array_push($servicios,$subcategoria['CategoriasApoyo']['servicio_id']);
                        endif;
                    }//fin de agregar valores
                }
                // 6. tipo de empresa
                if( array_key_exists('tipo_empresa', $_POST) ){
                    $c_tipoempresa = array();
                    foreach($_POST['tipo_empresa'] as $te){ $c_tipoempresa["EmpresasServicio.{$te}"] = 1; }
                    $tipoempresa = $this->EmpresasServicio->find('all',array(
                        'conditions'=>array('OR'=>$c_tipoempresa),
                        'fields'=>array('DISTINCT EmpresasServicio.servicio_id')
                    ));
                    foreach( $tipoempresa as $t_em ){
                        if( array_search($t_em['EmpresasServicio']['servicio_id'], $servicios) === FALSE ):
                            array_push($servicios,$t_em['EmpresasServicio']['servicio_id']);
                        endif;
                    }//fin de agregar valores
                }
                // 7. departamento
                if( array_key_exists('departamentos', $_POST) ){
                    $departamento = $this->Municipio->find('all',array(
                        'conditions'=>array('Municipio.departamento'=>$_POST['departamentos']),
                        'joins'=>array(
                            array(
                                'alias'=>'Empresa',
                                'table'=>'empresas',
                                'type'=>'INNER',
                                'conditions'=>'Municipio.id = Empresa.direccion_municipio'
                            )
                        ),
                        'fields'=>array('DISTINCT Empresa.id')
                    ));
                    foreach( $departamento as $depto ){
                        if( array_search($depto['Empresa']['id'],$empresas) === FALSE ):
                            array_push($empresas,$depto['Empresa']['id']);
                        endif;
                    }//fin de agregar valores
                }
                
                //consultar
				// verificar si se encontraron servicios
                if( (count($servicios) == 0 && count($empresas) == 0) && strlen(chop($filtro)) > 5 ){ //ningun resultado
                    $conditions = array('OR' => array('Empresa.nombre_empresa LIKE'=>"{$filtro}%",'Empresa.nit LIKE'=>"{$filtro}%",'ServicioTecnologico.nombre_servicio LIKE'=>"%{$filtro}%",'ServicioTecnologico.descripcion_servicio LIKE'=>"%{$filtro}%"),'NOT' => array('Empresa.id' => $excluir_empresa));
                }elseif( count($servicios) > 0 && count($empresas) > 0 ){ // 
                    $conditions = array('ServicioTecnologico.id' => $servicios,'Empresa.id' => $empresas,'NOT' => array('Empresa.id' => $excluir_empresa));
                }elseif( count($servicios) == 0 && count($empresas) == 0 && strlen(chop($filtro)) == 0 ){
                    $conditions = array('ServicioTecnologico.id' => $servicios,'Empresa.id' => $empresas,'NOT' => array('Empresa.id' => $excluir_empresa));
                }elseif( (count($servicios) == 0 && count($empresas) > 0) || (count($servicios) > 0 && count($empresas) == 0) ){
                    $conditions = array('OR' => array('ServicioTecnologico.id'=>$servicios,'Empresa.id'=>$empresas),'NOT' => array('Empresa.id' => $excluir_empresa));
                }else{
                    $conditions = array('ServicioTecnologico.id' => $servicios,'Empresa.id' => $empresas,'NOT' => array('Empresa.id' => $excluir_empresa));   
                }	
				if( in_array('empresa', $modulos) ){

	                $resultados = $this->ServicioTecnologico->find('all',array(
	                        'fields' => array('ServicioTecnologico.*','Empresa.*'),
	                        'conditions' => $conditions,
	                        'joins' => array(
	                            array(
	                                'alias'=>'Empresa',
	                                'table'=>'empresas',
	                                'type'=>'INNER',
	                                'conditions'=>'ServicioTecnologico.empresa_id = Empresa.id'
	                            )
	                        ),
	                        'order' => array('ServicioTecnologico.nombre_servicio ASC','Empresa.nombre_empresa ASC')
	                    )
	                );
				}else{
					$resultados = $this->ServicioTecnologico->find('all',array(
	                        'fields' => array('ServicioTecnologico.*'),
	                        'conditions' => $conditions,
	                        'order' => array('ServicioTecnologico.nombre_servicio ASC')
	                    )
	                );
				}// fin de permisos
            }
            $this->set(array('resultados'=>$resultados,'_serialize'=>'resultados'));
        }
         
     }
?>