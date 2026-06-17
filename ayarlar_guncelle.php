<?php
include 'db.php';

if ($_POST) {
    $yeni_cuzdan = $_POST['toplam_cuzdan'];
    $yeni_hedef = $_POST['birikim_hedefi'];

    $guncelle = $db->prepare("UPDATE ayarlar SET toplam_cuzdan = ?, birikim_hedefi = ? WHERE id = 1");
    $guncelle->execute([$yeni_cuzdan, $yeni_hedef]);

    header("Location: index.php");
}
?>