<?php

class Genre extends DB
{
    function getGenre()
    {
        $query = "SELECT * FROM genre";
        return $this->execute($query);
    }

    function getGenreById($id)
    {
        $query = "SELECT * FROM genre WHERE id_genre=$id";
        return $this->execute($query);
    }

    function addGenre($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO genre VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function editGenre($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE genre SET
            nama_genre = '$nama'
            WHERE id_genre = $id";
        return $this->executeAffected($query);
    }

    function deleteGenre($id)
    {
        $query = "DELETE FROM genre WHERE id_genre=$id";
        return $this->executeAffected($query);
    }
}
