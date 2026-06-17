<?php
session_start();
if (!isset($_SESSION['giris'])) { header("Location: login.php"); exit; }
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. İşlemin detaylarını veritabanından çekiyoruz
    $sorgu = $db->prepare("SELECT * FROM islemler WHERE id = ?");
    $sorgu->execute([$id]);
    $islem = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($islem) {
        // BURAYA OpenAI'dan aldığın 'sk-...' ile başlayan anahtarını yaz 
        $apiKey = "XXX"; 
        $apiUrl = "https://api.openai.com/v1/chat/completions";

        // Yapay zekaya trading koçu rolü veriyoruz
        $prompt = "Sen profesyonel bir trading koçusun. Sana gönderilen işlemin kâr/zarar durumunu ve trader'ın notunu incele. "
                . "Bu işleme yönelik kısa, samimi, net ve geliştirici bir analiz yap. Uzatmadan nokta atışı tavsiye ver. "
                . "Hitap ederken 'kanka' kelimesini kullanabilirsin.";

        // Gönderilecek verileri paketliyoruz
        $tradeDetails = [
            "İşlem Çifti" => $islem['islem_adi'],
            "Kazanç" => $islem['kazanc'] . "$",
            "Zarar" => $islem['zarar'] . "$",
            "Trader Notu" => $islem['aciklama'],
            "Tarih" => $islem['tarih']
        ];

        $data = [
            "model" => "gpt-4o-mini", 
            "messages" => [
                ["role" => "system", "content" => $prompt],
                ["role" => "user", "content" => "İşlem Detayları: " . json_encode($tradeDetails, JSON_UNESCAPED_UNICODE)]
            ],
            "temperature" => 0.7
        ];

        // OpenAI API'sine cURL ile bağlanıyoruz
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $apiKey
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        
        // Gelen cevabı ayıklıyoruz
        $ai_yorumu = $responseData['choices'][0]['message']['content'] ?? "Yapay zeka şu an analiz yapamadı kanka, API anahtarını veya bakiyeni kontrol et.";

        // 2. Gelen yorumu veritabanına, o işleme ait satıra kaydediyoruz
        $guncelle = $db->prepare("UPDATE islemler SET ai_yorumu = ? WHERE id = ?");
        $guncelle->execute([$ai_yorumu, $id]);
    }
}

// Her şey bitince sayfayı index.php'ye geri yönlendiriyoruz
header("Location: index.php");
exit;
?>