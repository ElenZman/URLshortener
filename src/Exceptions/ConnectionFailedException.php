<?php

namespace Shortener\Elena;

/**
 * Данное исключение выбрасыватеся если возникли проблемы с установкой соединения с базой данных
 * и перенаправит на страницу ошибок, которая в свою очередь отоббразит его на user friendly странице
 */

class ConnectionFailedException extends \Exception
{
    public function __construct()
    {
        $message = "Connection failed. Please check your internet connection and try again.";
        parent::__construct($message);
    }
}
