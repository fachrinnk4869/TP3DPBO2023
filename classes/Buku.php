<?php

class Buku extends DB
{
    function getBukuJoin()
    {
        $query = "SELECT * FROM buku JOIN genre ON buku.id_genre=genre.id_genre JOIN author ON buku.id_author=author.id_author ORDER BY buku.id_buku";

        return $this->execute($query);
    }

    function getBuku()
    {
        $query = "SELECT * FROM buku";
        return $this->execute($query);
    }

    function getBukuById($id)
    {
        $query = "SELECT * FROM buku JOIN genre ON buku.id_genre=genre.id_genre JOIN author ON buku.id_author=author.id_author WHERE id_buku=$id";
        return $this->execute($query);
    }

    function searchBuku($keyword)
    {
        $query = "SELECT * FROM buku JOIN genre ON buku.id_genre=genre.id_genre JOIN author ON buku.id_author=author.id_author WHERE nama_buku LIKE '%".$keyword."%' OR nama_genre LIKE '%".$keyword."%' OR nama_author LIKE '%".$keyword."%'";
        return $this->execute($query);
    }

    function addBuku($data, $file)
    {
        $tmp_file = $file['file_image']['tmp_name'];
        $buku_foto = $file['file_image']['name'];
        
        $dir = "assets/images/$buku_foto";
        move_uploaded_file($tmp_file, $dir);

        // $buku_nim = $data['nim'];
        $buku_nama = $data['nama'];
        // $buku_semester = $data['semester'];
        $id_genre = $data['genre'];
        $id_author = $data['author'];

        $query = "INSERT INTO buku VALUES('','$buku_nama', '$buku_foto' , '$id_author', '$id_genre')";

        return $this->executeAffected($query);
    }

    function editBuku($id, $data, $file)
    {
        $tmp_file = $file['file_image']['tmp_name'];
        $buku_foto = $file['file_image']['name'];
        
        $dir = "assets/images/$buku_foto";
        move_uploaded_file($tmp_file, $dir);

        // $buku_nim = $data['nim'];
        $buku_nama = $data['nama'];
        // $buku_semester = $data['semester'];
        $id_genre = $data['genre'];
        $id_author = $data['author'];

        $query = "UPDATE buku SET 
            nama_buku = '$buku_nama',
            foto_buku = '$buku_foto',
            id_author = '$id_author',
            id_genre = '$id_genre'
            WHERE id_buku = $id";

        return $this->executeAffected($query);
    }

    function deleteBuku($id)
    {
        $query = "DELETE FROM buku WHERE id_buku = $id";
        return $this->executeAffected($query);
    }
}
