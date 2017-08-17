<?php
include 'BaseModel.php';

class Admin extends BaseModel
{
    function auth($params)
    {
        $statement = $this->db->prepare(
            'SELECT user, password FROM usersdiplom WHERE user = :user AND password = :password'
        );
        $statement->bindValue(':user', $params['user'], PDO::PARAM_STR);
        $statement->bindValue(':password', $params['password'], PDO::PARAM_STR);
        $statement->execute();
        $authUser = $statement->fetchAll();
        return $authUser;
    }

    function changePassword($id, $newPass)
    {
        $statement = $this->db->prepare(
            'UPDATE usersdiplom SET password = :password WHERE id = :userid'
        );
        $statement->bindValue(':userid', $id, PDO::PARAM_STR);
        $statement->bindValue(':password', $newPass, PDO::PARAM_STR);
        $statement->execute();
    }

    function createAdmin($params)
    {
        $statement = $this->db->prepare(
            'INSERT INTO usersdiplom (user, password) VALUES (:user, :password)'
        );
        $statement->bindValue(':user', $params['user'], PDO::PARAM_STR);
        $statement->bindValue(':password', $params['password'], PDO::PARAM_STR);
        $statement->execute();
    }

    function deleteAdmin($id)
    {
        $statement = $this->db->prepare(
            'DELETE FROM usersdiplom WHERE id = :id'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();
    }

    function createTheme($params)
    {
        $statement = $this->db->prepare(
            'INSERT INTO category (name) VALUES (:name)'
        );
        $statement->bindValue(':name', $params['newTheme'], PDO::PARAM_STR);
        $statement->execute();
    }

    function themeDelete($id)
    {
        $statement = $this->db->prepare(
            'DELETE FROM category WHERE id = :id'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }


    function themeQuestionsDelete($id)
    {
        $statement = $this->db->prepare(
            'DELETE FROM question WHERE category_id = :id'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function adminList()
    {
        $statement = $this->db->prepare(
            'SELECT * FROM usersdiplom'
        );
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return false;
    }

    public function questionForEdit($params)
    {
        $statement = $this->db->prepare(
            'SELECT * FROM question WHERE id = :id'
        );
        $statement->bindValue(':id', $params, PDO::PARAM_STR);
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return false;
    }

    public function updateQuestion($id, $params)
    {
        if (count($params) == 0) {
            return false;
        }
        
        if (empty($params['category_id'])) {
            $sth = $this->db->prepare('UPDATE question SET wordign = :wording, answer = :answer, status = :status, author = :author WHERE id = :id');
        } else {
            $sth = $this->db->prepare('UPDATE question SET wordign = :wording, answer = :answer, status = :status, category_id = :category_id, author = :author WHERE id = :id');
        }

        if (isset($params['wording'])) {
            $sth->bindValue(':wording', $params['wording'], PDO::PARAM_STR);
        }
        if (isset($params['answer'])) {
            $sth->bindValue(':answer', $params['answer'], PDO::PARAM_STR);
        }
        if (isset($params['author'])) {
            $sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
        }
        if (isset($params['category_id'])) {
            $sth->bindValue(':category_id', $params['category_id'], PDO::PARAM_INT);
        }
        if (isset($params['status'])) {
            $status = 1;
            $sth->bindValue(':status', $status, PDO::PARAM_INT);
        } else {
            $status = 0;
            $sth->bindValue(':status', $status, PDO::PARAM_INT);
        }
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return $sth->execute();
    }

    public function publicateQuestion($id)
    {
        $sth = $this->db->prepare(
        	'UPDATE question SET status = 1 WHERE id = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function hideQuestion($id)
    {
        $sth = $this->db->prepare(
        	'UPDATE question SET status = 0 WHERE id = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function deleteQuestion($id)
    {
        $sth = $this->db->prepare(
        	'DELETE FROM question WHERE id = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function changeThemeQuestions($id, $params)
    {
        $sth = $this->db->prepare(
        	'UPDATE question SET category_id = :category_id WHERE id = :id'
        );
        $sth->bindValue(':category_id', $params['category_id'], PDO::PARAM_INT);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function themeData() {
        $question = $this->questionList(false);
        $theme = $this->themelist();
        $themeDataMass = [];
        foreach ($theme as $thelem ) {
            $themeDataMass[$thelem['name']] = [];
            $allQuestionsCategory = 0;
            $visibleQuestionsCategory = 0;
            $noAnswerQuestionsCategory = 0;
            foreach ($question as $qelem) {
                if ($thelem['id'] == $qelem['category_id']) {
                    $allQuestionsCategory++;
                    if (!$qelem['answer']) {
                        $noAnswerQuestionsCategory++;
                    }
                    if ($qelem['status'] == 1) {
                        $visibleQuestionsCategory++;
                    }
                }
            }
            array_push($themeDataMass[$thelem['name']], $allQuestionsCategory);
            array_push($themeDataMass[$thelem['name']], $visibleQuestionsCategory);
            array_push($themeDataMass[$thelem['name']], $noAnswerQuestionsCategory);
        }
        return $themeDataMass;
    }
}

