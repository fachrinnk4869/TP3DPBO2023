<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Author.php');
include('classes/Buku.php');
include('classes/Template.php');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

$data = nulL;

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    if($id > 0){
        if($buku->deleteBuku($id) > 0){
            // confrim box script sebelum delete data
            // echo"<script>
            //     var konfirmasi = confirm('Apakah anda yakin ingin menghapus data ini?');
            //     if(konfirmasi === true){
            //         document.location.href = 'index.php';
            //     } else {
            //         document.location.href = '?id=".$id."';
            //     }";
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";

        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = '?id=".$id."';
            </script>";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $buku->getBukuById($id);
        $row = $buku->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['nama_buku'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_buku'] . '" class="img-thumbnail" alt="' . $row['foto_buku'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                
                                <tr>
                                    <td>Genre</td>
                                    <td>:</td>
                                    <td>' . $row['nama_genre'] . '</td>
                                </tr>
                                <tr>
                                    <td>Author</td>
                                    <td>:</td>
                                    <td>' . $row['nama_author'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="tambah.php?id='.$row['id_buku'].'"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="?hapus='.$row['id_buku'].'"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

$buku->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_BUKU', $data);
$detail->write();
