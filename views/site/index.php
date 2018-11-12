<?php  

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<?php foreach ($models as $model): ?>

<article class="post">
    <div class="post-thumb">
        <a href="<?= Url::toRoute(['/site/view', 'id' => $model->id]) ?>">
            <img src="<?= Url::base(true) . $model->getImage() ?>" alt="">
        </a>

        <a href="<?= Url::toRoute(['/site/view', 'id' => $model->id]) ?>" class="post-thumb-overlay text-center">
            <div class="text-uppercase text-center">View Post</div>
        </a>
    </div>
    <div class="post-content">
        <header class="entry-header text-center text-uppercase">
            <h6>
                <a href="#category"><?= $model->category->title ?></a>
            </h6>

            <h1 class="entry-title">
                <a href="<?= Url::toRoute(['/site/view', 'id' => $model->id]) ?>"><?= $model->title ?></a>
            </h1>

        </header>
        <div class="entry-content">
            <p><?= $model->description ?></p>

            <div class="btn-continue-reading text-center text-uppercase">
                <a href="<?= Url::toRoute(['/site/view', 'id' => $model->id]) ?>" class="more-link">Continue Reading</a>
            </div>
        </div>
        <div class="social-share">
            <span class="social-share-title pull-left text-capitalize">By <a href="#">Rubel</a> <?= $model->getCreated() ?></span>
            <ul class="text-center pull-right">
                <li>
                    <a class="s-facebook" href="#">
                        <i class="fa fa-eye"></i>
                    </a>
                </li>
                <?= $model->viewed ?>
            </ul>
        </div>
    </div>
</article>

<?php endforeach; ?>

<?php  

echo LinkPager::widget([
    'pagination' => $pages,
]);

?>