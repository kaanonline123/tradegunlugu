<?php
include 'db.php';

if ($_POST) {
    $islem_adi = $_POST['islem_adi'];
    $aciklama  = $_POST['aciklama']; 
    
    // Tarayıcıdan gelmeyen (disabled olan) verileri kontrol edip gelmediyse 0 yazıyoruz
    $kazanc    = isset($_POST['kazanc']) && $_POST['kazanc'] !== '' ? $_POST['kazanc'] : 0;
    $zarar     = isset($_POST['zarar']) && $_POST['zarar'] !== '' ? $_POST['zarar'] : 0;
    $tarih     = $_POST['tarih'];

    $resim_yolu = "";
    if (isset($_FILES['resim']['name']) && $_FILES['resim']['name']) {
        if (!is_dir('uploads')) { mkdir('uploads'); }
        $resim_yolu = 'uploads/' . time() . '_' . $_FILES['resim']['name'];
        move_uploaded_file($_FILES['resim']['tmp_name'], $resim_yolu);
    }

    // Sorguya verileri güvenli bir şekilde gönderiyoruz
    $sorgu = $db->prepare("INSERT INTO islemler (islem_adi, aciklama, kazanc, zarar, tarih, ekran_goruntusu) VALUES (?, ?, ?, ?, ?, ?)");
    $sorgu->execute([$islem_adi, $aciklama, $kazanc, $zarar, $tarih, $resim_yolu]);

    header("Location: index.php");
    exit;
}
?>