<?php
/**
 * List template
 *
 * See BaseController->assignViewVariable() to see how view variables appear
 * in the template
 */
?>

<h1>Show me the widgets</h1>
<?php

?>
<ul>
	<?php foreach ($widgets as  $widget): ?>
		<li><?php echo $widget ?></a></li>
	<?php endforeach; ?>
</ul>