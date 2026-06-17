<?php
include 'db.php';

if ($_POST) {
    $miktar = $_POST['miktar'];
    $tarih = $_POST['tarih'];

    $sorgu = $db->prepare("INSERT INTO cekimler (miktar, tarih) VALUES (?, ?)");
    $sorgu->execute([$miktar, $tarih]);

    header("Location: index.php");
}
?>