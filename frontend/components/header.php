<?php
if (!defined('BASE_URL')) {
    exit('Direct access not allowed');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'NSTP System' ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/styles/global.css?v=<?= time() ?>">
    <link rel="icon" type="image/webp" href="<?= BASE_URL ?>/frontend/assets/image/csi.webp">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
