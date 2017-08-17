<?php
include 'BaseModel.php';

class User extends BaseModel
{
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
}

