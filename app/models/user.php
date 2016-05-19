<?php

  class User extends BaseModel {

    public $id, $name, $password;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validatePassword');
    }

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Golfer (name, password) VALUES (:name, :password) RETURNING id');
      $query->execute(array('name' => $this->name, 'password' => $this->password));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function destroy() {
      $query = DB::connection()->prepare('DELETE From Golfer Where id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();
	}

	public function update() {
      $query =  DB::connection()->prepare('UPDATE Golfer Set (password) = (:password) WHERE id = :id');
      $query->execute(array('id' => $this->id, 'password' => $this->password));
      $row = $query->fetch();
	}

  	public static function find($id) {
	  $query = DB::connection()->prepare('SELECT * FROM Golfer WHERE id = :id LIMIT 1');
	  $query->execute(array('id' => $id));
	  $row = $query->fetch();

	  if($row) {
		$user = new User(array(
		  'id' => $row['id'],
		  'name' => $row['name'],
		  'password' => $row['password']
		  ));

		return $user;
	  }

	  return null;
	}

  	public function authenticate($name, $password) {
	  $query = DB::connection()->prepare('SELECT * FROM Golfer WHERE name = :name AND password = :password LIMIT 1');
	  $query->execute(array('name' => $name, 'password' => $password));
	  $row = $query->fetch();

      if ($row) {
	    $user = new User(array(
	    	'id' => $row['id'],
	    	'name' => $row['name'],
	    	'password' => $row['password']
	    	));
	    return $user;
      } else {
 	    return null;
	  }
  	}

	public function validatePassword() {
	  $error = array();
	  if (strlen($this->password) < 3) {
	    $error = array("Salasanan pituus oltava vähintään 3 kirjainta");
	  }
	  return $error;
	}
}