<?php
/*
 * Autor: DIMH@09-08-2014
 */ 
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
	<?php echo $this->Html->css( array('fonts','bootstrap','font-awesome.min','footable.core','jquery.raty','general','validetta','summernote','jquery.fancybox') )?>
	<?php echo $this->Html->script( array('jquery.min','bootstrap','jquery.inputmasked','footable','jquery.raty','general','validetta-min','jquery.md5','typeahead.bundle.min','bloodhound.min','summernote.min','jquery.number.min','jquery.fancybox') )?>
	<title>Infosistema &mdash; <?php echo Configure::read('Institucion.nombre')?></title>
</head>
<body>
    <?php echo $this->element('menu/default')?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->element('breadcrumb')?>
            </div>
        </div>
        <?php echo $this->fetch('content')?>
    </div>
    <br /><br />
</body>
</html>