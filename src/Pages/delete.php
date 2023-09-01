<?php
namespace UrlSHortener\Elena;

use Shortener\Elena\Url;

unset($_SESSION['connection_error_message']);
unset($_SESSION['encoder-error']);

if (isset($_GET['delete-id'])) {

    $id = (int)$_GET['delete-id'];
    $url = new Url();
    if ($url->delete($id)) {
        header('Location: index.php?page=all');
    }
}
