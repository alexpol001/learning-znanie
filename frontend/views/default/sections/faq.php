<?php
/** @var bool $isGray */
 ?>
<section id="faq" class="<?= $isGray ? 'gray' : '' ?>">
    <div class="container">
        <div class="row">
            <h2 class="section-title">Правила организации обучения с применением дистанционных технологий</h2>
            <div class="faq-text">
                <?=\common\models\Setting::getSetting()->instruction_text?>
            </div>
        </div>
</section>
