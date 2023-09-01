<?php 

namespace UrlSHortener\Elena;

require_once(APP_DIR.'/Classes/Paginator.php');
use Shortener\Elena\Paginator;


unset($_SESSION['connection_error_message']);
unset($_SESSION['encoder-error']);
?>

<div class="container">
<div class="table-responsive mb-1">
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <td scope="col">No.</td>
                <th scope="col">Длинный URL</th>
                <th scope="col">Короткий URL</th>
                <th scope="col">Дата создания</th>
                <th scope="col" colspan="2"></th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            $paginator = new Paginator(5, 'urls');
            if (isset($_GET['p'])) {
                $currentPage = $_GET['p'];
            } else {
                $currentPage = 1;
            }

            $result = $paginator->getData($currentPage);?>
           <? if ($result !=false):?>
           <? foreach ($result as $url) : ?>
                <tr>
                    <td scope="row"><? echo $url['id'] ?></td>
                    <td scope="row"><? echo $url['long_url'] ?></td>
                    <td scope="row"><? echo $url['short_url'] ?></td>
                    <td scope="row"><? echo $url['generation_date'] ?></td>
                    <?php $id = $url['id'];
                    $hrefUpdate = "<a class=\"btn\" href=\"index.php?page=update&update-id={$id}\"><i class=\"bi bi-arrow-repeat\"></i></a>";              
                    $hrefDelete = "<a class=\"btn\" href=\"index.php?page=delete&delete-id={$id}\"><i class=\"bi bi-trash\"></i></a>";              
                     ?>
                    
                    <td><? echo $hrefUpdate?></td>
                    <td><? echo $hrefDelete?></td>
                </tr>
            <? endforeach; ?>
            <? endif;?>
        </tbody>
    </table>
</div>

<nav class="mx-auto d-flex justify-content-center">
    <ul class="pagination">
        <?php
        $totalLinks = $paginator->getTotalPages();
        $limit = $paginator->getItemsPerPage();
        if ($currentPage == 1 || $totalLinks <= 1) : ?>
            <li class="page-item mx-0 disabled">
                <a class="page-link" <? echo "href=\"index.php?page=all&limit=" . $limit . "&p=1" . "\""; ?>>&laquo;</a>
            </li>
        <?php elseif ($currentPage > 1 && $totalLinks > 1) : ?>
            <li class="page-item mx-0">
                <a class="page-link" <? echo "href=\"index.php?page=all&limit=" . $limit . "&p=" . $currentPage - 1 . "\""; ?>>&laquo;</a>
            </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalLinks; $i++) : ?>
            <li class="page-item mx-0">
                <a class="page-link " <? echo "href=\"index.php?page=all&limit=" . $limit . "&p=" . $i . "\""; ?>><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <?php if ($currentPage == $totalLinks) : ?>
            <li class="page-item mx-0 disabled">
                <a class="page-link" <? echo "href=\"index.php?page=all&limit=" . $limit . "&p=" . $totalLinks . "\""; ?>>&raquo;</a>
            </li>
        <?php else : ?>
            <li class="page-item mx-0">
                <a class="page-link" <? echo "href=\"index.php?page=all&limit=" . $limit . "&p=" . $currentPage + 1 . "\""; ?>>&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
</div>