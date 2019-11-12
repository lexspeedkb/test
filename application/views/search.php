<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<ul>
<?php foreach ($results as $resultItem): ?>
	<li><a href="<?=$resultItem['href']?>"><?=$resultItem['title']?></a> </li>
<?php endforeach ?>
</ul>