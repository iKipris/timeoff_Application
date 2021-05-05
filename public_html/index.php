<?php
require ('config.php');
require ('filter.php');

require ('CSRFvalidatetoken.php');
// user already logged in the site
if (isset($_SESSION["user_type"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_email"]))
{
   if ($_SESSION["user_type"] == 'Employee')
   {
      header("Location: employeedashboard.php");
      exit();
   }
   elseif ($_SESSION["user_type"] == 'Supervisor')
   {
      header("Location: adminstratordashboard.php");
      exit();
   }
}

$_SESSION["csrf_token"] = bin2hex(random_bytes(32));
$_SESSION["token-expire"] = time() + 3600; // 1 hour = 3600 secs
//Initialize output message of form
$e_msg = '<h3>Welcome Aboard</h3>
<p >
   Welcome to the application sign-in. <br>
   Please enter your credentials to log in your dashboard page
</p>';

if ((isset($_POST['email'])) && (isset($_POST['pass'])) && !(empty($_POST['email'])) && !(empty($_POST['pass'])))
{
   $email = $_POST['email'];
   $pass = $_POST['pass'];

   try
   {
      $stmt = $DB->prepare('SELECT * FROM users');
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      //search in database for user
      foreach ($results as $result)
      {

         //User found condition
         if ($result["email"] == $email && password_verify($pass, $result['password']))
         {
            $_SESSION['user_name'] = $result["firstname"] . ' ' . $result["lastname"];
            $_SESSION['user_email'] = $result["email"];
            $_SESSION['user_type'] = $result["user_type"];
            if ($result["user_type"] == 'Employee')
            {
               header("Location: employeedashboard.php");
               exit();
            }
            elseif ($result["user_type"] == 'Supervisor')
            {
               header("Location: adminstratordashboard.php");
               exit();
            }
         }

      }

      //User Not found condition
      $e_msg = '<h3>Wrong credentials</h3>
      <p >
         Consider contacting a supervisor <br>
         He will able to guide you  to gain access to the dashboard page
      </p>';

   }
   catch(Exception $ex)
   {
      $e_msg = $ex->getMessage();
   }

}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="./assets/css/indexstyle.css" />
      <title>Sign in & Sign up</title>
   </head>
   <body>
      <div class="container">
         <div class="forms-container">
            <div class="signin-signup">
               <form method = "post" class="sign-in-form">
                  <h2 class="title">Sign in</h2>
                  <div class="input-field">
                     <i class="fas fa-user"></i>
                     <input type="text" name="email" placeholder="Email" />
                  </div>
                  <div class="input-field">
                     <i class="fas fa-lock"></i>
                     <input type="password" name="pass" placeholder="Password" />
                     <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"] ; ?>" />
                  </div>
                  <input type="submit" value="Login" class="btn solid" />
               </form>
            </div>
         </div>
         <div class="panels-container">
            <div class="panel left-panel">
               <div class="content">
                  <?php echo($e_msg) ?>
                  <button class="btn transparent">
                  FAQ
                  </button>
               </div>
               <img src="./assets/img/log.svg" class="image" alt="" />
            </div>
         </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   </body>
</html>
