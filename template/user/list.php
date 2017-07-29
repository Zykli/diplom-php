<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<style type="text/css">
			body {
				margin: 0;
				padding: 0;
			}
			.header {
				text-align: center;
				/*font-size: 24px;*/
				background-color: #a4df85;
				padding: 150px 0px ;
				margin: 0;
			}
			h4 {
				margin: 0;
			}
			.menu-item {
				padding: 5px;
			}
			.menu-item > a {
				display: inline-block;
				width: 100%
			}
			.menu-item:hover, .question:hover {
				background: darkgray;
			}
			.wordign {
				display: block;
				width: 100%;
				word-break: break-word;
				color: black;
    			text-decoration: none;
			}
			.question {
				border-bottom: 1px solid darkgray;
			}
		</style>
		<script type="text/javascript">
			window.onload = function () {
				var question = document.getElementsByClassName('wordign');
				for (var i = 0; i < question.length; i++) {
					question[i].onclick = function() {
						var nextElement = this.nextSibling.nextSibling
						var display = nextElement.style.display;
						if (display === "none") {
							nextElement.style.display = "block";
						} else {
							nextElement.style.display = "none";
						}
					}
				}
				
			}
		</script>
	</head>
	<body>
		<div>
			<div style="width: 800px; margin: 0 auto; position: relative;">
				<div style="position: absolute; top: 0; right: 0;">
					<a href="?/admin/login">Войти</a>
				</div>
			</div>
			<h2 class="header">FAQ</h2>
		</div>
		
		<div style="width: 800px; margin: 0 auto;">
			<div style="float: left; width: 125px; background: lightgray; border: 1px solid darkgray;">
				<div class="menu-item">
					<a href="?/user/add">Задать вопрос</a>
				</div>
				<div style="padding: 5px;">
					<h4>Категории</h4>
				</div>
				{% for theme in themeMass %}
				<div class="menu-item">
					<a href="#{{theme.name}}">{{theme.name}}</a>
				</div>
				{% endfor %}
			</div>
			<div style="margin-left: 135px;">
				<ul style="list-style: none; -webkit-padding-start: 0px;background: lightgray; border: 1px solid darkgray;">
					{% for theme in themeMass %}
						<li style="padding: 8px 0px; text-align: center; border-bottom: 1px solid darkgray;" id="{{theme.name}}" class="category-head">{{theme.name}}</li>
						{% for question in questionsMass %}
							{% if theme.id == question.category_id and question.answer %}
							<li class="question" style="padding: 5px;">
								<a class="wordign" href="#{{question.id}}">{{question.wordign}}</a>
								<div id="{{question.id}}" style="display: none; width: 600px; word-break: break-word;">{{question.answer}}</div>
							</li>
							{% endif %}
						{% endfor %}
					{% endfor %}
				</ul>
			</div>

		</div>
	</body>
</html>