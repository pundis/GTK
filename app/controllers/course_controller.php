<?php

  class CourseController extends BaseController {

  	public static function index(){
      $courses = Course::all();
      $user_logged_in = self::get_user_logged_in();
      View::make('course/index.html', array('courses' => $courses));
    }


    public static function destroy($id){
      self::check_logged_in();
      // Alustetaan Kenttä-olio annetulla id:llä
      $course = new Course(array('id' => $id));
      $playedcourses = PlayedCourse::findByCourseId($id);

      foreach ($playedcourses as $pcourse) {
        $pholes = PlayedHole::findByPlayedCourseId($pcourse->id);
        foreach ($pholes as $phole) {
          $phole->destroy();
        }
        $pcourse->destroy();
      }
      // Kutsutaan Kenttä-malliluokan metodia destroy
      $holes = Hole::findByCourseId($id);
      foreach ($holes as $hole) {
        $hole->destroy();
      }

      $course->destroy();

      // Ohjataan käyttäjä kenttien listaussivulle ilmoituksen kera
      Redirect::to('/courses', array('message' => 'Kenttä on poistettu onnistuneesti'));
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