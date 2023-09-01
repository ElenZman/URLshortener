<?php

namespace UrlSHortener\Elena;

use Shortener\Elena\Url;
use Shortener\Elena\URLshortener;

unset($_SESSION['connection_error_message']);
unset($_SESSION['encoder-error']);

if (isset($_POST['send'])) {
    if (isset($_POST['long-url'])) {
        unset($success);
        if (filter_var($_POST['long-url'], FILTER_VALIDATE_URL)) {
    
            $url = parse_url($_POST['long-url']);
            if (isset($url["scheme"])) {
                $longUrl = $_POST['long-url'];
            } else {
                unset($success);
                echo "<div class=\"alert alert-danger\">URL не прошел валидацию.</br>" .
                "Убедитесь, что он соответсвует формату <i>https://site.com/page=somepage?param=1<i></div>";
            }
            if (isset($url["path"])) {
    
                $urlShortener = new URLshortener();
                $randId = $urlShortener->randomizeNumericId();            
                try {
                    $encodedPath = $urlShortener->encode($randId);
                } catch (\Exception $e) {
                      $message=$e->getMessage();
                      $_SESSION['encoder-error'] = $message;
                      header('Location: error-page.php');
                }              
                $url = new Url();
                //таблица имеет ограничение unique на столбцах long_url, short_url
                //если такой url уже существует, то вернется false
                if ($url->create($longUrl,$encodedPath, $randId)) {
                    $success = 'Ваш короткий URL: ' . $url->shortUrl . '</div>';
                } else {
                    unset($success);
                    echo "<div class=\"alert alert-danger w-50\">Короткая ссылка на такой URL уже существует.</div>";
                }
            }
        } else {
            echo $alert;
            unset($success);
        
        }
    } else {
    
        unset($success);
    }
}
?>

<form class="m-2" action="" method="post">
    <input type="text" name="long-url" placeholder="Введите URL...">
    <input type="submit" name="send" value="Отправить">
</form>

<?php if (isset($success)):?>
    <div class="alert alert-success w-50 m-2">{$success}></div>";
<? endif; ?>