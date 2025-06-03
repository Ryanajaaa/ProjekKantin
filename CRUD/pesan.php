<?php
include 'koneksi.php';

$pesanan = [];
$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST['jumlah'] as $id => $jumlah) {
    $jumlah = (int)$jumlah;
    if ($jumlah > 0) {
      $m = $conn->query("SELECT * FROM makanan WHERE id = $id")->fetch_assoc();
      if ($m && $m['stok'] >= $jumlah) {
        $subtotal = $jumlah * $m['harga'];
        $total += $subtotal;
        $pesanan[] = [
          'id' => $id,
          'nama' => $m['nama'],
          'kantin' => $m['kantin'],
          'harga' => $m['harga'],
          'jumlah' => $jumlah,
          'subtotal' => $subtotal
        ];
        // Update stok
        $conn->query("UPDATE makanan SET stok = stok - $jumlah WHERE id = $id");
      }
    }
  }
}

$makanan = $conn->query("SELECT * FROM makanan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pemesanan Makanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">Form Pemesanan</h2>

  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <h4>Detail Pesanan</h4>
    <ul class="list-group mb-3">
      <?php foreach ($pesanan as $item): ?>
        <li class="list-group-item">
          <?php echo "{$item['nama']} dari {$item['kantin']} - {$item['jumlah']} x Rp" . number_format($item['harga'], 0, ',', '.') . " = Rp" . number_format($item['subtotal'], 0, ',', '.'); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <h5>Total Harga: <strong>Rp<?php echo number_format($total, 0, ',', '.'); ?></strong></h5>
    <div class="mt-4 text-center">
      <p>Scan QR berikut untuk menyelesaikan pembayaran:</p>
      <img src="dummy.png" alt="QR Dummy" class="img-thumbnail" style="max-width: 200px;">
    </div>
    <a href="index.php?status=success" class="btn btn-primary mt-4">Kembali ke Beranda</a>
  
  <?php else: ?>
    <form method="post">
      <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php while ($row = $makanan->fetch_assoc()): ?>
          <div class="col">
            <div class="card h-100">
              <img src="gambar/<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="<?php echo $row['nama']; ?>">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                <p class="card-text">
                  Kantin: <?php echo $row['kantin']; ?><br>
                  Harga: Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?><br>
                  Stok: <?php echo $row['stok']; ?>
                </p>
                <input type="number" name="jumlah[<?php echo $row['id']; ?>]" class="form-control" placeholder="Jumlah" min="0" max="<?php echo $row['stok']; ?>">
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-success btn-lg">Proses Pesanan</button>
      </div>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
