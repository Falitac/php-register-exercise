<?php
  include_once('dbinfo.php');
  printf("Test<br>");
  try
  {
    $failed = false;
    if(empty($_POST['login'])) {
      $failed = true;
    }
    if(empty($_POST['passwd'])) {
      $failed = true;
    }
    if(!$failed) {
      $login = $_POST['login'];
      $passwd = $_POST['passwd'];

      $pdo = new PDO("mysql:host=$databaseRegisterSystem->host;dbname=$databaseRegisterSystem->name",
        $databaseRegisterSystem->username,
        $databaseRegisterSystem->password
      );
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->query("SELECT login, passwd, gold FROM users WHERE login = '$login'");
      $result = $stmt->fetch();
      $stmt->closeCursor();

      //print_r($result);
      echo "<br>";
      if(password_verify($passwd, $result['passwd'])) {
        printf("Masz %d złota<br>", intval($result['gold']));
        echo "poprawne haslo";
      } else {
        echo "niepoprawne haslo";
      }
    }
  }
  catch(PDOException $e)
  {
     echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet"/>
    <title>Login</title>
  </head>
  <body>
    <main>
      <header>
        <h2>Login system</h2>
      </header>
      <form action='' method="post">
      <p>
        Login:
      </p>
        <input type="text" name='login'>
      <p>
        Password:
      </p>
        <input type="text" name="passwd">
      <p>
        <input type="submit" value="Loguj">
      </p>
      </form>
      <a href="register.php">Rejestracja</a>
    </main>
  </body>
</html>
