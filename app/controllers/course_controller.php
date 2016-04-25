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
      $errors = $course->errors();

      if (count($errors) == 0) {
        $course->save();
        Redirect::to('/courses/' . $course->id, array('message' => 'Kenttä on lisätty tietokantaan!'));
      } else {
        View::make('course/new.html', array('errors' => $errors, 'attributes' => $attributes));
      }
    }

    public static function create() {
      View::make('course/new.html');
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

    public static function update($id){
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'name' => $params['name'],
        'city' => $params['city'],
        'holes' => $params['holes']
        );

      // Alustetaan Kenttä-olio käyttäjän syöttämillä tiedoilla
      $course = new Course($attributes);
      $errors = $course->errors();

      if(count($errors) > 0){
        View::make('course/edit.html', array('errors' => $errors, 'attributes' => $attributes));
      }else{
        // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
        $course->update();

        Redirect::to('/courses/' . $course->id, array('message' => 'Kenttää on muokattu onnistuneesti!'));
      }
    }

    public static function destroy($id){
      // Alustetaan Kenttä-olio annetulla id:llä
      $course = new Course(array('id' => $id));
      // Kutsutaan Kenttä-malliluokan metodia destroy, joka poistaa pelin sen id:llä
      $course->destroy();

      // Ohjataan käyttäjä kenttien listaussivulle ilmoituksen kera
      Redirect::to('/courses', array('message' => 'Kenttä on poistettu onnistuneesti'));
    }
  }