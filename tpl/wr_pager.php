<?php if ($wr_pager) { ?>
<div class='pager'>
	<?php 
		foreach ($wr_pager as $p) { 
			$start = '';
			if ($p['start'] > 0) { $start = "start=".$p['start']; }
			echo "<a href='?$start'>";
			if ($p['current']) { echo "<b>"; }
			echo $p['num'];
			if ($p['current']) { echo "</b>"; }
			echo "</a>";
		}
	?>
</div>
<?php } ?>
