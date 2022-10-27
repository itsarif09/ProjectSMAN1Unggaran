<?php
session_start();

if ( !isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require 'functions.php';


$jumlahDataPerHalaman = 40;
$jumlahData = count(query("SELECT * FROM siswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif  = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;


$siswa = query("SELECT * from siswa LIMIT $awalData, $jumlahDataPerHalaman");

// ketika salah satu tombol di klik dan cari ditekan
if (isset($_POST["tipe"])) {
    if ($_POST["tipe"] == "nis") {
        $keyword = $_POST["keyword"];
        $query = "SELECT * FROM siswa WHERE nis LIKE '%$keyword%'";
        $siswa = query($query);
    }elseif ($_POST["tipe"] == "nama") {
        $keyword = $_POST["keyword"];
        $query = "SELECT * FROM siswa WHERE nama LIKE '%$keyword%'";
        $siswa = query($query);
    }elseif ($_POST["tipe"] == "alumni") {
        $keyword = $_POST["keyword"];
        $query = "SELECT * FROM siswa WHERE alumni LIKE '%$keyword%'";
        $siswa = query($query);
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Halaman Admin</title>
    <link rel="shortcut icon" href="img/icons.png" type = "image/x-icon"/>
    <link rel="stylesheet" href="css/stylesiswa.css">
</head>
<body>

    <table class="table1" border="1" cellpading="10" cellspacing="0">

   
        <a class="logout" href="logout.php" >Logout</a> 
        <a class="cetak" href="cetak.php" target="_blank">Cetak</a>

    <h1>Buku Induk Siswa</h1>

    <a class="tambah" href="input.php">Tambah data siswa</a>
    
    <br><br>
    <div class="form-check">
    <form action="" method="post">
         <input name="keyword" type="text" placeholder="Keyword" size="30" autofocus autocomplete="off" />
        <label class="form-check-label">
        <div class="form-check-input">
         <input name="tipe" type="radio" value="nis" />nis 
         <input name="tipe" type="radio" value="nama" />nama
         <input name="tipe" type="radio" value="alumni" />alumni
        </div>
        </label>
         <button type="submit" name="cari" > Cari </button>
   </form>
   </div>
   <br><br>

   
   
   <br>
    
            <tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Anak ke</th>
                <th>Status dalam Keluarga</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Diterima di sekolah ini kelas</th>
                <th>Sekolah Asal</th>
                <th>Ijazah</th>
                <th>SKHUN</th>
                <th>Orang Tua</th>
                <th>Alamat Orang Tua</th>
                <th>Pekerjaan Orang Tua</th>
                <th>Nama Wali</th>
                <th>Alamat Wali</th>
                <th>Telepon Wali</th>
                <th>Pekerjaan Wali</th>
                <th>Mutasi</th>
                <th>Tahun Masuk</th>
                <th>Alumni</th>
            </tr>


        <?php $i = 1; ?>
        <?php foreach ($siswa as $row) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td>
                    <a class="ubah" href="ubah.php?id=<?= $row["id"]; ?>">ubah</a>
                    <br></br>
                    <a class="hapus" href="hapus.php?id=<?= $row["id"]; ?>" 
                    onclick="return confirm('Yakin ingin menghapus?')">hapus</a>
                </td>
                <td><img src="img/<?= $row["foto"]; ?>" width="50"></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["nis"]; ?></td>
                <td><?= $row["nisn"]; ?></td>
                <td><?= $row["tempat_lahir"]; ?></td>
                <td><?= $row["tanggal_lahir"]; ?></td>
                <td><?= $row["gender"]; ?></td>
                <td><?= $row["agama"]; ?></td>
                <td><?= $row["anak_ke"]; ?></td>
                <td><?= $row["status_dalam_keluarga"]; ?></td>
                <td><?= $row["alamat"]; ?></td>
                <td><?= $row["telepon"]; ?></td>
                <td><?= $row["diterima_di_sekolah_ini_kelas"]; ?></td>
                <td><?= $row["sekolah_asal"]; ?></td>
                <td><?= $row["ijazah"]; ?></td>
                <td><?= $row["skhun"]; ?></td>
                <td><?= $row["ortu"]; ?></td>
                <td><?= $row["alamat_ortu"]; ?></td>
                <td><?= $row["pekerjaan_ortu"]; ?></td>
                <td><?= $row["nama_wali"]; ?></td>
                <td><?= $row["alamat_wali"]; ?></td>
                <td><?= $row["telepon_wali"]; ?></td>
                <td><?= $row["pekerjaan_wali"]; ?></td>
                <td><?= $row["mutasi"]; ?></td>
                <td><?= $row["tahun_masuk"]; ?></td>
                <td><?= $row["alumni"]; ?></td>

            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
        </body>
    

    </table>
    
    <?php if($halamanAktif > 1) : ?>
    <a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
   <?php endif; ?>
   
   <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
    <?php if($i == $halamanAktif) : ?>
        <a href="?halaman=<?= $i; ?>"style="font-weight: bold;"><?= $i; ?></a>
    <?php else : ?>
        <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
    <?php endif ; ?> 
   <?php endfor; ?>

   <?php if($halamanAktif < $jumlahHalaman) : ?>
    <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
   <?php endif; ?>   
    
</body>

</html>