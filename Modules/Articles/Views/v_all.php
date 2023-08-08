<?php foreach ($articles as $article): ?>
    <div class="article-item">
        <h2><?=$article['title']?></h2>
        <div class="dt"><?=$article['dt_add']?></div>
        <div class="link">
            <a href="<?=BASE_URL?>article/<?=$article['id_article']?>">Read more...</a>
        </div>
        <hr>
<?php endforeach; ?>