<?php

class Author extends DB
{
    function getAuthor()
    {
        $query = "SELECT * FROM author";
        return $this->execute($query);
    }

    function getAuthorById($id)
    {
        $query = "SELECT * FROM author WHERE id_author=$id";
        return $this->execute($query);
    }

    function addAuthor($data)
    {
        $nama_author = $data['nama'];

        $query = "INSERT INTO author VALUES('','$nama_author')";

        return $this->executeAffected($query);
    }

    function editAuthor($id, $data)
    {
        $nama_autor = $data['nama'];

        $query = "UPDATE author SET
            nama_author = '$nama_autor'
            WHERE id_author = $id";

        return $this->executeAffected($query);
    }

    function deleteAuthor($id)
    {
        $query = "DELETE FROM author WHERE id_author=$id";
        return $this->executeAffected($query);
    }
}
