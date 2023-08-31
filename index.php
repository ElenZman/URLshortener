<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL shortener</title>
</head>
<body>
   
<?php 
require_once('Classes\Base58Encoder.php');
require_once('Classes\URLshortener.php');
require_once('Classes\Url.php');

$alert = "<div class=\"alert\">URL не прошел валидацию.</br>".
"Убедитесь, что он соответсвует формату <i>https://site.com/page=somepage?param=1<i></div>";

if(isset($_POST['long-url'])){
    $url = $_POST['long-url'];
    $isValidUrl = filter_var($url, FILTER_VALIDATE_URL);
    if($isValidUrl){        
        $url = parse_url($url);
        if(isset($url["path"])){
          $url= new Url($url["path"]);
          $urlShortener = new URLshortener();
          
          $numericId = $urlShortener->randomizeNumericId();
          $url->numericId = $numericId;
          //check for uniquness
          $num  = $urlShortener->encode($numericId);

          $urlShortener->encode(intval($num));         

        }
        else {
            echo $alert;
        }   
    }
    else {
       echo $alert;
    }
}

?>

<form action="" method="post">
        <input type ="text" name="long-url" placeholder="Введите URL...">
        <input type="submit" name="send" value="Отправить"> 
    </form>


</body>
</html>