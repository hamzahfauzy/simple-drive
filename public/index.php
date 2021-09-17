<?php
session_start();
require '../functions.php';

if(isset($_GET['action']) && !empty($_GET['action']))
{
    load_action($_GET['action']);
    die();
}

$page_map = require '../config/page_map.php';

$page = 'dashboard/index';
if(isset($_GET['page']) && !empty($_GET['page']) && isset($page_map[$_GET['page']]))
    $page = $page_map[$_GET['page']];
else
    $page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : $page;

if(!isset($_SESSION['auth']))
    $page = 'auth/login';

load($page,1);