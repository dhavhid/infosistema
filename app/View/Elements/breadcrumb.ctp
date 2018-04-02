<?php
    echo $this->Html->getCrumbList(array('class'=>'breadcrumb','lastClass'=>'active'),array(
        'text' => '<i class="fa fa-home"></i>',
        'url' => '/',
        'escape' => false
    ));
?>