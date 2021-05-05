


<?php


//filter removes html tags
foreach($_POST as $key => $value)
{
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $value = clean($value);
    $_POST[$key] = $value ;
}
//remove special characters
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-@.]/', '', $string); // Removes special chars.
}

//filter removes html tags
foreach($_GET as $key => $value)
{
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $value = clean($value);
    $_POST[$key] = $value ;
}
?>
