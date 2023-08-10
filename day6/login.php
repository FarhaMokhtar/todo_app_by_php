<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .form{
        border: 1px solid gray;
        border-radius: 15px;
        width: 80%;
        margin: auto;
        justify-content: space-between;
        padding: 1rem;
      }
</style>
</head>
<body>

<form class="form" action="loginlogic.php" method="post">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" name="email">
      <?php if (isset($_GET['email'])) { ?>
            <p class="error"><?php echo $_GET['email']; ?></p>
        <?php } ?>
    </div>
    <div class="form-group col-md-12">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" name="password">
      <?php if (isset($_GET['password'])) { ?>
            <p class="error"><?php echo $_GET['password']; ?></p>
        <?php } ?>
    </div>
  </div>
  
 
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>

</body>
</html>

