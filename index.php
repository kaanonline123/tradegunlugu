<?php
session_start();
if (!isset($_SESSION['giris'])) { header("Location: login.php"); exit; }
include 'db.php';

// Verileri Çek
$islemler = $db->query("SELECT * FROM islemler ORDER BY tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
$cekimler = $db->query("SELECT * FROM cekimler ORDER BY tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
$ayarlar = $db->query("SELECT * FROM ayarlar WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$notlar = $db->query("SELECT * FROM egitim_notlari ORDER BY eklenme_tarihi DESC")->fetchAll(PDO::FETCH_ASSOC);

// Hesaplamalar
$toplam_kazanc = 0; $toplam_zarar = 0;
$karli_islem_sayisi = 0; $zararli_islem_sayisi = 0;

foreach($islemler as $is) {
    $toplam_kazanc += $is['kazanc'];
    $toplam_zarar += $is['zarar'];
    if($is['kazanc'] > 0) $karli_islem_sayisi++;
    if($is['zarar'] > 0) $zararli_islem_sayisi++;
}

$toplam_cekim = 0;
foreach($cekimler as $ce) { $toplam_cekim += $ce['miktar']; }

$net_kar_zarar = $toplam_kazanc - $toplam_zarar;
$guncel_cuzdan = ($ayarlar['toplam_cuzdan'] + $net_kar_zarar) - $toplam_cekim;
$hedef_yuzde = ($ayarlar['birikim_hedefi'] > 0) ? ($guncel_cuzdan / $ayarlar['birikim_hedefi']) * 100 : 0;
$win_rate = ($karli_islem_sayisi + $zararli_islem_sayisi > 0) ? ($karli_islem_sayisi / ($karli_islem_sayisi + $zararli_islem_sayisi)) * 100 : 0;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Trading Journal & Academy Pro</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #0f172a; color: #f1f5f9; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155; }
        .stat-label { color: #94a3b8; font-size: 12px; text-transform: uppercase; }
        .stat-value { font-size: 24px; font-weight: 700; margin-top: 5px; }
        .score-box { font-size: 11px; margin-top: 10px; color: #94a3b8; border-top: 1px solid #334155; padding-top: 5px; }
        .profit { color: #10b981; } .loss { color: #ef4444; }
        .withdraw-color { color: #f59e0b; }
        .minimal-settings { background: #1e293b; padding: 12px 20px; border-radius: 10px; border: 1px solid #334155; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; font-size: 13px; border-left: 4px solid #3b82f6; }
        .minimal-settings form { display: flex; gap: 10px; }
        .minimal-settings input { background: #0f172a; border: 1px solid #334155; color: white; padding: 5px; border-radius: 5px; width: 100px; }
        .progress-container { background: #334155; border-radius: 10px; height: 10px; margin-bottom: 25px; overflow: hidden; }
        .progress-bar { background: linear-gradient(90deg, #3b82f6, #8b5cf6); height: 100%; transition: width 0.6s; }
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155; margin-bottom: 20px; }
        input, textarea, button { background: #0f172a; border: 1px solid #334155; color: white; padding: 12px; border-radius: 8px; font-size: 14px; margin-bottom: 10px; width: 100%; box-sizing: border-box; }
        button { cursor: pointer; border: none; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; }
        .note-card { background: #1e293b; border: 1px solid #334155; padding: 15px; border-radius: 10px; margin-bottom: 15px; }
        .note-img { max-width: 100%; border-radius: 8px; margin-top: 10px; border: 1px solid #334155; }
        .logout { color: #94a3b8; text-decoration: none; border: 1px solid #334155; padding: 8px 15px; border-radius: 8px; }
    </style>
    <script>
        function checkFields(source) {
            const k = document.getElementById('kazanc'); const z = document.getElementById('zarar');
            if (source === 'kazanc' && k.value > 0) { z.value = ''; z.disabled = true; } 
            else if (source === 'zarar' && z.value > 0) { k.value = ''; k.disabled = true; } 
            else { k.disabled = false; z.disabled = false; }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header"><h1>📊 Trading Journal</h1><a href="logout.php" class="logout">Çıkış</a></div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Net PNL</div>
                <div class="stat-value <?php echo $net_kar_zarar >= 0 ? 'profit' : 'loss'; ?>"><?php echo number_format($net_kar_zarar, 2); ?>$</div>
                <div class="score-box">
                    🏆 <span class="profit"><?php echo $karli_islem_sayisi; ?> Başarı</span> | 
                    ❌ <span class="loss"><?php echo $zararli_islem_sayisi; ?> Kayıp</span> | 
                    💰 <span class="withdraw-color"><?php echo number_format($toplam_cekim, 2); ?>$ Çekim</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Güncel Cüzdan</div>
                <div class="stat-value"><?php echo number_format($guncel_cuzdan, 2); ?>$</div>
                <div class="score-box">Win Rate: %<?php echo round($win_rate, 1); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Hedef</div>
                <div class="stat-value" style="color:#3b82f6"><?php echo round($hedef_yuzde, 1); ?>%</div>
                <div class="score-box">Kalan: <?php echo number_format($ayarlar['birikim_hedefi'] - $guncel_cuzdan, 2); ?>$</div>
            </div>
        </div>

        <div class="progress-container"><div class="progress-bar" style="width: <?php echo min($hedef_yuzde, 100); ?>%"></div></div>

        <div class="minimal-settings">
            <span>⚙️ Portföy Ayarları</span>
            <form action="ayarlar_guncelle.php" method="POST">
                <input type="number" step="0.01" name="toplam_cuzdan" value="<?php echo $ayarlar['toplam_cuzdan']; ?>">
                <input type="number" step="0.01" name="birikim_hedefi" value="<?php echo $ayarlar['birikim_hedefi']; ?>">
                <button type="submit" style="background:#3b82f6; width:auto; padding:5px 15px;">Güncelle</button>
            </form>
        </div>

        <div class="main-grid">
            <div class="left-col">
                <div class="card">
                    <h3>Yeni İşlem</h3>
                    <form action="ekle.php" method="POST" enctype="multipart/form-data">
                        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:10px;">
                            <input type="text" name="islem_adi" placeholder="İşlem Çifti" required>
                            <input type="number" step="0.01" name="kazanc" id="kazanc" placeholder="Kâr ($)" oninput="checkFields('kazanc')">
                            <input type="number" step="0.01" name="zarar" id="zarar" placeholder="Zarar ($)" oninput="checkFields('zarar')">
                        </div>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;"><input type="date" name="tarih" value="<?php echo date('Y-m-d'); ?>" required><input type="file" name="resim"></div>
                        <textarea name="aciklama" placeholder="İşlem notu..."></textarea>
                        <button type="submit" style="background:#10b981">Kaydet</button>
                    </form>
                </div>
                <div class="card">
                    <h3>İşlem Geçmişi</h3>
                    <table>
                        <thead><tr><th>Tarih</th><th>Detay</th><th>P&L</th><th>SS</th><th>Sil</th></tr></thead>
                        <tbody>
                            <?php foreach($islemler as $is): ?>
                            <tr>
                                <td><?php echo date('d.m', strtotime($is['tarih'])); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($is['islem_adi']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($is['aciklama']); ?></small>
                                    
                                    <?php if(!empty($is['ai_yorumu'])): ?>
                                        <div style="background: #0f172a; border-left: 3px solid #3b82f6; padding: 8px; margin-top: 8px; font-size: 12px; border-radius: 6px; color: #cbd5e1;">
                                            🤖 <strong>AI Koç:</strong> <?php echo htmlspecialchars($is['ai_yorumu']); ?>
                                        </div>
                                    <?php else: ?>
                                        <br>
                                        <a href="ai_analiz.php?id=<?php echo $is['id']; ?>" style="color: #3b82f6; font-size: 12px; text-decoration: none; display: inline-block; margin-top: 5px;">
                                            🤖 AI Analizi Oluştur
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="<?php echo $is['kazanc'] > 0 ? 'profit' : 'loss'; ?>"><?php echo $is['kazanc'] > 0 ? '+'.$is['kazanc'] : '-'.$is['zarar']; ?>$</td>
                                <td><?php if($is['ekran_goruntusu']): ?><a href="<?php echo $is['ekran_goruntusu']; ?>" target="_blank">🖼️</a><?php endif; ?></td>
                                <td><a href="sil.php?id=<?php echo $is['id']; ?>" onclick="return confirm('Silinsin mi?')" style="text-decoration:none">🗑️</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="right-col">
                <div class="card" style="border-top: 4px solid #f59e0b;">
                    <h3 style="color:#f59e0b">💰 Kâr Çekimi</h3>
                    <form action="cekim_ekle.php" method="POST">
                        <input type="number" step="0.01" name="miktar" placeholder="Miktar ($)" required>
                        <input type="date" name="tarih" value="<?php echo date('Y-m-d'); ?>" required>
                        <button type="submit" style="background:#f59e0b">Çekimi İşle</button>
                    </form>
                    <div style="max-height: 200px; overflow-y: auto;">
                        <table style="font-size:12px;">
                            <?php foreach($cekimler as $ce): ?>
                            <tr><td><?php echo date('d.m', strtotime($ce['tarih'])); ?></td><td style="color:#f59e0b">-<?php echo $ce['miktar']; ?>$</td><td><a href="cekim_sil.php?id=<?php echo $ce['id']; ?>" style="text-decoration:none">❌</a></td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr id="notlar" style="border:0; border-top:1px solid #334155; margin:40px 0;">
        <h2 style="color:#3b82f6;">📒 Eğitim & Strateji Notlarım</h2>
        <div class="main-grid">
            <div class="left-col">
                <div class="card" style="background:#0f172a;">
                    <?php foreach($notlar as $n): ?>
                        <div class="note-card">
                            <div style="display:flex; justify-content: space-between;"><h4 style="margin:0; color:#3b82f6;"><?php echo htmlspecialchars($n['baslik']); ?></h4><a href="not_sil.php?id=<?php echo $n['id']; ?>" onclick="return confirm('Silinsin mi?')" style="text-decoration:none">🗑️</a></div>
                            <p style="font-size:14px; margin-top:10px; white-space: pre-wrap;"><?php echo htmlspecialchars($n['not_icerik']); ?></p>
                            <?php if($n['resim_yolu']): ?><img src="<?php echo $n['resim_yolu']; ?>" class="note-img"><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="right-col">
                <div class="card" style="border-top: 4px solid #3b82f6;">
                    <h3>Yeni Not Ekle</h3>
                    <form action="not_ekle.php" method="POST" enctype="multipart/form-data">
                        <input type="text" name="baslik" placeholder="Başlık" required>
                        <textarea name="not_icerik" style="height:150px;" placeholder="Notlarını yaz..."></textarea>
                        <input type="file" name="not_resim">
                        <button type="submit" style="background:#3b82f6">Notu Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>