<?php
App::uses('AppModel', 'Model');
/**
 * Mensaje Model
 *
 */
class Mensaje extends AppModel {
    
    public $hasMany = array(
        'MensajesAdjunto' => array(
            'className'=>'MensajesAdjunto',
            'foreignKey'=>'mensaje_id'
        ),
        'MensajesServicio' => array(
        	'className' => 'MensajesServicio',
        	'foreignKey' => 'mensaje_id'
        )
    );

}
