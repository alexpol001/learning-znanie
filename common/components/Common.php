<?php

namespace common\components;


use common\models\Course;
use common\models\Question;
use common\models\QuestionAnswer;
use common\models\Student;
use common\models\StudentCourse;
use common\models\StudentCourseQuestion;
use Yii;
use yii\base\Component;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class Common extends Component
{
    const QUALIFICATION_URL = "qualification";
    const PROFESSIONAL_URL = "professional";
    const PROFESSIONAL_LEARNING_URL = "professional-learning";
    const QUALIFICATION = "Курсы повышения квалификации";
    const PROFESSIONAL = "Курсы профессиональной переподготовки";
    const PROFESSIONAL_LEARNING = "Профессиональное обучение";

    /**
     * @param null $model
     * @throws NotFoundHttpException
     */
    public static function throwException($model = null)
    {
        if ($model) {
            return;
        }
        throw new NotFoundHttpException();
    }

    public static function getUrlCourseLogo($logo)
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/uploads/course/image/' . $logo;
    }

    public static function getUrlCourseDocument($document)
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/uploads/course/document/' . $document;
    }

    /**
     * @param $type
     * @return string
     * @throws NotFoundHttpException
     */
    public static function getCoursesTypeTitle($type)
    {
        if (is_string($type)) {
            switch ($type) {
                case Common::PROFESSIONAL_URL:
                    return Common::PROFESSIONAL;
                    break;
                case Common::PROFESSIONAL_LEARNING_URL:
                    return Common::PROFESSIONAL_LEARNING;
                    break;
                case Common::QUALIFICATION_URL:
                    return Common::QUALIFICATION;
                    break;
                default:
                    throw new NotFoundHttpException();
            }
        } else {
            switch ($type) {
                case 0:
                    return Common::PROFESSIONAL;
                    break;
                case 1:
                    return Common::QUALIFICATION;
                    break;
                case 2:
                    return Common::PROFESSIONAL_LEARNING;
                    break;
                default:
                    return false;
            }
        }

    }

    public static function getLastHours($studentCourse)
    {
        $hours = $studentCourse->courseId0->hours;
        $active_at = $studentCourse->active_at;
        $result = ceil($hours - (time() - $active_at) / 3600);
        return $result > 0 ? $result : 0;
    }

    public static function getUrlCourseModuleMaterials($module_id)
    {
        $files_add = [];
        $path = Yii::getAlias("@course_module/" . $module_id);
        if (is_dir($path)) {
            $files = \yii\helpers\FileHelper::findFiles($path);
            foreach ($files as $file) {
                $files_add[] = 'http://' . $_SERVER['SERVER_NAME'] . '/uploads/course/module/' . $module_id . '/' . basename($file);
            }
        }
        return $files_add;
    }

    public static function getAbsoluteUrlLogin() {
        return 'http://'.$_SERVER['SERVER_NAME'].'/login';
    }

    public static function getAbsoluteUrlCourse($course) {
        /** @var Course $course */
        return 'http://'.$_SERVER['SERVER_NAME'].'/course/'.$course->slug;
    }

    public static function getAbsoluteUrlFavicon() {
        /** @var Course $course */
        return 'http://'.$_SERVER['SERVER_NAME'].'/assets/img/favicon.ico';
    }

    public static function GetStudentNameByUserEmail($email)
    {
        $student = new Student();
        $student = $student->findByStudentEmail($email);
        if ($student) {
            $name = $student->name;
            if (mb_strlen($name, 'UTF-8') > 35) {
                $name = mb_substr($name, 0, 32, 'UTF-8');
                $name = trim($name) . '...';
            }
        } else {
            $name = null;
        }
        return $name;
    }

    public static function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

    public static function rmRec($path)
    {
        if (is_file($path)) return unlink($path);
        if (is_dir($path)) {
            foreach (scandir($path) as $p) if (($p != '.') && ($p != '..'))
                self::rmRec($path . DIRECTORY_SEPARATOR . $p);
            return rmdir($path);
        }
        return false;
    }

    /**
     * @param $array array
     */
    public static function deleteAll($array)
    {
        foreach ($array as $item) {
            $item->delete();
        }
    }
}
