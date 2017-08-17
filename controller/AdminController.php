<?php
include 'Base.php';

class AdminController extends Base
{
    function checkSession()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/login');
        }
    }

    function getLogin($error)
    {
        if($error) {
        	$params = array(
                'error' => 'display: block'
            );
        } else {
        	$params = array(
                'error' => 'display: none'
            );
        }
        echo $this->render('admin/login.php',$params);
    }

    function getLogout()
    {
        echo $this->render('admin/logout.php');
    }

    function getAdmin()
    {
        $this->checkSession();

        $params = array(
            'listView' => 'display: none',
            'themeView' => 'display: none',
            'noAnswerQuestionsView' => 'display: none',
            'themeQuestions' => 'display: none',
            'changeTheme' => 'display: none'
        );
		echo $this->render('admin/admin.php', $params);
    }

    function getAdminList($params)
    {
        $this->checkSession();

        $change = 'display: none';
        $create = 'display: none';
        $noAnswerQuestionsView = 'display: none';
        $themeQuestions = 'display: none';
        $changeTheme = 'display: none';

        if ($params[0] == 'changeAdminPassword') {
            $change = 'display: block';
        } else if ($params[0] == 'delete') {
            $this->model->deleteAdmin($params[1]);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/list');
        } else if ($params[0] == 'createAdmin') {
            $create = 'display: block';
        }

        $visualParams = array(
            'listView' => 'display: block',
            'themeView' => 'display: none',
            'changeAdminPassword' => $change,
            'themeQuestions' => $themeQuestions,
            'changeTheme' => $changeTheme,
            'createAdmin' => $create,
            'noAnswerQuestionsView' => $noAnswerQuestionsView,
            'adminMass' => $this->model->adminlist()
        );
		echo $this->render('admin/admin.php', $visualParams);
    }

    function getAdminTheme($params)
    {
        $this->checkSession();

        $questionList = $this->model->questionList(false);
        $insert = 'display: none';
        $noAnswerQuestionsView = 'display: none';
        $editQuestion = 'display: none';
        $themeQuestions = 'display: none';
        $changeTheme = 'display: none';

        if ($params[0] == 'insert') {
            $insert = 'display: block';
        }
        if ($params[0] == 'delete') {
            $this->model->themeDelete($params[1]);
            header('Location: ?/admin/admin/theme');
        }
        if ($params[0] == 'deleteAll') {
            $this->model->themeQuestionsDelete($params[1]);
            header('Location: ?/admin/admin/theme');
        }
        if ($params[0] == 'noAnswer') {
            $noAnswerQuestionsView = 'display: block';
        }
        if ($params[0] == 'noAnswer' && $params[1] == 'edit') {
            $editQuestion = 'display: block';
            $questionForEdit = $this->model->questionForEdit($params[2]);
        }
        if ($params[0] == 'list') {
            $themeQuestions = 'display: block';
            $themeQuestionsData = [];
            $theme = $params[1];
            foreach ($questionList as $elem) {
                if($elem['category_id'] == $theme) {
                    array_push($themeQuestionsData, $elem);
                }
            }
            if ($params[2] == 'delete') {
                $this->model->deleteQuestion($params[3]);
                header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme/?/list/'.$params[1]);
            }
            if ($params[2] == 'edit') {
                $editQuestion = 'display: block';
                $questionForEdit = $this->model->questionForEdit($params[3]);
            }
            if ($params[2] == 'publicate') {
                $this->model->publicateQuestion($params[3]);
                header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme/?/list/'.$params[1]);
            }
            if ($params[2] == 'hide') {
                $this->model->hideQuestion($params[3]);
                header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme/?/list/'.$params[1]);
            }
            if ($params[2] == 'changeTheme') {
                $changeTheme = 'display: block';
            }
        }

        $params = array(
            'listView' => 'display: none',
            'themeView' => 'display: block',
            'themeInsert' => $insert,
            'noAnswerQuestionsView' => $noAnswerQuestionsView,
            'editQuestion' => $editQuestion,
            'themeQuestions' => $themeQuestions,
            'themeMass' => $this->model->themeList(),
            'themeDataMass' => $this->model->themeData(),
            'questionWhithNullAnswer' => $questionList,
            'editQuestionData' => $questionForEdit[0],
            'themeQuestionsData' => $themeQuestionsData,
            'theme' => $theme,
            'changeTheme' => $changeTheme
        );
		echo $this->render('admin/admin.php', $params);
    }

    function postLogin($params, $post)
    {
        if (isset($post['user']) && isset($post['password'])) {
            $userName = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
            $userPass = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            $login = $this->model->auth([
                'user' => $userName,
                'password' => $userPass,
            ]);
            if ($login) {
                $_SESSION['user'] = $login[0];
                header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin');
            } else {
                $this->getLogin(1);
            }
        }
    }

    function postAdminList($params, $post)
    {
        if ($params[0] == 'changeAdminPassword') {
            $this->model->changePassword($params[1], $post['password']);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/list');
        }
        if ($params[0] == 'createAdmin') {
            $this->model->createAdmin($post);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/list');
        }
    }

    function postAdminTheme($params, $post)
    {	
        if ($params[0] == 'insert') {
            $this->model->createTheme($post);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme');
        }
        if ($params[0] == 'noAnswer' && $params[1] == 'edit') {
            $this->model->updateQuestion($params[2], $post);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme/?/noAnswer');
        }
        if ($params[0] == 'list' && $params[2] == 'edit') {
            $this->model->updateQuestion($params[3], $post);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme/?/list/'.$params[1]);
        }
        if ($params[0] == 'list' && $params[2] == 'changeTheme') {
            $this->model->changeThemeQuestions($params[3], $post);
            header('Location: /user_data/zenkin/diplom-php-inwork/?/admin/admin/theme/?/list/'.$params[1]);
        }
    }
}

