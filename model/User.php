<?php

class User
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function add($params)
    {
        $createDate = date("Y-m-d H:m:s");
        $sth = $this->db->prepare(
            'INSERT INTO question (wordign, category_id, author, create_date) VALUES (:wordign, :category_id, :author, :create_date)'
        );
        $sth->bindValue(':wordign', $params['wordign'], PDO::PARAM_STR);
        $sth->bindValue(':category_id', $params['category_id'], PDO::PARAM_INT);
        $sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
        $sth->bindValue(':create_date', $createDate);

        return $sth->execute();
    }

    public function findAllQuesions()
    {
        $sth = $this->db->prepare(
        	'SELECT * FROM question WHERE status = 1'
        );
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }
    public function findAllTheme()
    {
        $sth = $this->db->prepare(
        	'SELECT * FROM category'
        );
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }
}

