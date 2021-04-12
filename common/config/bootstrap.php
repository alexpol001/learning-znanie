<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@course', Yii::getAlias('@frontend') . '/web/uploads/course');
Yii::setAlias('@course_image', Yii::getAlias('@course') . '/image');
Yii::setAlias('@course_document', Yii::getAlias('@course') . '/document');
Yii::setAlias('@course_module', Yii::getAlias('@course') . '/module');

