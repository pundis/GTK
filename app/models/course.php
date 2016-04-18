<?php

  class Course extends BaseModel {

    public $id, $name, $city, $holes;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validateName', 'validateCity', 'validateHoles');
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

    public function update(){
      $query =  DB::connection()->prepare('UPDATE Course Set (name, city, holes) = (:name, :city, :holes) WHERE id = :id');
      $query->execute(array('id' => $this->id, 'name' => $this->name, 'city' => $this->city, 'holes' => $this->holes));
      $row = $query->fetch();
    }

    public function destroy(){
      $query = DB::connection()->prepare('DELETE From Course Where id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();
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

  public function validateCity() {
    $error = array();
    if (strlen($this->city) < 3) {
      $error = array("Kaupungin pituus oltava vähintään 3 kirjainta");
    }
   return $error;
  }

  public function validateName() {
    $error = array();
    if (strlen($this->name) < 3) {
      $error = array("Nimen pituus oltava vähintään 3 kirjainta");
    }
    return $error;
  }

  public function validateHoles() {
    $error = array();
    if (!ctype_digit(strval($this->holes))) {
      $error[] = "Reikiä oltava numero";
        return $error;  
    }
    if ($this->holes == 9 || $this->holes == 18) {
      return $error;
    }

    $error[] = "Reikiä oltava 9 tai 18";
    
    return $error;
  }
}
