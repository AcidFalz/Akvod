<?php
/* Содержит Шапку и подключение файла с JavaScript

*/

echo '<!DOCTYPE html>
<html>
<head>
    <title>АКВОД АДМИН</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/admin/css/admin.css" media="all">
    <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
    <script type="text/javascript" language="javascript" src="/admin/chasti_titula/glavnaya_stranitsa.js"></script>
    <script type="text/javascript" language="javascript" src="/admin/smenit_parol/smenit_parol.js"></script>
    <script type="text/javascript" language="javascript" src="/admin/opovescheniya/sohranit_nastroyki.js"></script>
    <script type="text/javascript" language="javascript" src="/admin/zakazi/zakazi.js"></script>
    <script type="text/javascript" language="javascript" src="/admin/tovari/tovari.js"></script>
    <script type="text/javascript" language="javascript" src="/admin/novosti/novosti.js"></script>

</head>
<body>

<span class="noselect zagolovok_admin_stranitsi">АКВОД АДМИН</span>

<a href="/admin/login/vyity.php" title="Выйти из страницы администратора" class="pomestit_sprava">Выйти из сеанса: ';echo $_SESSION['imya_admina'];echo '</a>




';