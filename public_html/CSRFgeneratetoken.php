<?php
function generate_token()
{
   // Check if a token is present for the current session
   if (!isset($_SESSION["csrf_token"]))
   {
      // No token present, generate a new one
      $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
      $_SESSION["token-expire"] = time() + 3600; // 1 hour = 3600 secs
   }
   else
   {
      // Reuse the token
      $token = $_SESSION["csrf_token"];
   }
   return $token;
}
?>
