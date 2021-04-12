<aside class="main-sidebar">

    <?
    $checkController = function ($controller) {
        return $controller === $this->context->getUniqueId();
    };
    ?>
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Курсы', 'icon' => 'book', 'url' => ['/course'], 'active' => $checkController('course')],
                    ['label' => 'Студенты', 'icon' => 'users', 'url' => ['/student'], 'active' => ($checkController('student') && !Yii::$app->getRequest()->getQueryParams()['Student']['is_archive'])],
                    [
                        'label' => 'Настройки',
                        'icon' => 'cog',
                        'url' => ['/setting'],
                    ],
                    ['label' => 'Архив', 'icon' => 'user-times', 'url' => ['/student?&Student[is_archive]=1'], 'active' => Yii::$app->getRequest()->getQueryParams()['Student']['is_archive']],
                ],
            ]
        ) ?>
    </section>
</aside>
