<?php
include 'db.php';

if ($_POST) {
    $baslik = $_POST['baslik'];
    $not_icerik = $_POST['not_icerik'];
    $resim_yolu = "";

    if ($_FILES['not_resim']['name']) {
        if (!is_dir('uploads')) { mkdir('uploads'); }
        $resim_yolu = 'uploads/note_' . time() . '_' . $_FILES['not_resim']['name'];
        move_uploaded_file($_FILES['not_resim']['tmp_name'], $resim_yolu);
    }

    $sorgu = $db->prepare("INSERT INTO egitim_notlari (baslik, not_icerik, resim_yolu) VALUES (?, ?, ?)");
    $sorgu->execute([$baslik, $not_icerik, $resim_yolu]);

    header("Location: index.php#notlar");
}
?>