<?php
function isValid($pattern ,$subject){   //vérifie la regex puis renvoi vrai ou faux
    if (preg_match($pattern, $subject)) {
        return true;
    } else {
        return false;
    }
}

function isSame($value1, $value2){ //compart si les mdp sont identique
    if ($value1 == $value2) {
        return true;
    }
}

function mailExist($element, $array){ //compart le mail avec les mails existant et renvoi vrai si elle n'est pas trouvé
    if (in_array($element, $array)) {
        return false;
    } else { 
        return true;
    }
}

$name = htmlspecialchars($_POST['name'] ?? 'Vide');
$firstname = htmlspecialchars($_POST['firstname'] ?? 'Vide') ;
$email = htmlspecialchars($_POST['email'] ?? 'Vide') ;
$password = htmlspecialchars($_POST['password'] ?? 'Vide') ;
$confirm = htmlspecialchars($_POST['confirm'] ?? 'Vide') ;
$regexName = "/^[a-z ,.'-]+$/i";
$regexMail = "/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/";
$regexPassword = "/^(?=.*?[A-Z])(?=.*?[a-z]).{5,}$/";
$mailArray = ['julien@gmail.com', 'paul@gmail.com', 'habib@hotmail.fr'];

if (isset($_POST['submit'])) { //si submit est dans le post
    $count = 0;
    if (!isValid($regexName, $name)) { // si la regex n'est pas valide
        $errorName = 'Nom incorrect, exemple : Macron'; // mettre un message
        $count++; // incrémente un conter d'erreur
        $className = 'is-invalid';
    }
    if (!isValid($regexName, $firstname)) {
        $errorFirstname = 'Prénom incorrect, exemple : Emmanuel';
        $count++;
        $classFirstname = 'is-invalid';
    }
    if (!isSame($password, $confirm)) {
        $errorPassword =  'Le mot de passe ne correspond pas';
        $count++;
        $classPassword = 'is-invalid';
    }
    if (!isValid($regexPassword, $password)) {
        $errorMdp = 'Mot de passe incorrect, exemple : 25KhjG';
        $count++;
        $classMdp = 'is-invalid';
    }
    if (!isValid($regexMail, $email)) {
        $errorMail = 'Mail incorrect, exemple : john@gmail.com';
        $count++;
        $classMail = 'is-invalid';
    } elseif (!mailExist($email, $mailArray)) {
        $errorMail = 'Ce mail est déja inscrit';
        $count++;
        $classMail = 'is-invalid';
    }
    if ($count == 0) { // le conteur est à 0
        header('Location: welcome.php?name='.$name.'&firstname='.$firstname); // change de page avec le bonne url pour récupéré en GET
        exit(); // stop le script
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Formulaire</title>
</head>
<body>
    <h1 class="mb-5">FORMULAIRE</h1>
    <div class="myForm">
        <form action="index.php" method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control <?= isset($className) ? $className : '' ?>" id="name" name="name" required value="<?= (isset($_POST['name']))? htmlspecialchars($_POST['name']):'';?>" > <!-- si il ya le name dans POSt affiche le sinon met rien -->
            <div id="emailHelp" class="form-text"><?= $errorName ?? '' ?></div> <!-- affiche le message d'erreur -->
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control <?= isset($classFirstname) ? $classFirstname : '' ?>" id="firstname" name="firstname" required value="<?= (isset($_POST['firstname']))? htmlspecialchars($_POST['firstname']):'';?>">
            <div id="emailHelp" class="form-text"><?= $errorFirstname ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse mail</label>
            <input type="email" class="form-control <?= isset($classMail) ? $classMail : '' ?>" id="email" name="email" aria-describedby="emailHelp" required value="<?= (isset($_POST['email']))? htmlspecialchars($_POST['email']):'';?>">
            <div id="emailHelp" class="form-text"><?= $errorMail ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control <?= isset($classMdp) ? $classMdp : '' ?>" id="password" name="password" required>
            <div id="emailHelp" class="form-text"><?= $errorMdp ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="confirm" class="form-label">Confirmation du mot de passe</label>
            <input type="password" class="form-control <?= isset($classPassword) ? $classPassword : '' ?>" id="password2" name="confirm" required>
            <div id="emailHelp" class="form-text"><?= $errorPassword ?? '' ?></div>
        </div>
        <button type="submit" class="btn btn-primary" id="btn" name="submit">S'INSCRIRE</button>
        </form>
    </div>

</body>
</html>