-- Mevcut tabloları temizleyelim (Dikkat: İçindeki veriler silinir)
DROP TABLE IF EXISTS egitim_notlari;
DROP TABLE IF EXISTS cekimler;
DROP TABLE IF EXISTS islemler;
DROP TABLE IF EXISTS ayarlar;

-- 1. Ayarlar Tablosu (Cüzdan ve Hedef)
CREATE TABLE ayarlar (
    id INT PRIMARY KEY,
    toplam_cuzdan DECIMAL(10,2) NOT NULL,
    birikim_hedefi DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. İşlemler Tablosu (Trading Kayıtları - Yapay Zeka Alanı Eklendi)
CREATE TABLE islemler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    islem_adi VARCHAR(100) NOT NULL,
    aciklama TEXT,
    kazanc DECIMAL(10,2) DEFAULT 0.00,
    zarar DECIMAL(10,2) DEFAULT 0.00,
    ekran_goruntusu VARCHAR(255),
    ai_yorumu TEXT NULL,
    tarih DATE NOT NULL,
    eklenme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Kâr Çekimleri Tablosu
CREATE TABLE cekimler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    miktar DECIMAL(10,2) NOT NULL,
    tarih DATE NOT NULL,
    eklenme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Eğitim & Strateji Notları Tablosu
CREATE TABLE egitim_notlari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    baslik VARCHAR(255) NOT NULL,
    not_icerik TEXT,
    resim_yolu VARCHAR(255),
    eklenme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Başlangıç Verilerini Ekleme
INSERT INTO ayarlar (id, toplam_cuzdan, birikim_hedefi) 
VALUES (1, 1000.00, 5000.00);