<?php
	session_start();

	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
	
	// $erreur = array();

	if(isset($_POST['formannonce']))
	{
		$titre = htmlspecialchars($_POST['title']);
		$texte = htmlspecialchars($_POST['story']);
		$ville = htmlspecialchars($_POST['ville']);
		$region = htmlspecialchars($_POST['region']);
		$pays = htmlspecialchars($_POST['pays']);
		
		$can_continue = true;

		if(empty($_POST['title']) OR empty($_POST['story'])
		OR empty($_POST['ville']) OR empty($_POST['region'])
		OR empty($_POST['pays']))
		{
			$can_continue = false;
		}
		
		if(strlen($texte) < 10)
		{
			echo 'minimum 10 caracteres de description';
			$can_continue = false;
		}
		
		if($can_continue == true)
		{
			$insertmember = $bdd->prepare("INSERT INTO ANNONCE(id_membre, titre, texte, ville, region, pays) VALUES(?,?,?,?,?,?)");
			$insertmember->execute(array($_SESSION['id'], $titre, $texte, $ville, $region, $pays));
			
			header("Location: profil.php?id=" . $_SESSION['id']);
		}
	}
?>

<html>
	<head>
		<title>TUTO PHP</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<div align="center">
			<h2>Poster une annonce</h2>
			<br/><br/>

			<form method="POST" action="">
				<table>
					<tr>
						<td>
							<label>Titre :</label>
						</td>
						<td>
							<input type="text" placeholder="Titre de l'annonce" id="title" name="title"/>
						</td>
					</tr>
					<tr>
						<td>
							<label>Lieu :</label>
						</td>
						<td>
							<?php
							$username = $bdd->prepare('SELECT * FROM membres WHERE id=?');
							$username->execute(array($_SESSION['id']));
							$user = $username->fetch();
							
							echo '<input type="text" placeholder="Ville" id="ville" name="ville" value="' . $user['ville'] . '"/>';
							echo '<input type="text" placeholder="Region" id="region" name="region" value="' . $user['region'] . '"/>';
							echo '<input type="text" placeholder="Pays" id="pays" name="pays" value="' . $user['pays'] . '"/>';
							?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="story">Description :</label>
							<textarea id="story" name="story" rows="5" cols="33">Je vends ma belle-mère...</textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<br/>
							<input type="submit" value="Poster l'annonce" name="formannonce"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>