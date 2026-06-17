<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Önce resim yolunu bulalım ki klasörden de silelim
    $sorgu = $db->prepare("SELECT ekran_goruntusu FROM islemler WHERE id = ?");
    $sorgu->execute([$id]);
    $islem = $sorgu->fetch();

    if ($islem && $islem['ekran_goruntusu'] != "" && file_exists($islem['ekran_goruntusu'])) {
        unlink($islem['ekran_goruntusu']); // Dosyayı klasörden siler
    }

    // Veritabanından kaydı sil
    $sil = $db->prepare("DELETE FROM islemler WHERE id = ?");
    $sil->execute([$id]);
}

header("Location: index.php"); // Ana sayfaya geri dön
?>