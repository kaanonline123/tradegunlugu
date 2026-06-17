<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Çekim kaydını sil
    $sil = $db->prepare("DELETE FROM cekimler WHERE id = ?");
    $sil->execute([$id]);
}

header("Location: index.php");
?>