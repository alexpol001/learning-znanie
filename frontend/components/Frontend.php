<?php

namespace frontend\components;

use common\components\Common;
use common\models\CourseModule;
use common\models\Question;
use common\models\Setting;
use common\models\StudentCourse;
use common\models\StudentCourseModule;
use common\models\StudentCourseQuestion;
use Yii;
use yii\base\Component;
use yii\helpers\Url;

class Frontend extends Component
{

    public static function getTitle($arr = [])
    {
        $title = '';
        foreach ($arr as $item) {
            $title .= $item . ' - ';
        }
        $title .= 'Дистанционное обучение/' . Yii::$app->name;
        return $title;
    }

    public static function getUrlCourseType($type)
    {
        return Url::to(['/default/courses', 'type' => $type]);
    }

    public static function getUrlCourse($course)
    {
        return Url::to(['/default/course', 'slug' => $course->slug]);

    }

    public static function getUrlModuleTest($module)
    {
        return Url::to(['/default/module-test', 'id' => $module->id]);

    }

    public static function getUrlExamine($course)
    {
        return Url::to(['/default/examine', 'slug' => $course->slug]);

    }

    public static function getUrlRegistration($type = null)
    {
        return Url::to(['/default/registration', 'type' => $type]);
    }

    public static function getUrlTerms()
    {
        return Setting::getSetting()->politics;
    }

    /**
     * @param StudentCourse $studentCourse
     */
    public static function checkHours($studentCourse)
    {
        if (!Common::getLastHours($studentCourse)) {
            $studentCourse->toLose();
        }
    }

    public static function getCourseType($title)
    {
        switch ($title) {
            case Common::QUALIFICATION:
                return 1;
            case Common::PROFESSIONAL_LEARNING:
                return 2;
            default:
                return 0;
        }
    }

    public static function getOldPrice($price)
    {
        return round($price / (100 - Setting::getSetting()->sale)) * 100;
    }

    /**
     * @param $studentCourse StudentCourse
     * @param null $module
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getQuestion($studentCourse, $module = null)
    {

        if (isset($module->questions)) {
            $questions = $module->questions;
            $pastQuestions = $studentCourse->getStudentCourseTestQuestions($module);
        } else {
            $questions = $studentCourse->courseId0->questions;
            $pastQuestions = $studentCourse->studentCourseExamineQuestions;
        }
        if (count($questions) <= count($pastQuestions)) {
            StudentCourseQuestion::resetStudentCourseMiss($studentCourse->id, $module);
            $studentCourse = StudentCourse::findOne($studentCourse->id);
        }
        $question = Question::getQuestionByOutStudentCourseQuestion($studentCourse, $module);
        return $question ? $question : null;
    }

    public static function isOneAnswer($question)
    {
        $count = 0;
        foreach ($question->answers as $answer) {
            if ($answer->is_right) {
                $count++;
            }
            if ($count >= 2) {
                return false;
            }
        }
        return true;
    }

    public static function getNumberQuestion($question)
    {
        $number = 1;
        if ($question->course_id) {
            $questions = $question->courseId0->questions;
        } else {
            $questions = $question->moduleId0->questions;
        }
        foreach ($questions as $item) {
            if ($item['id'] == $question['id']) {
                break;
            }
            $number++;
        }
        return $number;
    }

    public static function isRightQuestion($question_id, $answer)
    {
        $question = Question::findOne($question_id);
        if (is_array($answer)) {
            $rightCount = 0;
            $countAnswer = count($answer);
            foreach ($question->answers as $item) {
                if ($item->is_right) {
                    $rightCount++;
                }
                if ($rightCount > $countAnswer) {
                    return false;
                }
            }
            if ($rightCount < $countAnswer) {
                return false;
            }
            foreach ($answer as $item) {
                if (!$question->answers[$item]->is_right) {
                    return false;
                }
            }
        } else {
            if ($question->answers[$answer]->is_right) {
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * @param $studentCourse StudentCourse
     * @param $module CourseModule
     * @return array
     */
    public static function getResultTest($studentCourse, $module)
    {
        $result['value'] = 0;
        foreach ($studentCourse->getStudentCourseTestQuestions($module) as $question) {
            if ($question->status == 1) {
                $result['value']++;
            }
        }
        $result['value'] = ceil($result['value'] / count($module->questions) * 100);
        StudentCourseModule::active($studentCourse, $module);
        $result['errors'] = StudentCourseQuestion::resetStudentCourse($studentCourse->id, $module);
        return $result;
    }

    public static function getResultExamine($studentCourse)
    {
        $result = [];
        $result['value'] = 0;
        $result['class'] = 'fail';
        $result['success'] = false;
        foreach ($studentCourse->studentCourseExamineQuestions as $question) {
            if ($question->status == 1) {
                $result['value']++;
            }
        }
        $result['value'] = ceil($result['value'] / count($studentCourse->courseId0->questions) * 100);
        if ($result['value'] >= Setting::getSetting()->right_answer) {
            $result['class'] = 'success';
            $result['success'] = true;
        }
        return $result;
    }

    public static function getResultCourse($studentCourse)
    {
        $result = [];
        $result['value'] = $studentCourse->result;
        $result['class'] = 'fail';
        $result['success'] = false;
        if ($result['value'] >= Setting::getSetting()->right_answer) {
            $result['class'] = 'success';
            $result['success'] = true;
        }
        return $result;
    }

    /**
     * @return string
     */
    public static function getSaleDate()
    {
        $timestamp = time();

        $month_number = date('n', $timestamp);

        switch ($month_number) {
            case 1:
                $rus = '1 февраля';
                break;
            case 2:
                $rus = '1 марта';
                break;
            case 3:
                $rus = '1 апреля';
                break;
            case 4:
                $rus = '1 мая';
                break;
            case 5:
                $rus = '1 июня';
                break;
            case 6:
                $rus = '1 июля';
                break;
            case 7:
                $rus = '1 августа';
                break;
            case 8:
                $rus = '1 сентября';
                break;
            case 9:
                $rus = '1 октября';
                break;
            case 10:
                $rus = '1 ноября';
                break;
            case 11:
                $rus = '1 декабря';
                break;
            case 12:
                $rus = '1 января';
                break;
        }

        /** @var $rus string */
        return strftime($rus, $timestamp);
    }

    public static function getLastTimeExamine($studentCourse)
    {
        $time = $studentCourse->courseId0->test_time * 60;
        return ($studentCourse->examine_at + $time) - time();
    }

    public static function getScriptCountDownExamine($lastTime)
    {
        if ($lastTime > 0) {
            $minuteK = 60;
            $hourK = $minuteK * 60;
            $hours = floor(($lastTime) / $hourK);
            $minutes = floor(($lastTime - ($hours * $hourK)) / $minuteK);
            $seconds = floor($lastTime - ($hours * $hourK + $minutes * $minuteK));
        } else {
            $hours = 0;
            $minutes = 0;
            $seconds = 0;
        }
        $script = <<< JS
         function toFormat(number) {
            if (number.toString().length < 2) {
                number = '0' + number;
            }
            return number;
        }
        var hours = $hours;
        var minutes = $minutes;
        var seconds = $seconds;
        
        var lastTime = $('.last-time');
        function displayTime() {
            lastTime.html(toFormat(hours)+':'+toFormat(minutes)+':'+toFormat(seconds));
        }
        displayTime();
        setInterval(function() {
            seconds--;
            if (seconds < 0) {
                minutes--;
                seconds = 59;
                if (minutes < 0) {
                    hours--;
                    minutes = 59;
                    if (hours < 0) {
                        hours = 0;
                        minutes = 0;
                        seconds = 0;
                    }
                }
            }
            displayTime();
        }, 1000);
JS;
        return $script;
    }

    public static function getScriptCountDown($studentCourse)
    {
        if (($lastTime = ($studentCourse->courseId0['hours'] * 3600) - (time() - $studentCourse['active_at'])) > 0) {
            $minuteK = 60;
            $hourK = $minuteK * 60;
            $dayK = $hourK * 24;
            $days = floor($lastTime / $dayK);
            $hours = floor(($lastTime - ($days * $dayK)) / $hourK);
            $minutes = floor(($lastTime - ($days * $dayK + $hours * $hourK)) / $minuteK);
            $seconds = floor($lastTime - ($days * $dayK + $hours * $hourK + $minutes * $minuteK));
        } else {
            $days = 0;
            $hours = 0;
            $minutes = 0;
            $seconds = 0;
        }

        $script = <<< JS
        
        var days = $days;
        var hours = $hours;
        var minutes = $minutes;
        var seconds = $seconds;
        
        var timer = $('.timer');
        var day = timer.find('.days');
        var hour = timer.find('.hours');
        var minute = timer.find('.minutes');
        var second = timer.find('.second');
        
        
        
        function declOfNum(number, titles) {  
            cases = [2, 0, 1, 1, 1, 2];  
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
        }
        
        function displayTime() {
            day.find('.time-value').html(days);
            hour.find('.time-value').html(hours);
            minute.find('.time-value').html(minutes);
            second.find('.time-value').html(seconds);
            
            day.find('.unit-time-title').html(declOfNum(days, ['День', 'Дня', 'Дней']));
            hour.find('.unit-time-title').html(declOfNum(hours, ['Час', 'Часа', 'Часов']));
            minute.find('.unit-time-title').html(declOfNum(minutes, ['Минута', 'Минуты', 'Минут']));
            // second.find('.unit-time-title').html(declOfNum(seconds, ['Секунда', 'Секунды', 'Секунд']));
        }
        displayTime();
        
        setInterval(function() {
            seconds--;
            if (seconds < 0) {
                minutes--;
                seconds = 59;
                if (minutes < 0) {
                    hours--;
                    minutes = 59;
                    if (hours < 0) {
                        days--;
                        hours = 23;
                        if (days < 0) {
                            days = 0;
                            hours = 0;
                            minutes = 0;
                            seconds = 0;
                        }
                    }
                }
            }
            displayTime();
        }, 1000);
        
        $('.to-exam.disabled').on('click', function(e) {
            e.preventDefault();
            var alert = '<div class="alert alert-danger alert-dismissible" role="alert" style="display: none"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Вы можете приступить к сдаче экзамена, только после прохождения всех модулей</div>';
            $('.course-info .alert-course').html(alert);
            $('.course-info .alert-danger').show(400);
        })
JS;
        return $script;
    }

    public static function plural_form($number, $after) {
        $cases = array(2,0,1,1,1,2);
        return $number.' '.$after[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]];
    }
}
