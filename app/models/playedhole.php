<?php

  class PlayedHole extends BaseModel {
  	
  	public $id, $playedcourse_id, $golfer_id, $result, $holenumber;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validatePlayedHoles');
    }

  	public function validatePlayedHoles() {
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