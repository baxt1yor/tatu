<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->isGuest?"Mehmon":Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>



        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Semestrlar', 'url' => ['term/index']],
                    ['label' => 'Guruhlar', 'url' => ['groups/index']],
                    ['label' => 'Talabalar', 'url' => ['student/index']],
                    ['label' => 'Dars jadvali', 'url' => ['schedule-item/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
