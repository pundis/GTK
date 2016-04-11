<?php

  class CourseController extends BaseController {

  	public static function index(){
      $courses = Course::all();
      View::make('course/index.html', array('courses' => $courses));
    }

    public static function store(){
      $params = $_POST;

      $course = new Course(array(
        'name' => $params['name'],
        'city' => $params['city'],
        'holes' => $params['holes']
      ));

      $course->save();

      Redirect::to('/courses/' . $course->id, array('message' => 'Kenttä on lisätty tietokantaan!'));
    }

    public static function create() {
      View::make('course/new.html');
    }

    public static function show($id){
    	$course = Course::find($id);
    	
    	View::make('course/show.html', array('course' => $course));
    }
  

  }