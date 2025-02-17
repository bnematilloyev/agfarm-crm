<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
backend\assets\AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="gray">
    <?php $this->beginBody() ?>
    <div id="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>
        <!-- Dashboard Container -->
        <div class="dashboard-container">

            <?= $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?= $this->render(
                'content.php',
                ['content' => $content, 'directoryAsset' => $directoryAsset]
            ) ?>

            <?php if (Yii::$app->user->identity->is_creator) echo $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>
        </div>
    </div>
    <?php
    $auth_key = (!Yii::$app->user->isGuest ? Yii::$app->user->identity->auth_key : '');
//    $locationSendingTimeInterval = Yii::$app->params['location-sending-time-interval'] * 60 * 1000;
    $js = <<<JS
//        var current_user_token = '$auth_key';
//        getCurrentLocation();
//        setInterval(function() {getCurrentLocation();}, locationSendingTimeInterval);//this method works
//        function getCurrentLocation() {
//            if (navigator.geolocation) {
//              navigator.geolocation.getCurrentPosition(showPosition);
//            } else {
//              console.log("Geolocation is not supported by this browser.");
//            }
//        } 
//        function showPosition(position) {
//            console.log(position);
//          var latitude = position.coords.latitude;
//          var longitude = position.coords.longitude;
//           // $.ajax({
//           //          url: "https://api.abrand.uz/v2/administrator/update-location?token="+current_user_token+"&lat="+latitude+"&lng="+longitude,
//           //          type: 'GET',
//           //          success: function(result) {
//           //              console.log(result);
//           //          }               
//           //  });
//        }
    $('.js-clipboard-button').on('click', function() {
     var textArea = document.createElement("textarea");
        textArea.value = $(this).data("pin");
        document.body.appendChild(textArea);
         textArea.select();
      document.execCommand("copy");
         textArea.remove();
      window.open($(this).data("link"), '_blank');
    });

    $('.tags-input').css('width', '100%');
    $('.tags-input').css('height', '33px');
// if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
    $('table').parent('div').css('overflow-x', 'auto');
    
    
    	// ______________Full screen
	$("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })
	
    
    var leftSidebarBtn = $('.left-sidebar-btn');
    var rightSidebarBtn = $('.right-sidebar-btn');

    var leftSidebar = $('.dashboard-sidebar.left-sidebar');
    var rightSidebar = $('.dashboard-sidebar.right-sidebar');
    var dashboardContent = $('.dashboard-content-container');

    leftSidebarBtn.on('click', function () {
        leftSidebar.toggleClass('opened');
        dashboardContent.toggleClass('left-sidebar-opened');

        if (dashboardContent.hasClass('right-sidebar-opened')) {
            dashboardContent.removeClass('right-sidebar-opened');
            rightSidebar.removeClass('opened');
        }
    })

    rightSidebarBtn.on('click', function () {
        rightSidebar.toggleClass('opened');
        dashboardContent.toggleClass('right-sidebar-opened');

        if (dashboardContent.hasClass('left-sidebar-opened')) {
            dashboardContent.removeClass('left-sidebar-opened');
            leftSidebar.removeClass('opened');
        }
    })    

JS;
    $this->registerJs($js);
    ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>