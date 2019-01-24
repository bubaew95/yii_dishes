<?php

/* @var $this yii\web\View */

$this->title = $dishes != null ? "Найдено совпадений " . count($dishes) : 'Главная страница';
?>
<div class="site-index">
    <div class="body-content">

        <?php if($listIngredients) : ?>

            <form action="" method="get">
                 <div class="row">
                    <?php foreach ($listIngredients as $key => $listIngredient ): ?>
                        <div>
                            <input type="checkbox" id="ing_<?= $key?>" <?php if($listIngredient->id == $_GET['ingredients']['ids'][$key]) echo 'checked=true'?> name="ingredients[ids][]" value="<?= $listIngredient->id?>" />
                            <label for="ing_<?= $key?>"><?= $listIngredient->title?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-info">Найти</button>
            </form>

        <?php endif; ?>


        <div style="margin-top: 40px">
            <?php if($dishes) : ?>
                <ul class="list-group">
                    <?php foreach ($dishes as $key => $dish) : ?>
                        <li class="list-group-item">
                            <h4><?= $key?></h4>
                            <?php if($dish) : ?>
                                <div class="ingredients">
                                    <ul>
                                        <?php foreach ($dish as $item) : ?>
                                            <li class="text-success"><?= $item?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</div>
