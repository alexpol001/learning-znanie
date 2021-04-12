<?php
/* @var $module \common\models\CourseModule */
?>

<div class="modal fade videomaterials" id="myModalModule<?=$module->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalAboutLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalModule<?=$module->id?>Label"><?=$module->title?></h4>
            </div>
            <div class="modal-body">
                <?=$module->materials?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
