<?php 
require_once 'vendor/autoload.php';

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

$search = $_POST["search"];
      // username and password sent from form 
$response = Unirest\Request::get("https://edamam-food-and-grocery-database.p.rapidapi.com/parser?ingr=$search",
  array(
    "X-RapidAPI-Host" => "edamam-food-and-grocery-database.p.rapidapi.com",
    "X-RapidAPI-Key" => "ce1c5a4d17msh87aab1c5ba5a26ep1a7bd7jsn3960aca763eb"
  )
);
console_log($response->body->hints[1]->food->label);
$hintarray = $response->body->hints;
// echo $hintarray[1]->food->label . "<br>";
// echo $hintarray[1]->food->category . "<br>";
// echo $hintarray[1]->food->foodContentsLabel;
for($i=0;$i<5;$i++)
{
    echo "Food Label: ". $hintarray[$i]->food->label . "<br>";
echo "Food Category: ". $hintarray[$i]->food->category . "<br>";
// echo $hintarray[$i]->food->foodContentsLabel;
}
?>