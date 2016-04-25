<?php

  class PlayedCourseController extends BaseController {

    public static function create() {
      $courses = Course::all();

      View::make('playedcourse/new.html', array('courses' => $courses));
    }

    public static function index() {
      View::make('playedcourse/index.html');
    }

    public static function create2() {
      $params = $_POST;
      $course_id = $params['course_id'];
      $holes = Hole::findByCourseId($course_id);
      $course = Course::find($course_id);

      View::make('playedcourse/new2.html', array('holes' => $holes, 'course' => $course));
    }

    public static function store() {
      $params = $_POST;   

      $attributes = array(
        'course_id' => $params['course_id'],
        '1' => $params['1'],
        '2' => $params['2'],
        '3' => $params['3'],
        '4' => $params['4'],
        '5' => $params['5'],
        '6' => $params['6'],
        '7' => $params['7'],
        '8' => $params['8'],
        '9' => $params['9'],
      );
      if (sizeof($params) == 19) {
        $attributes = array(
          '10' => $params['10'],
          '11' => $params['11'],
          '12' => $params['12'],
          '13' => $params['13'],
          '14' => $params['14'],
          '15' => $params['15'],
          '16' => $params['16'],
          '17' => $params['17'],
          '18' => $params['18']
        );
      }

      Kint::dump($params);
      View::make('/index.html');
    }

  }