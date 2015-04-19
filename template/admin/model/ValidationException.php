<?php

	/**
	* class ValidationException
	* provides errors handling
	*
	*/
	class ValidationException extends Exception {
	    
	    private $errors = NULL;
	    
	    /**
	    * allows to constract a new error instance
	    *
	    */
	    public function __construct($errors) {
	        parent::__construct("Validation error! Incorrect data.");
	        $this->errors = $errors;
	    }  
	    
	    /**
	    * allows to get the errors in exception situation
	    *
	    * @return error to the current object
	    */
	    public function getErrors() {
	        return $this->errors;
	    }
	    
	}
?>
