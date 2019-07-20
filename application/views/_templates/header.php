<?php
/**
 * Bblocks direct access to this file (so an attacker can't look into application/views/_templates/header.php).
 * "$this" only exists if header.php is loaded from within the app, but not if THIS file here is called directly.
 * If someone called header.php directly we completely stop everything via exit() and send a 403 server status code.
 * Make sure there are NO spaces etc. before "<!DOCTYPE" as this might break page rendering.
 */
if (!isset($this))
    exit(header('HTTP/1.0 403 Forbidden'));
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= htmlspecialchars(URL, ENT_QUOTES) ?>assets/css/main.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?= htmlspecialchars(URL, ENT_QUOTES) ?>assets/css/gallery.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?= htmlspecialchars(URL, ENT_QUOTES) ?>assets/css/gallery_modal.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?= htmlspecialchars(URL, ENT_QUOTES) ?>assets/css/user.css" type="text/css" media="all">
    <link rel="shortcut icon" href="<?= htmlspecialchars(URL, ENT_QUOTES) ?>favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
</head>
<body>
<div class="container main">
<section class="section level">
    <nav class="navbar level" role="navigation" aria-label="main navigation" style="z-index: 0">
        <a class="navbar-item title level-item" href="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>">Home</a>
        <a class="navbar-item title level-item" href="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>gallery">Gallery</a>

            <?php if (!empty($_SESSION['logged_user'])) :?>
                <a class="navbar-item title level-item" href="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>userArea"><?= htmlspecialchars($_SESSION['logged_user']); ?>'s Area</a>
                <a class="navbar-item title level-item" href="#"> </a>
                <a class="navbar-item title level-item" href="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>userArea/logout" style="margin-bottom: 1.5rem;">Logout</a>
            <?php
            else: ?>
                <a class="navbar-item title level-item" href="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>userArea/login">Login</a>
                <a class="navbar-item title level-item" href="<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES); ?>userArea/register" style="margin-bottom: 1.5rem;">Register</a>
            <?php endif; ?>
    </nav>
</section>
