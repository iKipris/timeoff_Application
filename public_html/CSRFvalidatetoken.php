<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST))
{
   if ($_POST["csrf_token"] != $_SESSION["csrf_token"])
   {
      die("CSRF token validation failed");
      exit();
   }

   else if ($_POST["csrf_token"] == $_SESSION["csrf_token"])
   {
      //  EXPIRED
      if (time() >= $_SESSION['token-expire'])
      {
         exit("Token expired. Please reload form.");
      }
   }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET))
{
   if ($_GET["csrf_token"] != $_SESSION["csrf_token"])
   {
      die("CSRF token validation failed");
      exit();
   }

   else if ($_GET["csrf_token"] == $_SESSION["csrf_token"])
   {
      //  EXPIRED
      if (time() >= $_SESSION['token-expire'])
      {
         exit("Token expired. Please reload form.");
      }
   }
}
?>
