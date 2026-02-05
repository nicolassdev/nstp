<?php
require_once __DIR__ . '/../boot/BaseURL.php';

session_unset();
session_destroy();

header('Location: ' . BASE_URL . 'index.php?page=login');
exit;
