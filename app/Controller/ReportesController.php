<?php
    /*
     * Autor DIMH@27-08-2014
     * */
     class ReportesController extends AppController{
        public $uses = array('Ticket','Empresa','Municipio','Departamento','ServicioTecnologico','Mensaje',
        'MensajesAdjunto','MensajesServicio','CriteriosAceptacion','CriteriosCategoria','CriteriosSatisfaccion',
        'CriteriosTicket','Contrato','Persona','Usuario');
        public $components = array('Session', 'Cookie','Paginator','RequestHandler');
        public $helpers = array('Js','Form','Html','Session','Paginator','Number','Time');
        public $layout = 'default';
        public $estados = array('abierto'=>'Abierto','cerrado'=>'Cerrado','en espera'=>'En espera','finalizado con exito'=>'Finalizado con &eacute;xito','cancelado por el administrador'=>'Cancelado por el administrador','cancelado por el cliente'=>'Cancelado por el cliente','cancelado por el oferente'=>'Cancelado por el oferente');
        public $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
       
        // paginaciones
        // Usuarios
        public $usuarios_paginate = array(
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
        // Tickets
        public $tickets_paginate = array(
            'fields' => array('Ticket.*'),
            'limit' => PER_PAGE,
            'order' => array('Ticket.fecha_apertura DESC')
        );
        // empresas
        public $empresas_paginate = array(
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
        // Servicios tecnologicos
        public $servicios_paginate = array(
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
        
        public function beforeRender(){
            parent::beforeRender();
            $this->set('menu_activo','reportes');
        }
        
        public function usuarios( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'reporte', 'usuarios' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        	
            $this->Paginator->settings = $this->usuarios_paginate;
            $this->set('personas',$this->Paginator->paginate($this->Persona,
                    array('OR' =>
                        array('Persona.primer_nombre LIKE'=>"{$filtro}%",'Persona.primer_apellido LIKE'=>"{$filtro}%",'Persona.correo_electronico LIKE'=>"{$filtro}%",'Usuario.usuario LIKE'=>"{$filtro}%")
                    )    
            ));
            $this->set('filtro',$filtro);
	        
        }/* fin de usuarios */
        
        public function empresas( $filtro = '' ){
	        // verificar permisos
        	if( $this->checkPermissions( 'reporte', 'empresas' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            $this->Paginator->settings = $this->empresas_paginate;
            $this->set('empresas',$this->Paginator->paginate($this->Empresa,array(
                    'OR' => 
                        array('Empresa.nombre_empresa LIKE'=>"%{$filtro}%",'Empresa.nit LIKE'=>"%{$filtro}%",'Empresa.numero_registro LIKE'=>"%{$filtro}%")
                )
            ));
            $this->set('filtro',$filtro);
        }/* fin de empresas */
        
        public function servicios( $filtro = '' ){
	        // verificar permisos
        	if( $this->checkPermissions( 'reporte', 'servicios' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
            $this->Paginator->settings = $this->servicios_paginate;
            $this->set('servicios',$this->Paginator->paginate($this->ServicioTecnologico,array(
                    'OR' => 
                        array('ServicioTecnologico.nombre_servicio LIKE'=>"%{$filtro}%",'ServicioTecnologico.descripcion_servicio LIKE'=>"%{$filtro}%",'Empresa.nombre_empresa LIKE'=>"{$filtro}%")
                )
            ));
            $this->set('filtro',$filtro);
        }/* fin de servicios */
        
        public function tickets( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'reporte', 'tickets' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        	
        	$this->set('tickets',$this->Paginator->paginate($this->Ticket,
                array('OR'=>array('Ticket.ficha_proyecto LIKE'=>"%{$filtro}%")
                )
            ));
            $this->set('filtro',$filtro);
            $this->set('estados',$this->estados);
	        
        }/* fin de tickets */
     }
?>   