<?php

  class User extends BaseModel {

    public $id, $name, $password;

    public function __construct($attributes){
      parent::__construct($attributes);
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
	  $query->execute(array('id' => $id, 'name' => $name, 'password' => $password));
	  $row = $query->fetch();

      if ($row) {
	    $user = new User(array(
	    	'id' => $row['id'],
	    	'name' => $row['name'],
	    	'password' => $row['password']
	    	));
	    return $user;
      } else {
 	    return $null;
	  }
  	}
  }