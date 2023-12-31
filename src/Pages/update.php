<?php

namespace UrlSHortener\Elena;

use Shortener\Elena\Url;
use Shortener\Elena\URLshortener;

unset($_SESSION['connection_error_message']);
unset($_SESSION['encoder-error']);

if (isset($_GET['update-id'])) {

    $id = $_GET['update-id'];
    $url = new Url();
    $tempUrl = $url->getById($id);
    $shortener = new URLshortener();
    $randId = $shortener->randomizeNumericId();
    try {
        $encodedPath = $shortener->encode($randId);
    } catch (\exception $e) {
        $_SESSION['encoder-error'] = $message;
        header('Location: error-page.php');
    }

    if($url->updateShortUrl($tempUrl->longUrl, $encodedPath, $tempUrl->id)) {
        header('Location: index.php?page=all');
    } 
}
