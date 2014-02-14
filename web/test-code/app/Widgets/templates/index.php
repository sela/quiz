<?php
/**
 * Index template
 */
?>

<h1>Show me the widgets</h1>
<?php

?>
<ul>
	<?php foreach ($letters as $letter => $label): ?>
		<li><a href="/widgets/list?letter=<?php echo $letter ?>"><?php echo $label ?></a></li>
	<?php endforeach; ?>
</ul>