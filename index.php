<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Author.php');
include('classes/Buku.php');
include('classes/Template.php');

// buat instance buku
$listBuku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listBuku->open();
// tampilkan data buku
$listBuku->getBukuJoin();

// cari buku
if (isset($_POST['btn-cari'])) {
    // methode mencari data buku
    $listBuku->searchBuku($_POST['cari']);
} else {
    // method menampilkan data buku
    $listBuku->getBukuJoin();
}

$data = null;

// ambil data buku
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listBuku->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 buku-thumbnail">
        <a href="detail.php?id=' . $row['id_buku'] . '">
        
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_buku'] . '" class="card-img-top" alt="' . $row['foto_buku'] . '">
            </div>
            <div class="card-body">
                <p class="card-text buku-nama my-0">' . $row['nama_buku'] . '</p>
                <p class="card-text genre-nama">' . $row['nama_genre'] . '</p>
                <p class="card-text author-nama my-0">' . $row['nama_author'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listBuku->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_BUKU', $data);
$home->write();
