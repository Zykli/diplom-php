
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Авторизация</title>
		<style>
			h3 {
				margin: 0;
				padding: 0 0 15px 0;
			}
			form {
			    position: absolute;
			    top: 50%;
			    left: 50%;
			    width: 500px;
			    text-align: center;
			    padding: 15px;
			    background: #a4df85;
			    min-height: 115px;
			    margin-top: -70px;
    			margin-left: -250px;
			}
			label {
				width: 110px;
				display: inline-block;
			}
			#user, #password {
				margin-bottom: 10px;
			}
		</style>
	</head>
	<body>
		<form action="?/admin/login/" method="POST">
			<h3>Авторизация</h3>
			<label for="user">Пользователь:</label>
			<input id="user" name="user" value="" type="text">
			<br />
			<label for="password">Пароль:</label>
			<input id="password" name="password" type="password">
			<br />
			<div style="color: red; margin-bottom: 10px;{{error}}">Пользователь или пароль неверен. <br> Либо данного пользователя не существует</div>
			<input type="submit" name="login" value="Войти">
			<a href="http://university.netology.ru/user_data/zenkin/diplom-php-inwork/">Вернуться к списку</a>
		</form>
	</body>
</html>