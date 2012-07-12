<?php

// no direct access
defined('_JEXEC') or die ;
?>

<div class="history<?php echo $moduleclass_sfx ?>" >
	<ul>
		<?php
		foreach ($list as $item) 
		{
			$li = '<li>';
			$li .= '<a href="' . $item -> link . '">' . $item -> name . '</a>';
			$li .= '</li>';
			echo $li;
		}
		?>
	</ul>
</div>
