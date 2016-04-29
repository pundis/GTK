<?php

  class PlayedCourse extends BaseModel {
  	
  	public $id, $golfer_id, $course_id, $result;

  	public function __construct($attributes) {
      parent::__construct($attributes);
  	}

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO PlayedCourse (golfer_id, course_id, result) VALUES (:golfer_id, :course_id, :result) RETURNING id');
      $query->execute(array('golfer_id' => $this->golfer_id, 'course_id' => $this->course_id, 'result' => $this->result));
      $row = $query->fetch();
      $this->id = $row['id'];
    }


  }