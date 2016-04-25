<?php

  class PlayedCourse extends BaseModel {
  	
  	public $id, $golfer_id, $course_id, $played, $result;

  	public function __construct($attributes) {
      parent::__construct($attributes);
  	}

  	

  }