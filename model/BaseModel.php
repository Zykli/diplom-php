<?php

class BaseModel 
{
    public $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function themeList()
    {   
        $statement = $this->db->prepare(
            'SELECT * FROM category'
        );
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return false;
    }
    
    public function questionList($params)
    {	
    	if ($params) {
            $statement = $this->db->prepare(
        	'SELECT * FROM question WHERE status = 1'
            );
    	} else {
    		$statement = $this->db->prepare(
            'SELECT * FROM question'
            );
    	}
        if ($statement->execute()) {
			return $statement->fetchAll();
        }
        return false;
    }
}
?>