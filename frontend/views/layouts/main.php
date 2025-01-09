<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="//code.tidio.co/ivvd2qzldgm1pgrbjkszioyfpi90rtug.js" async></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'uz', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- page wrapper start -->

<div class="page-wrapper">

    <!-- preloader start -->

    <div id="ht-preloader">
        <div class="loader clear-loader">
            <div class="loader-text">Loading</div>
            <div class="loader-dots"><span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- preloader end -->

    <?= $this->render('header.php') ?>

    <?= $this->render('content.php', ['content' => $content]) ?>

    <?= $this->render('footer.php') ?>

</div>

<!--back-to-top start-->

<div class="scroll-top"><a class="smoothscroll" href="#top"><i class="flaticon-upload"></i></a></div>

<!--back-to-top end-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
