<form method="POST">
	<label> email
		<input type="email" name="email">
	</label><br>

	<label> Категория<Br>
		<input type="radio" name="category" value="Продажа"> Продажа<Br>
		<input type="radio" name="category" value="Покупка"> Покупка<Br>
		<input type="radio" name="category" value="Фестивали и ярмарки"> Фестивали и ярмарки<Br>
		<input type="radio" name="category" value="Реклама"> Реклама<Br>
		<input type="radio" name="category" value="Жалоба"> Жалоба<Br>
	</label><br>

	<label> Заголовок
		<input type="text" name="header">
	</label><br>

	<label> Текст объявления
		<textarea name="textarea"></textarea>
	</label><br>

	<input type="submit" name="send" value="Добавить">
</form>

<?php
$mysqli = new mysqli('db', 'root', 'helloworld', 'web');

if (mysqli_connect_errno())
{
	printf(mysqli_connect_error());
	exit();
}

if (
	!empty($_POST['email'])
	&& !empty($_POST['category'])
	&& !empty($_POST['header'])
	&& $_POST['textarea']
)
{
	$email = $_POST['email'];
	$category = $_POST['category'];
	$header = $_POST['header'];
	$textarea = $_POST['textarea'];

	$stmt = $mysqli->prepare(
		'
		INSERT INTO ad (email, title, description, category)
		VALUES (?, ?, ?, ?)
		'
	);

	$stmt->bind_param('ssss', $email, $header, $textarea, $category);
	$stmt->execute();
}

if (
	$result = $mysqli->query(
		'
		SELECT * FROM ad ORDER BY created DESC
	'
	)
)
{
	print("Ads:\n");
	while ($row = $result->fetch_assoc())
	{
		printf("%s (%s) (%s) %s </br>", $row['email'], $row['category'], $row['title'], $row['description']);
	}
	$result->close();
}

$mysqli->close();
