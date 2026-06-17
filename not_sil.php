<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sorgu = $db->prepare("SELECT resim_yolu FROM egitim_notlari WHERE id = ?");
    $sorgu->execute([$id]);
    $not = $sorgu->fetch();
    if ($not['resim_yolu'] && file_exists($not['resim_yolu'])) { unlink($not['resim_yolu']); }

    $db->prepare("DELETE FROM egitim_notlari WHERE id = ?")->execute([$id]);
}
header("Location: index.php#notlar");
?>