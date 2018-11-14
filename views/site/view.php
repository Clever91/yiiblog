<?php 

use yii\helpers\Url; 
// use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<article class="post">
    <div class="post-thumb">
        <a href="<?= $model->getViewLink(); ?>">
            <img src="<?= $model->getImage(); ?>" alt="">
        </a>
    </div>
    <div class="post-content">
        <header class="entry-header text-center text-uppercase">
            <h6>
                <a href="<?= $model->category->getViewLink() ?>"> 
                    <?= $model->category->title ?>
                </a>
            </h6>

            <h1 class="entry-title">
                <a href="<?= $model->getViewLink() ?>"
                    ><?= $model->title ?>
                </a>
            </h1>

        </header>
        <div class="entry-content">
            <p><?= $model->content ?></p>
        </div>
        <div class="decoration">
        	
        	<?php foreach ($model->tags as $tag): ?>
            
            <a href="<?= $tag->getViewLink() ?>" class="btn btn-default">
            	<?= $tag->title ?>
            </a>

        	<?php endforeach; ?>

        </div>

        <div class="social-share">
			<span class="social-share-title pull-left text-capitalize">By <?= $model->user->name ?> On <?= $model->getCreated(); ?></span>
            <ul class="text-center pull-right">
                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</article>

<div class="top-comment"><!--top comment-->
    <img src="<?= Url::base(true) ?>/images/comment.jpg" class="pull-left img-circle" alt="">
    <h4>Rubel Miah</h4>

    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy hello ro mod tempor
        invidunt ut labore et dolore magna aliquyam erat.</p>
</div><!--top comment end-->

<div class="row"><!--blog next previous-->
    <?php if (!is_null($preview)): ?>
    <div class="col-md-6">
        <div class="single-blog-box">
            <a href="<?= $preview->getViewLink(); ?>">
                <img src="<?= $preview->getImage(); ?>" alt="" style="width: 250px">

                <div class="overlay">
                    <div class="promo-text">
                        <p><i class="pull-right fa fa-angle-left"></i></p>
                        <h5><?= $preview->title ?></h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <?php if (!is_null($next)): ?>
    <div class="col-md-6">
        <div class="single-blog-box">
            <a href="<?= $next->getViewLink(); ?>">
                <img src="<?= $next->getImage(); ?>" alt="" style="width: 250px">

                <div class="overlay">
                    <div class="promo-text">
                        <p><i class=" pull-right fa fa-angle-right"></i></p>
                        <h5><?= $next->title ?></h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
</div><!--blog next previous end-->

<?php if (!is_null($likes) && !empty($likes)): ?>

<div class="related-post-carousel"><!--related post carousel-->
    <div class="related-heading">
        <h4>You might also like</h4>
    </div>
    <div class="items">

        <?php foreach ($likes as $like): ?>

        <div class="single-item">
            <a href="<?= $like->getViewLink() ?>">
                <img src="<?= $like->getImage() ?>" alt="" style="width: 210px">

                <p><?= $like->title ?></p>
            </a>
        </div>

        <?php endforeach; ?>

    </div>
</div><!--related post carousel-->

<?php endif; ?>

<?php if (count($comments)): ?>

<div class="bottom-comment"><!--bottom comment-->
    <h4><?= count($comments) ?> comments</h4>

    <?php foreach ($comments as $reply): ?>

    <div class="col-md-12">
        <div class="comment-img">
            <img class="img-circle" src="<?= Url::base(true) ?>/images/comment-img.jpg" alt="" style="width: 50px">
        </div>

        <div class="comment-text">
            <a href="#" class="replay btn pull-right"> Replay</a>
            <h5><?= $reply->user->name ?></h5>

            <p class="comment-date">
                <?= $reply->getCreated(); ?>
            </p>

            <p class="para"><?= $reply->text; ?></p>
        </div>
    </div>

    <?php endforeach; ?>

</div>
<!-- end bottom comment-->

<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>

<div class="leave-comment"><!--leave comment-->

    <h4>Leave a reply</h4>

        <?php $form = ActiveForm::begin([
            'id' => 'comment-form', 
            'class' => 'form-horizontal comment-form', 
            'method' => 'post',
            'action' => Url::toRoute('/site/comment')
        ]) ?>

        <div class="form-group">
            <div class="col-md-12">
                <?= $form->field($comment, 'text')->textArea(['rows' => 4, 'placeholder' => "write comment is here..."])->label(false) ?>
            </div>
        </div>

        <?= Html::activeHiddenInput($comment, 'user_id'); ?>
        <?= Html::activeHiddenInput($comment, 'article_id'); ?>

        <?= Html::submitButton('Post Comment', ['class' => "btn send-btn", 'name' => "submit"]) ?>

        <?php ActiveForm::end(); ?>
    </form>
</div><!--end leave comment-->

<?php endif; ?>