<?php
  include_once('dbinfo.php');
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
      $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

      $pdo = new PDO("mysql:host=$databaseRegisterSystem->host;dbname=$databaseRegisterSystem->name",
        $databaseRegisterSystem->username,
        $databaseRegisterSystem->password
      );
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $pdo->exec("INSERT INTO users(login, passwd) VALUES ('$login', '$hashedPassword')");
      echo "<br>";
      echo "Pomyslna rejestracja";

      /*if($pdo) {
      } else {
        echo "Nieudana rejestracja";
      }*/
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
    <title>Rejestracja</title>
  </head>
  <body>
    <main>
      <header>
        <h2>Register system</h2>
      </header>
      <form action='<?php echo basename(__FILE__)?>' method="post">
      <p>
        Login:
      </p>
        <input type="text" name='login'>
      <p>
        Password:
      </p>
        <input type="password" name="passwd" id="register-password">
      <p>
        Reveal password:
      </p>
        <input type="checkbox" name="revealpasswd" id="checkbox-reveal" onclick="handleRevealPassword();">
      <p>
        <input type="submit" value="Loguj">
      </p>
      </form>
      <a href="./">Powrót do strony głownej</a>
    </main>
    <script type="text/javascript">
      const revealpasswdCheckbox = document.querySelector('#checkbox-reveal');
      const passwordInput = document.querySelector('#register-password');
      console.log(revealpasswdCheckbox);
      function handleRevealPassword() {
        if(revealpasswdCheckbox.checked) {
          passwordInput.type = 'text';
        } else {
          passwordInput.type = 'password';
        }

      }
    </script>
  </body>
</html>
