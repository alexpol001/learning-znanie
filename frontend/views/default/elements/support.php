<?php

use common\models\Student;
use common\models\User;

?>
<h5 class="test-result">
    Если у вас возникнут вопросы, то вы всегда можете связаться с нами.
</h5>
<div class="contacts">
    <? $admin = Student::findByStudentEmail(User::getAdmin()->email) ?>
    <a href="mailto:<?=$admin->email?>"><?=$admin->email?></a>
    <a href="tel:<?=$admin->phone?>"><?=$admin->phone?></a>
</div>