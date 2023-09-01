<?php

if (isset($_GET['delete-id'])) {

    $id = (int)$_GET['delete-id'];
    $url = new Url();
    if ($url->delete($id)) {
        header('Location: index.php?page=all');
    }
}
