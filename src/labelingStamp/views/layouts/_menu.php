<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$items = [];

if (!Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Stamp', 'url' => ['/stamp/index']];
}

$items[] = Yii::$app->user->isGuest ? (
    ['label' => 'Login', 'url' => ['/site/login']]
) : (
    '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
        'Logout (' . Yii::$app->user->identity->username . ')',
        ['class' => 'btn btn-link logout']
        )
    . Html::endForm()
    . '</li>'
);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
]);
    
NavBar::end();
