<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Author.php');
include('classes/Template.php');

$author = new Author($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$author->open();
$author->getAuthor();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($author->addAuthor($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'author.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'author.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Author';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Author</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'author';

while ($div = $author->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_author'] . '</td>
    <td style="font-size: 22px;">
        <a href="author.php?id=' . $div['id_author'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="author.php?hapus=' . $div['id_author'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($author->editAuthor($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'author.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'author.php';
            </script>";
            }
        }

        $author->getAuthorById($id);
        $row = $author->getResult();

        $dataUpdate = $row['nama_author'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($author->deleteAuthor($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'author.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'author.php';
            </script>";
        }
    }
}

$author->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
