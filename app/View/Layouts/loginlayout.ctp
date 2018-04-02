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
	<?php echo $this->Html->css( array('fonts','bootstrap','font-awesome.min','general','validetta','login') )?>
	<?php echo $this->Html->script( array('jquery.min','bootstrap','jquery.inputmasked','validetta-min','jquery.md5') )?>
	<title>Infosistema &mdash; <?php echo Configure::read('Institucion.nombre')?></title>
</head>
<body>
    <div class="container-fluid">
        <?php echo $this->fetch('content')?>
    </div>
</body>
</html>