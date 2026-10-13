<?php
// ==========================================
// 1. FUNCTION BUATAN SENDIRI
// ==========================================
function hitungTotalBayar($harga, $jumlah, $persenDiskon) {
    $totalKotor = $harga * $jumlah;
    $potongan   = $totalKotor * ($persenDiskon / 100);
    return $totalKotor - $potongan;
}

// Data Pilihan Kategori & Metode Pembayaran (Array untuk Perulangan)
$kategori_list = ["Sepatu", "Celana"];
$metode_list   = ["Transfer Bank", "E-Wallet", "Kartu Kredit", "Tunai / COD"];

// Variable untuk menyimpan status proses formulir
$data_tersimpan = false;
$nama_pembeli = $nama_barang = $kategori = $metode_bayar = "";
$jumlah_beli = 0;
$harga_satuan = 0.0;
$persen_diskon = 0;
$member_aktif = false;
$total_bayar = 0.0;

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ==========================================
    // 2. VARIABEL DENGAN TIPE DATA BERBEDA
    // ==========================================
    $nama_pembeli  = (string) $_POST['nama_pembeli'];                 // String
    $nama_barang   = (string) $_POST['nama_barang'];                  // String
    $kategori      = (string) $_POST['kategori'];                     // String
    $metode_bayar  = (string) $_POST['metode_bayar'];                 // String
    $jumlah_beli   = (int) $_POST['jumlah_beli'];                     // Integer
    $harga_satuan  = (float) $_POST['harga_satuan'];                  // Float
    $member_aktif  = isset($_POST['member_aktif']);                   // Boolean

    // Total belanja sebelum diskon
    $total_belanja = $harga_satuan * $jumlah_beli;

    // ==========================================
    // 3. PERCABANGAN (IF-ELSEIF-ELSE)
    // ==========================================
    // Menentukan persentase diskon berdasarkan total belanja
    if ($total_belanja >= 500000) {
        $persen_diskon = 20; // Diskon 20%
    } elseif ($total_belanja >= 250000) {
        $persen_diskon = 15; // Diskon 15%
    } elseif ($total_belanja >= 100000) {
        $persen_diskon = 10; // Diskon 10%
    } else {
        $persen_diskon = 0;  // Tidak ada diskon
    }

    // Tambahan diskon 5% khusus Member Aktif
    if ($member_aktif) {
        $persen_diskon += 5;
    }

    // Memanggil Function Buatan Sendiri
    $total_bayar = hitungTotalBayar($harga_satuan, $jumlah_beli, $persen_diskon);

    $data_tersimpan = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskon XSECONDWALL</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 520px;
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 25px;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #4a5568;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #667eea;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #4a5568;
            cursor: pointer;
        }

        .row-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #e056fd, #be2edd);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: opacity 0.2s ease;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .result-box {
            margin-top: 25px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
        }

        .result-box h3 {
            margin-bottom: 12px;
            color: #2b6cb0;
            border-bottom: 2px solid #ebf8ff;
            padding-bottom: 5px;
        }

        .result-item {
            font-size: 14px;
            margin-bottom: 6px;
            color: #2d3748;
        }

        .badge-diskon {
            display: inline-block;
            padding: 3px 8px;
            background-color: #e53e3e;
            color: white;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>DISKON BELANJA DI XSECONDWALL</h2>

        <form action="" method="POST">
            <!-- Nama Pembeli -->
            <div class="form-group">
                <label for="nama_pembeli">Nama Pembeli</label>
                <input type="text" id="nama_pembeli" name="nama_pembeli" placeholder="Masukkan nama pembeli" required>
            </div>

            <!-- Nama Barang -->
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
            </div>

            <!-- Kategori Barang (Hanya Sepatu & Celana) -->
            <div class="form-group">
                <label for="kategori">Kategori Barang</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_list as $kat) : ?>
                        <option value="<?= $kat; ?>"><?= $kat; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Harga & Jumlah Beli -->
            <div class="form-group">
                <div class="row-grid">
                    <div>
                        <label for="harga_satuan">Harga Satuan (Rp)</label>
                        <input type="number" id="harga_satuan" name="harga_satuan" placeholder="Contoh: 50000" min="0" required>
                    </div>
                    <div>
                        <label for="jumlah_beli">Jumlah Beli</label>
                        <input type="number" id="jumlah_beli" name="jumlah_beli" placeholder="Contoh: 2" min="1" required>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran (Perulangan foreach) -->
            <div class="form-group">
                <label for="metode_bayar">Metode Pembayaran</label>
                <select id="metode_bayar" name="metode_bayar" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <?php foreach ($metode_list as $metode) : ?>
                        <option value="<?= $metode; ?>"><?= $metode; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Checkbox Member -->
            <div class="form-group">
                <label class="checkbox-item">
                    <input type="checkbox" name="member_aktif" value="1">
                    Memiliki Kartu Member? (Tambahan Diskon 5%)
                </label>
            </div>

            <button type="submit" class="btn-submit">Hitung Total Belanja</button>
        </form>

        <!-- HASIL SETELAH SUBMIT -->
        <?php if ($data_tersimpan) : ?>
            <div class="result-box">
                <h3>Rincian Pembayaran</h3>
                <div class="result-item"><strong>Nama Pembeli:</strong> <?= htmlspecialchars($nama_pembeli); ?></div>
                <div class="result-item"><strong>Barang / Kategori:</strong> <?= htmlspecialchars($nama_barang); ?> (<?= htmlspecialchars($kategori); ?>)</div>
                <div class="result-item"><strong>Status Member:</strong> <?= $member_aktif ? "Ya (Member)" : "Tidak"; ?></div>
                <div class="result-item"><strong>Metode Bayar:</strong> <?= htmlspecialchars($metode_bayar); ?></div>
                <div class="result-item"><strong>Total Kotor:</strong> Rp <?= number_format($harga_satuan * $jumlah_beli, 0, ',', '.'); ?></div>
                <div class="result-item">
                    <strong>Diskon Didapat:</strong> 
                    <span class="badge-diskon"><?= $persen_diskon; ?>%</span>
                </div>
                <div class="result-item" style="font-size: 16px; margin-top: 10px; color: #2b6cb0;">
                    <strong>Total Harus Dibayar:</strong> <br>
                    <span style="font-size: 20px; font-weight: bold; color: #2d3748;">
                        Rp <?= number_format($total_bayar, 0, ',', '.'); ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>