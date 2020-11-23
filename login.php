<?php
    session_start();
    $conn = pg_connect(getenv("postgres://eahoyfmznokkdb:29116c045b75e0e039064e2f54a47a040265b0ee395e8eb1ed425190d7c833cb@ec2-54-166-114-48.compute-1.amazonaws.com:5432/d78vvls71tq6c"));
    if (isset($_POST['login'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $query = $conn->prepare("SELECT * FROM users WHERE name=:name");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<p class="error">Username password combination is wrong!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                header("location: index.php");
            } else {
                echo '<p class="error">Username password combination is wrong!</p>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta name="keywords" content="PHP,PostgreSQL,Insert,Login">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <form method="post">
  
     
    <div class="form-group" action="">
      <label>name</label>
      <input type="text" class="form-control" id="name" placeholder="Masukkan username" name="name">
    </div>
    
     
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="pasword">
    </div>
     
    <input type="submit" name="login" class="btn btn-primary" value="login">
  </form>
</div>
</body>
</html>
