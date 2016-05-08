<?php

  class CourseController extends BaseController {

  	public static function index(){
      $courses = Course::all();
      $user_logged_in = self::get_user_logged_in();
      View::make('course/index.html', array('courses' => $courses));
    }

    public static function store(){

      $params = $_POST;

      $attributes = array(
        'name' => $params['name'],
        'city' => $params['city'],
        'holes' => $params['holes']
      );

      $course = new Course($attributes);
      $course->save();

      if(sizeof($_POST) == 12) {
        for($i = 1; $i <= 9; $i++) {
          $attr = array('course_id' => $course->id, 'holenumber' => $i, 'par' => (int)$_POST[$i]);
          $hole = new Hole($attr);
          //näkymä validoinut tarvittavat
          $hole->save();
        }
      } else {
        for($i = 1; $i <= 18; $i++) {
          $attr = array('course_id' => $course->id, 'holenumber' => $i, 'par' => (int)$_POST[$i]);
          $hole = new Hole($attr);
          //näkymä validoinut tarvittavat
          $hole->save();
        }
      }

      Redirect::to('/courses', array('message' => 'Kenttä on lisätty tietokantaan!'));
    }

    public static function create() {
      self::check_logged_in();

      View::make('course/new.html'); 
    }

    public static function create2() {
      self::check_logged_in();
      $params = array('name' => $_POST['name'], 'city' => $_POST['city'], 'holes' => $_POST['holes']);


      if ($_POST['holes'] == 9) {
        View::make('course/new9.html', $params);
      } else {
        View::make('course/new18.html', $params); 
      }
    }

    public static function show($id){
    	$course = Course::find($id);
      $holes = Hole::findByCourseId($id);
      $user_logged_in = self::get_user_logged_in();
    	
    	View::make('course/show.html', array('course' => $course, 'holes' => $holes));
    }

    public static function edit($id){
      self::check_logged_in();

      $course = Course::find($id);
      View::make('course/edit.html', array('attributes' => $course));
    }
  }