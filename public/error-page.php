
<?php 
include('partials/header.php');
if(isset($_SESSION['connection_error_message'])){
    $message = $_SESSION['connection_error_message'];
};
if(isset($_SESSION['encoder-error'])){
    $message = $_SESSION['encoder-error'];
};
?>
<h1><? echo $message?></h1>
<a href="index.php?page=create">Назад</a>