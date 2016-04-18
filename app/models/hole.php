<?php

  class Hole extends BaseModel {

    public $id, $course_id, $holenumber, $par;

    public function __construct($attributes){
      parent::__construct($attributes);
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