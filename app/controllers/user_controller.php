<?php

  class UserController extends BaseController{

    public static function login(){
      View::make('user/login.html');
    }

    public static function register() {
      View::make('user/register.html');
    }

    public static function edit($id){
      self::check_logged_in();

      $user = self::get_user_logged_in();
      View::make('user/edit.html', array('attributes' => $user));
    }

    public static function create() {
      $attributes = array('name' => $_POST['name'], 'password' => $_POST['password']);
      $user = new User($attributes);

      $user->save();

      Redirect::to('/login', array('message' => 'Käyttäjä ' . $user->name . ' luotu onnistuneesti!'));
    }

    public static function logout(){
      $_SESSION['user'] = null;
      Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function handle_login(){
      $params = $_POST;

      $user = User::authenticate($params['name'], $params['password']);

      if ($user == null){
        View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'name' => $params['name']));
      } else {
        $_SESSION['user'] = $user->id;

        Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
      }
    }

    public static function show($id){
      $user = User::find($id);

      View::make('/user/show.html', array('user' => $user));      
    }

    public static function destroy() {
      self::check_logged_in();

      $user = self::get_user_logged_in();

      $playedcourses = PlayedCourse::findByUserId($user->id);
      
      foreach ($playedcourses as $pcourse) {
      $pholes = PlayedHole::findByPlayedCourseId($pcourse->id);
        foreach ($pholes as $phole) {
          $phole->destroy();
        }
        $pcourse->destroy();
      }

      $user->destroy();

      // Ohjataan käyttäjä kenttien listaussivulle ilmoituksen kera
      Redirect::to('/', array('message' => 'Käyttäjä on poistettu onnistuneesti'));
    }

    public static function update($id){
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'name' => $params['name'],
        'password' => $params['password']
        );

      // Alustetaan Kenttä-olio käyttäjän syöttämillä tiedoilla
      $user = new User($attributes);  
      $errors = $user->errors();

      if(count($errors) > 0){
        View::make('user/edit.html', array('errors' => $errors, 'attributes' => $attributes));
      }else{
        // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
        $user->update();

        Redirect::to('/user/' . $user->id, array('message' => 'Käyttäjää on muokattu onnistuneesti!'));
      }
    }
  }