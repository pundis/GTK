<?php

  class Course extends BaseModel {

    public $id, $name, $city, $holes;

    public function __construct($attributes){
      parent::__construct($attributes);
    }


  	public static function find($id) {
  		$query = DB::connection()->prepare('SELECT * FROM Course WHERE id = :id LIMIT 1');
  		$query->execute(array('id' => $id));
  		$row = $query->fetch();

  		if($row) {
  			$course = new Course(array(
  			  'id' => $row['id'],
  			  'name' => $row['name'],
  			  'holes' => $row['holes'],
  			  'city' => $row['city']
  				));

  			return $course;
  		}

  		return null;
  	}

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Course (name, city, holes) VALUES (:name, :city, :holes) RETURNING id');
      $query->execute(array('name' => $this->name, 'city' => $this->city, 'holes' => $this->holes));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

  public static function all(){
    $query = DB::connection()->prepare('SELECT * FROM Course');
    $query->execute();
    $rows = $query->fetchAll();
    $courses = array();

    foreach($rows as $row){
      $courses[] = new Course(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'holes' => $row['holes'],
        'city' => $row['city']
      ));
    }

    return $courses;
  }
}
