<?php
/**
 * @var array $article
 */
?>
<h1><a href="/article/<?= $article['link'] ?>"><?= $article['title'] ?></a></h1>
<span class="date-created"><?= $article['dt_created'] ?></span>
<div class="article-content">
	<?= $article['content'] ?>
</div>