<?php
session_start();
$config = include('C:/OpenServer/domains/URLshortener/app/config.php');

require_once(APP_DIR.'Classes/Base58Encoder.php');
require_once(APP_DIR.'Classes/DbConnection.php');
require_once(APP_DIR.'Classes/Url.php');
require_once(APP_DIR.'Classes/URLShortener.php');
require_once(APP_DIR.'Classes/Paginator.php');

include('partials/header.php');
?>
<main>
    <div class="container-fluid content">
        <?php

        if (!isset($_GET['page'])) {
            $page = 'create';
        } else {
            $page = $_GET['page'];
        }
        switch ($page) {
            case 'create':
                include_once(APP_DIR.'Pages\create.php');
                break;
            case 'all':
                include_once(APP_DIR . 'Pages\all.php');
                break;
            case 'update':
                include_once(APP_DIR . 'Pages\update.php');
                break;
            case 'delete':
                include_once(APP_DIR . 'Pages\delete.php');
                break;
        
        } ?>
    </div>
</main>
</body>

</html>