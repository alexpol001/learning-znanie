<?php

namespace backend\components;


use common\components\Common;
use common\models\QuestionAnswer;
use common\models\StudentCourse;
use yii\base\Component;
use yii\helpers\Url;

class Backend extends Component
{

    const ACTIVE_STATUS = "Активен";
    const SUCCESS_STATUS = "Пройден";
    const FAIL_STATUS = "Провален";

    public static function getModuleFiles($moduleModel)
    {
        $files_add = Common::getUrlCourseModuleMaterials($moduleModel->id);
        $files = [];
        foreach ($files_add as $file) {
            $files[] = basename($file);
        }
        return $files;
    }

    public static function getCourseModuleMaterialFileArray($materials, $module_id)
    {
        $arr = [];
        foreach ($materials as $material) {
            $arr[] = ['caption' => $material, 'url' => Url::to('delete-material'), 'extra' => ['module_id' => $module_id, 'file' => $material]];
        }
        return $arr;
    }

    public static function GenPassword($length = 8)
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $length = intval($length);
        $size = strlen($chars) - 1;
        $password = "";
        while ($length--) $password .= $chars[rand(0, $size)];
        return $password;
    }

    /**
     *
     * @return StudentCourse|null the saved model or null if saving fails
     */
    public static function activeCourse($student_id, $course_id)
    {
        $studentCourse = new StudentCourse();
        $studentCourse->student_id = $student_id;
        $studentCourse->course_id = $course_id;
        $studentCourse->active_at = time()+(($studentCourse->courseId0->hours*3.2)*60*60);
        if ($studentCourse->save()) {
            $studentCourse->sendEmailAboutActiveCourse();
            return $studentCourse;
        }
        return null;
    }

    /**
     *
     * @return array
     */
    public static function getCourseTypeArray()
    {
        $Arr = [];
        $Arr[0] = Common::PROFESSIONAL;
        $Arr[1] = Common::QUALIFICATION;
        $Arr[2] = Common::PROFESSIONAL_LEARNING;
        return $Arr;
    }

    public static function getCourseStatus($type)
    {
        switch ($type) {
            case 0:
                return '<span class="text-primary">' . self::ACTIVE_STATUS . '</span>';
                break;
            case 1:
                return '<span class="text-success">' . self::SUCCESS_STATUS . '</span>';
                break;
            case 2:
                return '<span class="text-danger">' . self::FAIL_STATUS . '</span>';
                break;
            default:
                return false;
        }
    }

    public static function getQuestionTitle($moduleModel)
    {
        $title = 'Вопросы к экзамену';
        if ($moduleModel) {
            $title = 'Вопросы к модулю';
        }
        return $title;
    }

    public static function getQuestionAnswerUl($question_id)
    {
        $questionAnswer = QuestionAnswer::findAll(['question_id' => $question_id]);
        $ul = '<ul class="answers">';
        foreach ($questionAnswer as $answer) {
            $status = 'text-danger';
            if ($answer->is_right) {
                $status = 'text-success';
            }
            $li = '<li class="' . $status . '">' . $answer->title . '</li>';
            $ul .= $li;
        }
        $ul .= '</ul>';
        return $ul;
    }

    public static function getCourseStatusArray()
    {
        $Arr = [];
        $Arr[0] = self::ACTIVE_STATUS;
        $Arr[1] = self::SUCCESS_STATUS;
        $Arr[2] = self::FAIL_STATUS;
        return $Arr;
    }

    public static function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

}
