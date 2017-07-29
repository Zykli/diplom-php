<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Администрирование</title>
		<style>
			body {
				position: relative;
				padding: 0;
				margin: 0;
			}
			.header {
				text-align: center;
				background-color: #a4df85;
				padding: 150px 0px ;
				margin: 0;
			}
			.close {
				position:absolute;
				right: 10px;
    			top: 10px;
    			height: 13px;
    			width: 13px;
			}
			.close::after, .close::before {
				content: '';
				width: 13px;
			    border: 1px solid black;
			    transform: rotate(45deg);
			    position: absolute;
			    top: 5px;
			    left: 0;
			}
			.close:hover::after, .close:hover::before {
				border-color: blue;
			}
			.close::before {
			    transform: rotate(135deg);
			}
			form {
				background-color: beige;
				text-align: center;
				padding: 10px 0;
			}
			label {
				width: 110px;
				display: inline-block;
			}
			#user, #password {
				margin-bottom: 10px;
			}
			table {
				border-collapse: collapse;
				margin: 20px auto 0;
			}
			td, th {
				border: 1px solid black;
				padding: 2px 4px;
			}
			th {
				background-color: grey;
			}
			td > a {
				margin-right: 5px;
			}
		</style>
	</head>
	<body style="position: relative;">
		<div>
			<h2 class="header">Администрирование</h2>
		</div>
		<div style="width: 800px; margin: 0 auto;">
			<div style="float: left">
				<a href="?/admin/admin/list">Администраторы</a><br>
				<a href="?/admin/admin/theme">Темы</a><br>
				<a href="?/admin/logout">выйти</a>
			</div>

			<!-- администраторы -->
			<div style="margin-left: 150px; position: relative;
    background-color: beige; padding: 10px;{{listView}}">
				<h3 style="text-align: center; margin: 0; padding: 0">Администраторы</h3>
				<a href="?/admin/admin" class="close"></a>
				<div></div>
				<a href="?/admin/admin/list/?/createAdmin">Создать</a>
				<form style="{{createAdmin}}" method="POST">
					<label for="user">Имя:</label>
					<input id="user" name="user" value="" type="text">
					<br />
					<label for="password">Пароль:</label>
					<input id="password" name="password" type="password">
					<br />
					<input type="submit" name="createAdmin" value="Создать">
				</form>
				<form style="{{changeAdminPassword}}" method="POST">
					<label for="password">Новый пароль:</label>
					<input id="password" name="password" type="password">
					<br />
					<input type="submit" name="changeAdminPassword" value="Изменить">
				</form>
				<div style="background-color: red; display: none">Нельзя удалить текущего авторизованного пользователя</div>
				<table>
					<thead>
						<tr>
							<th>Имя пользователя</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						{% for admin in adminMass %}
							<tr>
								<td>{{ admin.user }}</td>
								<td>
									<a href="?/admin/admin/list/?/delete/{{admin.id}}">Удалить</a>
									<a href="?/admin/admin/list/?/changeAdminPassword/{{admin.id}}">Изменить пароль</a>
								</td>
							</tr>
					    {% endfor %}
					</tbody>
				</table>
			</div>

			<!-- темы -->
			<div style="margin-left: 150px; position: relative;
    background-color: beige; padding: 10px;{{themeView}}">
				<h3 style="text-align: center; margin: 0; padding: 0">Темы</h3>
				<a href="?/admin/admin" class="close"></a>
				<div></div>
				<a href="?/admin/admin/theme/?/insert">Создать</a>
				<a href="?/admin/admin/theme/?/noAnswer">Список вопросов без ответа</a>
				<form style="{{themeInsert}}" method="POST">
					<label for="newTheme">Имя:</label>
					<input id="newTheme" name="newTheme" value="" type="text">
					<br />
					<input type="submit" name="createTheme" value="Создать">
				</form>
				<table>
					<thead>
						<tr>
							<th>Имя темы</th>
							<th>Вопросов всего</th>
							<th>Вопросов опубликовано</th>
							<th>Вопросов без ответов</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						{% for theme in themeMass %}
						<tr>
							<td><a href="?/admin/admin/theme/?/list/{{theme.id}}">{{theme.name}}</a></td>
							<td>{{themeDataMass[theme.name][0]}}</td>
							<td>{{themeDataMass[theme.name][1]}}</td>
							<td>{{themeDataMass[theme.name][2]}}</td>
							<td>
								<a href="?/admin/admin/theme/?/delete/{{theme.id}}">Удалить</a><br>
								<a href="?/admin/admin/theme/?/deleteAll/{{theme.id}}">Удалить все вопросы</a>
							</td>
						</tr>
					    {% endfor %}
					</tbody>
				</table>
			</div>

			<!-- вопросы без ответов -->
			<div onclick="this.style.display= 'none'" style="position: absolute; top: 0;	left: 0; height: 100vh; width: 100vw; background-color: rgba(0,0,0,.5);{{noAnswerQuestionsView}}">
				<div style="width: 80%; margin-top: 4vw; margin-left: -42%; position: absolute; top: 0; left: 50%; border: 1px solid; background-color: beige; padding: 10px; overflow-x: auto; max-height: 80%;">
					<h3 style="text-align: center; margin: 0; padding: 0">Все вопросы без ответов</h3>
					<a href="?/admin/admin/theme" class="close"></a>
					<div></div>
					<form style="{{editQuestion}}" method="POST">
						<label style="vertical-align: top;" for="editWording">Вопрос:</label>
						<textarea style="width: 50%;" id="editWording" name="wording" type="text">{{editQuestionData[1]}}</textarea>
						<br />
						<label style="vertical-align: top;" for="editAnswer">Ответ:</label>
						<textarea style="width: 50%;" id="editAnswer" name="answer" type="text">{{editQuestionData[2]}}</textarea>
						<br />
						<label style="vertical-align: top;" for="editAuthor">Автор:</label>
						<input style="width: 50%;" id="editAuthor" name="author" type="text" value="{{editQuestionData[6]}}">
						<br />
						<input style="margin-bottom: 10px;" type="checkbox" id="publicate" name="status">
						<label for="publicate">Опубликовать</label>
						<br />
						<select id="newCategoryId" name="category_id">
							{% for theme in themeMass %}
								<option value="{{theme.id}}" {% if theme.id == editQuestionData[3]%} selected {% endif %}>{{theme.name}}</option>
				    		{% endfor %}
						</select>
						<br />
						<input type="submit" value="Записать">
					</form>
					<table style="width: 100%;">
						<thead>
							<tr>
								<th>Вопрос</th>
								<th>Ответ</th>
								<th>Дата добавления</th>
								<th>Автор</th>
								<th>Тема</th>
								<th>Статус</th>
								<th>Действия</th>
							</tr>
						</thead>
						<tbody>
							{% for question in questionWhithNullAnswer %}
							{% if question.answer == null %}
								<tr>
									<td style="word-break: break-all; width: 35%;">{{question.wordign}}</td>
									<td style="word-break: break-all; width: 35%;">{{question.answer}}</td>
									<td>{{question.create_date}}</td>
									<td>{{question.author}}</td>
									<td>
										{% for theme in themeMass %}
										{% if question.category_id == theme.id%}
											{{theme.name}}
										{% endif %}
							    		{% endfor %}
									</td>
									{% if question.answer == null %}
									    <td style="color: orange;">Ожидает ответа</td>
									{% elseif question.status == 0 %}
										<td style="color: red;">Cкрыт</td>
									{% elseif question.status == 1 %}
										<td style="color: green;">Опубликован</td>
									{% endif %}
									<td>
										<a href="?/admin/admin/theme/?/noAnswer/delete/{{question.id}}">Удалить</a><br>
										<a href="?/admin/admin/theme/?/noAnswer/edit/{{question.id}}">Изменить</a><br>
									</td>
								</tr>
							{% endif %}
						    {% endfor %}
						</tbody>
					</table>
				</div>
			</div>

			<!-- вопросы темы -->
			<div onclick="this.style.display= 'none'" style="position: absolute; top: 0;	left: 0; height: 100vh; width: 100vw; background-color: rgba(0,0,0,.5);{{themeQuestions}}">
				<div style="width: 80%; margin-top: 4vw; margin-left: -42%; position: absolute; top: 0; left: 50%; border: 1px solid; background-color: beige; padding: 10px; overflow-x: auto; max-height: 80%;">
					<h3 style="text-align: center; margin: 0; padding: 0">Вопросы по теме <?= $themeName ?></h3>
					<a href="?/admin/admin/theme" class="close"></a>
					<div></div>
					<form style="{{editQuestion}}" method="POST">
						<label style="vertical-align: top;" for="editWording">Вопрос:</label>
						<textarea style="width: 50%;" id="editWording" name="wording" type="text">{{editQuestionData[1]}}</textarea>
						<br />
						<label style="vertical-align: top;" for="editAnswer">Ответ:</label>
						<textarea style="width: 50%;" id="editAnswer" name="answer" type="text">{{editQuestionData[2]}}</textarea>
						<br />
						<label style="vertical-align: top;" for="editAuthor">Автор:</label>
						<input style="width: 50%;" id="editAuthor" name="author" type="text" value="{{editQuestionData[6]}}">
						<br />
						<input style="margin-bottom: 10px;" type="checkbox" id="publicate" name="status" {% if editQuestionData[5] == 1%} checked {% endif %}>
						<label for="publicate">Опубликовать</label>
						<br />
						<input type="submit" value="Записать">
					</form>
					<table style="width: 100%;">
						<thead>
							<tr>
								<th>Вопрос</th>
								<th>Ответ</th>
								<th>Дата добавления</th>
								<th>Автор</th>
								<th>Статус</th>
								<th>Действия</th>
							</tr>
						</thead>
						<tbody>
							{% for question in themeQuestionsData %}
								<tr>
									<td style="word-break: break-all; width: 35%;">{{question.wordign}}</td>
									<td style="word-break: break-all; width: 35%;">{{question.answer}}</td>
									<td>{{question.create_date}}</td>
									<td>{{question.author}}</td>
									{% if question.answer == null %}
									    <td style="color: orange;">Ожидает ответа</td>
									{% elseif question.status == 0 %}
										<td style="color: red;">Cкрыт</td>
									{% elseif question.status == 1 %}
										<td style="color: green;">Опубликован</td>
									{% endif %}
									<td>
										<a href="?/admin/admin/theme/?/list/{{theme}}/delete/{{question.id}}">Удалить</a><br>
										<a href="?/admin/admin/theme/?/list/{{theme}}/edit/{{question.id}}">Изменить</a><br>
										{% if question.status == 0 %}
											<a href="?/admin/admin/theme/?/list/{{theme}}/publicate/{{question.id}}">Опубликовать</a><br>
										{% else %}
											<a href="?/admin/admin/theme/?/list/{{theme}}/hide/{{question.id}}">Скрыть</a><br>
										{% endif %}
										<a href="?/admin/admin/theme/?/list/{{theme}}/changeTheme/{{question.id}}">Изменить тему</a><br>
									</td>
								</tr>
						    {% endfor %}
						</tbody>
					</table>
				</div>
			</div>

			<div onclick="this.style.display= 'none'" style="position: absolute; top: 0; left: 0; height: 100vh; width: 100vw; background-color: rgba(0,0,0,.5); width: 100vw; {{changeTheme}}">
				<form method="POST" style="width: 500px; padding: 15px 0; margin: 13% auto 0; position: relative;">
					<label style="width: 200px;" for="newCategoryId">Выберите новую тему:</label>
					<select id="newCategoryId" name="category_id">
						{% for theme in themeMass %}
							<option value="{{theme.id}}">{{theme.name}}</option>
			    		{% endfor %}
					</select>
					<input type="submit" value="Изменить">
					<!-- <a href="" onclick="javascript:history.back();" class="close"></a> -->
				</form>
			<div>

		</div>
	</body>
</html>