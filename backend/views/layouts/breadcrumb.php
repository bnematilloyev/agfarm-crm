<?php

use yii\helpers\Html;

?>
<!-- Breadcrumbs -->
<nav id="breadcrumbs" style="background-color: transparent; left: 0">
    <ul>
        <li><?= Html::a(Yii::t('yii', 'Home'), '/') ?></li>
        <?php foreach ($this->params['breadcrumbs'] as $item): ?>
            <?php if (is_array($item)): ?>
                <li><?= Html::a($item['label'], $item['url']) ?></li>
            <?php else: ?>
                <li class="active"><?= $item ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>