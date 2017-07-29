<?php
include 'Base.php';

class UserController extends Base
{
    private $model;

    function __construct($model)
    {
        $this->model = $model;
    }

    function getAdd()
    {
        $theme = $this->model->findAllTheme();
        $params = array(
            'themeMass' => $theme
        );
		echo $this->render('user/add.php', $params);
    }

    function postAdd($params, $post)
    {
        $updateParam = [];
        if (isset($post['wordign']) && isset($post['category_id']) && isset($post['author'])) {
            $idAdd = $this->model->add([
                'wordign' => $post['wordign'],
                'category_id' => $post['category_id'],
                'author' => $post['author']
            ]);
            if ($idAdd) {
                header('Location: /user_data/zenkin/diplom-php-inwork/');
            }
        }
    }

    public function getList()
    {
        $questions = $this->model->findAllQuesions();
        $theme = $this->model->findAllTheme();
        $notNullTheme = [];
        foreach ($questions as $question) {
            if(!(in_array($question["category_id"], $notNullTheme))) {
                array_push($notNullTheme, $question["category_id"]);
            }
        }
        $themeMassForView = [];
        foreach ($theme as $elem) {
			if (in_array($elem['id'], $notNullTheme)) {
                array_push($themeMassForView, $elem);
            }
        }

        $params = array(
            'questionsMass' => $questions,
            'themeMass' => $themeMassForView
        );

		echo $this->render('user/list.php', $params);
    }

}

