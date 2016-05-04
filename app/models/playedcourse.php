<?php

  class PlayedCourse extends BaseModel {
  	
  	public $id, $course_name, $course_holes, $golfer_id, $course_id, $result;

  	public function __construct($attributes) {
      parent::__construct($attributes);
  	}

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO PlayedCourse (course_name, course_holes, golfer_id, course_id, result) VALUES (:course_name, :course_holes, :golfer_id, :course_id, :result) RETURNING id');
      $query->execute(array('course_name' => $this->course_name, 'course_holes' => $this->course_holes, 'golfer_id' => $this->golfer_id, 'course_id' => $this->course_id, 'result' => $this->result));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function findByUserId($id) {
      $query = DB::connection()->prepare('SELECT * FROM PlayedCourse WHERE golfer_id = :id');
      $query->execute(array('id' => $id));
      $rows = $query->fetchAll();
      $playedcourses = array();

      foreach($rows as $row){
        $playedcourses[] = new PlayedCourse(array(
          'id' => $row['id'],
          'course_name' => $row['course_name'],
          'course_holes' => $row['course_holes'],
          'golfer_id' => $row['golfer_id'],
          'course_id' => $row['course_id'],
          'result' => $row['result']
        ));
      }

      return $playedcourses;
    }


  }