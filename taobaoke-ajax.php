<?php

require_once('taobaoke-library.php');

$str = tbk_getCategoriesJson($_GET['cid']);

echo $str;
?>