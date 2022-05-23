<?php
include_once 'User.php';
class Student extends User
{
    public $requests;

    public function set_Requests($id)
    {
        $strConnection = 'mysql:host=localhost;dbname=school_library';
        $pdo = new PDO($strConnection, 'root', 'root');
        $prep = $pdo->query('SELECT * from requests WHERE student_id = ?');
        $prep->bindValue(1, $this->id);
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
