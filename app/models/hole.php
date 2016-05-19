<?php

  class Hole extends BaseModel {

    public $id, $course_id, $holenumber, $par;

    public function __construct($attributes){
      parent::__construct($attributes);
    }

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Hole (course_id, holenumber, par) VALUES (:course_id, :holenumber, :par) RETURNING id');
      $query->execute(array('course_id' => $this->course_id, 'holenumber' => $this->holenumber, 'par' => $this->par));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function destroy(){
      $query = DB::connection()->prepare('DELETE From Hole Where id = :id');
      $query->execute(array('id' => $this->id));
      $row = $query->fetch();
    }

    public static function findByCourseId($id){
  		$query = DB::connection()->prepare('SELECT * FROM Hole WHERE course_id = :id ORDER BY holenumber');
      $query->execute(array('id' => $id));
      $rows = $query->fetchAll();

      $holes = array();

    	foreach($rows as $row){
      	  $holes[] = new Hole(array(
          'id' => $row['id'],
          'course_id' => $row['course_id'],
          'holenumber' => $row['holenumber'],
          'par' => $row['par']
      	  ));
    	}

    	return $holes;
  	}
  }