<?php
App::uses('AppModel', 'Model');
/**
 * MensajesServicio Model
 *
 */
class MensajesServicio extends AppModel {

	public $belongsTo = array(
		'ServicioTecnologico' => array(
			'className' => 'ServicioTecnologico',
			'foreignKey' => 'servicio_id'
		)
	);

}
