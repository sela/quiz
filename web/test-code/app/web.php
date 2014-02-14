<?php
require __DIR__.'/Widgets/actions/WidgetController.class.php';


$this->getRequestParameter();

if (!is_callable($c = @$_GET['c'] ?: function() { echo 'Woah!'; }))
  throw new Exception('Error');
$c();

