<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $films app\models\Film[] */

$this->title = 'Парсер kinopoisk.ru';
if (!empty($films)) {
    $this->title .= ' - Фильмы, вышедшие в ' . intval($year) . ' году';
}

?>
<div class="site-index">

    <div class="body-content">
        <form action="" method="get">
            <label for="year">Укажите год: </label><input type="number" size="4" name="year" id="year" value="<?= intval($year) ?>">
            <input type="submit">
        </form>
        <pre>
        
<?php
if (empty($films)) {
    echo 'По вашему запросу ничего не найдено.';
}
foreach($films as $film) {
    echo Html::encode($film->title) . ' -> ' . Html::encode($film->url)
            . ' -> ' . Html::encode($film->rating) . "\n";
}
?>
        </pre>
    </div>
</div>
