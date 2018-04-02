<?php
 /*
 Autor: DIMH@09-08-2014
 */

App::uses('AppModel','Model');
class Empresa extends AppModel{
    public $name = 'Empresa';
    public $useTable = 'empresas';
    public $hasMany = array(
        'Usuario' => array(
            'className' => 'Usuario'
        )
    );
}
?>