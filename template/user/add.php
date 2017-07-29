<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Задать вопрос</title>
		<style type="text/css">
			body {
				margin: 0;
				padding: 0;
			}
			body > div {
				position: absolute;
			    left: 50%;
			    top: 50%;
			    width: 500px;
			    margin-left: -250px;
			    margin-top: -110px;
			    background-color: #a4df85;
			    padding: 15px;
			    height: 220px;
			}
			h4 {
				text-align: center;
				margin-top: 0px;
			}
			label {
			    width: 170px;
			    display: inline-block;
			}
			input, textarea, select {
			    margin-bottom: 10px;
			    width: 326px;
			    box-sizing: border-box;
			}
			select {
				height: 23px;
			}
		</style>
	</head>
	<body>
		<div>
			<h4>Задайте свой вопрос</h4>
			<form method="POST">
				<label for="author">Введите Ваше имя:</label>
				<input id="author" name="author" type="text">
				<br />
				<label for="author">Введите Ваш e-mail:</label>
				<input id="author" name="email" type="text">
				<br />
				<label for="wordign" style="vertical-align: top">Введите вопрос:</label>
				<textarea type="text" id="wordign" name="wordign"></textarea>
				<br />
				<label for="categoryId">Выберите категорию:</label>
				<select  name="category_id">
					{% for theme in themeMass %}
						<option value="{{theme.id}}">{{theme.name}}</option>
					{% endfor %}
				</select>
				<br />
				<input style="width: 100%;" type="submit" name="registerQuestion" value="Задать вопрос">
			</form>
			<a href="http://university.netology.ru/user_data/zenkin/diplom-php-inwork/">Вернуться к списку</a>
		</div>
	</body>
</html>