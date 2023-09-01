<?php
namespace UrlSHortener\Elena;

use Shortener\Elena\Url;

unset($_SESSION['connection_error_message']);
unset($_SESSION['encoder-error']);

if (isset($_GET['delete-id'])) {

    $id = (int)$_GET['delete-id'];
    $url = new Url();
    if ($url->delete($id)) {
        if (isset($_GET['p']) && isset($_GET['limit'])) {
            $limit = $_GET['limit'];
            $p=$_GET['p'];
            header("Location: index.php?page=all&limit={$limit}&p={$p}");
        }
        header('Location: index.php?page=all');
    }
}

