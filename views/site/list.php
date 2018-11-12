<?php  

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<?php foreach ($models as $model): ?>

<article class="post post-list">
    <div class="row">
        <div class="col-md-6">
            <div class="post-thumb">
                <a href="#">
                    <img src="<?= Url::base(true) . $model->getImage() ?>" alt="" class="pull-left">
                </a>

                <a href="#" class="post-thumb-overlay text-center">
                    <div class="text-uppercase text-center">View Post</div>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="post-content">
                <header class="entry-header text-uppercase">
                    <h6><a href="#"> <?= $model->category->title ?></a></h6>

                    <h1 class="entry-title">
                        <a href="#"><?= $model->title ?></a>
                    </h1>
                </header>
                <div class="entry-content">
                    <p><?= $model->description ?></p>
                </div>
                <div class="social-share">
                    <span class="social-share-title pull-left text-capitalize">By Rubel On <?= $model->getCreated() ?></span>

                </div>
            </div>
        </div>
    </div>
</article>

<?php endforeach; ?>

<?php  

echo LinkPager::widget([
    'pagination' => $pages,
]);

?>