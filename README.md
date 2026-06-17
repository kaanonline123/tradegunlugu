# 📊 Trading Journal & Notes Pro (AI Integrated)

## 👤 Öğrenci Bilgileri
* **Adı Soyadı:** Kaan Kahvecioğlu
* **Üniversite / Bölüm:** İstanbul Topkapı Üniversitesi - Bilgisayar Programcılığı (Uzaktan Öğretim) / 2
* **Öğrenci Numarası:** 24010509019

---

# 🚀 **Proje Demosu**

* Projeyi incelemek ve önizlemek için aşağıdaki web sitesini ziyaret edebilirsiniz.

* 🌐 **Demo Adresi:** https://kaank.xyz/
* 🔑 **Giriş Şifresi:** 123

* 📱💻 Proje, hem mobil cihazlardan hem de masaüstü bilgisayarlardan kolay erişim sağlanabilmesi için web tabanlı olarak geliştirilmiştir.

---

# 📂 **GitHub Bağlantısı**

* Projenin kaynak kodlarına ve geliştirme sürecine aşağıdaki GitHub deposu üzerinden erişebilirsiniz.

* 🔗 **GitHub Adresi:** https://github.com/kaanonline123/tradegunlugu

* 💻 Projeye ait tüm dosyalar ve geliştirme detayları bu depo içerisinde yer almaktadır.

---

## 🎯 Projenin Amacı ve Kısa Açıklaması
Bu proje; finansal piyasalarda işlem yapan trader'ların operasyonel süreçlerini disipline etmek, duygusal ve stratejik analizlerini geriye dönük (backtest) takip edebilmek amacıyla geliştirilmiş **Full-Stack bir Trading Günlüğü ve Eğitim Yönetim Sistemi** web uygulamasıdır. 

Uygulama, standart bir kayıt defteri olmanın ötesinde, **OpenAI API (GPT-4o-mini)** entegrasyonu sayesinde yapay zeka desteğine sahiptir. Kullanıcılar ekledikleri işlemlerin detaylarını (parite, kâr/zarar ve işlem notu) tek tıkla yapay zekaya analiz ettirerek; risk yönetimi, psikoloji ve strateji hatalarına yönelik kişiselleştirilmiş "Trading Koçluğu" geri bildirimleri alabilmektedir.

---

## 🛠️ Kullanılan Teknolojiler / Kütüphaneler
* **Backend:** PHP 8.x (Nesne Yönelimli PDO Veritabanı Sürücüsü, Prepared Statements)
* **Veritabanı:** MySQL
* **Frontend:** HTML5, CSS3 (Modern Dark Tema, Inter Font Ailesi, Grid & Flexbox Mimarisi), JavaScript
* **API ve Entegrasyon:** cURL (OpenAI API - GPT-4o-mini Entegrasyonu)

---

## 📁 Proje Klasör Yapısı
```text
├── index.php             # Ana panel, dashboard ve işlemlerin listelendiği merkez dosya
├── login.php             # Kullanıcı kimlik doğrulama (Giriş) sayfası
├── logout.php            # Oturumu sonlandırma ve güvenli çıkış dosyası
├── db.php                # PDO veritabanı bağlantı konfigürasyonu
├── ekle.php              # Yeni işlem kayıt ve dosya yükleme (upload) kontrol mekanizması
├── sil.php               # İşlem silme ve ilişkili görseli sunucudan kaldırma dosyası
├── ai_analiz.php         # OpenAI API entegrasyonu ve cURL istek yönetimi dosyası
├── ayarlar_guncelle.php  # Portföy başlangıç bakiyesi ve hedef güncellenmesi
├── cekim_ekle.php        # Hesap bakiyesinden kâr çekim kaydı ekleme
├── cekim_sil.php         # Kâr çekim kaydı silme işlemi
├── not_ekle.php          # Akademi bölümüne yeni strateji notu ve görseli ekleme
├── not_sil.php           # Strateji notu ve ilgili görseli temizleme dosyası
├── data.sql              # Veritabanı şeması ve başlangıç konfigürasyon verileri
└── uploads/              # Yüklenen ekran görüntülerinin saklandığı dizin
...
```

---

## 🔧 Kurulum Adımları
1. **Lokal Sunucu Hazırlığı:** XAMPP, WampServer veya benzeri bir yerel sunucu yazılımını bilgisayarınızda çalıştırın.
2. **Veritabanı Kurulumu:**
   * Tarayıcınızdan `localhost/phpmyadmin` paneline gidin.
   * `trading_db` adında yeni bir veritabanı oluşturun (Dil kodlamasını `utf8mb4_general_ci` seçin).
   * Proje klasöründe yer alan `data.sql` dosyasını bu veritabanına **İçe Aktar (Import)** seçeneğiyle yükleyip çalıştırın.
3. **Dosyaların Taşınması:** Projenin tüm kod dosyalarını yerel sunucunuzun kök dizinine (XAMPP kullanıyorsanız `htdocs` klasörünün, Wamp kullanıyorsanız `www` klasörünün içine) bir klasör halinde taşıyın.
4. **Yapay Zeka API Yapılandırması:** `ai_analiz.php` dosyasını bir kod editörüyle açarak `$apiKey = "BURAYA_OPENAI_API_KEYINIZI_YAZIN";` satırındaki tırnak işaretlerinin içine OpenAI platformundan aldığınız API anahtarınızı (Secret Key) ekleyin ve dosyayı kaydedin.

---

## 🚀 Çalıştırma / Kullanım Talimatları
1. Tarayıcınızı açın ve adres çubuğuna `https://kaank.xyz/` yazarak demoya gidin veya yerel sunucunuzda `http://localhost/[proje_klasor_adi]/login.php` üzerinden projeyi açın.
2. **Giriş Şifresi:** Giriş ekranındaki şifre alanına `123` (veya lokalde `123456`) yazarak sisteme giriş yapın.
3. **İşlem Kaydetme:** Ana sayfada yer alan "Yeni İşlem" formunu kullanarak işlem çiftini, kâr veya zarar miktarını, tarihi, işlem notunu girin. Varsa grafiğe ait ekran görüntüsünü de seçerek "Kaydet" butonuna basın.
4. **Yapay Zeka Analizini Tetikleme:** İşlem Geçmişi tablosunda listelenen kaydınızın hemen altındaki **"🤖 AI Analizi Oluştur"** linkine tıklayın. Sistem arka planda API isteğini tamamlayıp sayfayı yenileyecek ve yapay zekanın kalıcı analiz yorumunu ekrana yansıtacaktır.
5. **Kâr Çekimi ve Not Sistemi:** Sağ panelden hesaptan yapılan kâr çekimlerini yönetebilir, alt panelden ise grafik destekli teknik analiz/eğitim notlarınızı ekleyip silebilirsiniz.

---

## 🖼️ Ekran Görüntüleri
* **Ekran Görüntüsü 1: ** https://i.hizliresim.com/6pdx3m7.png
* **Ekran Görüntüsü 2: ** https://i.hizliresim.com/ow431jz.png
* **Ekran Görüntüsü 3: ** https://i.hizliresim.com/frzeil4.png

---

## 📚 Kaynakça veya Yararlanılan Bağlantılar
* [PHP: PDO - Manual](https://www.php.net/manual/tr/book.pdo.php)
* [OpenAI API Reference Documentation](https://platform.openai.com/docs/api-reference)
* [MDN Web Docs - HTML, CSS and JavaScript](https://developer.mozilla.org/)
* [W3Schools PHP cURL Sürücüsü](https://www.w3schools.com/php/php_ref_curl.asp)
