<?php

  class UserController extends BaseController{

    public static function login(){
        View::make('user/login.html');
    }

    public static function register() {
      View::make('user/register.html');
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
      // Alustetaan Kenttä-olio annetulla id:llä
      $user = user_logged_in();
      // Kutsutaan Kenttä-malliluokan metodia destroy, joka poistaa pelin sen id:llä
      $user->destroy();

      // Ohjataan käyttäjä kenttien listaussivulle ilmoituksen kera
      Redirect::to('/', array('message' => 'Käyttäjä on poistettu onnistuneesti'));
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

          Redirect::to('/courses' . $course->id, array('message' => 'Kenttää on muokattu onnistuneesti!'));
        }
      }
  }