<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Author.php');
include('classes/Buku.php');
include('classes/Template.php');

$view = new Template('templates/skintambah.html');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if($id > 0){
        $buku->getBukuById($id);
        $data = $buku->getResult();
        $addOrEdit = 'Edit';
    }
    if (isset($_POST['submit'])) {
        if ($buku->editBuku($id, $_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'tambah.php';
            </script>";
        }
    }
} else {
    $addOrEdit = 'Tambah';
    if (isset($_POST['submit'])) {
        if ($buku->addBuku($_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'tambah.php';
            </script>";
        }
    }
    $data['id_author'] = 0;
    $data['id_genre'] = 0;
    $data['nama_buku'] = "";
}


/*connect ke database tabel genre*/
$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();
$genre->getGenre();
$optionsGenre = null;

// Looping untuk menampilkan data dalam tabel HTML
while ($row = $genre->getResult()) {
    $optionsGenre .= "<option value=". $row['id_genre']. " ". (($row['id_genre'] == $data['id_genre']) ? "selected" : " " ). ">" . $row['nama_genre'] . "</option>";
}
$genre->close();

/*connect ke database tabel author*/
$author = new Author($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$author->open();
$author->getAuthor();
$optionsAuthor = null;

// Looping untuk menampilkan data dalam tabel HTML
// var_dump($data);
while ($row = $author->getResult()) {
    // var_dump($row['id_author']);
    // var_dump($data['id_author']);
    $optionsAuthor .= "<option value=". $row['id_author']. " ". (($row['id_author'] == $data['id_author']) ? "selected" : " " ). ">" . $row['nama_author'] . "</option>";
}


$author->close();

$buku->close();

$view->replace('OPTIONS_GENRE', $optionsGenre);
$view->replace('OPTIONS_AUTHOR', $optionsAuthor);
$view->replace('OPTIONS_ADDEDIT', $addOrEdit . ' Data');
$view->replace('SELECT_BUKU', $data['nama_buku']);
// $view->replace('SELECT_AUTHOR', $data['id_author']);
$view->write();
