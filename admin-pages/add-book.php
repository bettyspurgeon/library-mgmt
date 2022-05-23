<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Document</title>
</head>

<body>

    <?php
    //get enums for status and age_range: 
    $conn = mysqli_connect('localhost', 'root', 'root', 'school_library');
    $status_enum_query = 'SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "books" AND COLUMN_NAME = "status"';
    $enum_result = mysqli_query($conn, $status_enum_query);
    $status_row = mysqli_fetch_all($enum_result, MYSQLI_ASSOC);
    foreach ($status_row as $enum) {
        $status = substr($enum["COLUMN_TYPE"], 5, -2);
        $status = trim($status, "'");
        $status_arr = explode("','", $status);
    }
    $age_enum_query =
        'SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "books" AND COLUMN_NAME = "age_range"';

    $age_result = mysqli_query($conn, $age_enum_query);
    $age_row = mysqli_fetch_all($age_result, MYSQLI_ASSOC);
    foreach ($age_row as $enum) {
        $age = substr($enum["COLUMN_TYPE"], 5, -2);
        $age = trim($age, "'");
        $age_arr = explode("','", $age);
    }



    //Make sure I clicked on the submit btn
    if (isset($_POST['submit'])) {
        $title = '';
        $author = '';
        $status = '';
        $age_range = '';
        $errors = array();


        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $status = $_POST['status'];
        $age_range = $_POST['age-range'];

        if (empty($title)) {
            $errors['title'] = 'Title is necessary';
        }
        if (empty($author)) {
            $errors['author'] = 'author is necessary';
        }
        if (empty($status)) {
            $errors['status'] = 'status is necessary';
        }
        if (empty($age_range)) {
            $errors['age_range'] = 'age range is necessary';
        }
        if (count($errors) == 0) {
            $insert_query = "INSERT INTO books (title, author, status, age_range) VALUES ('$title', '$author', '$status', '$age_range')";

            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                echo "<p style='color:green;'>Successfully inserted into the database! :) .</p>";
            } else {
                echo "<p style='color:red;'>Attempt to insert was unsuccessful :( .</p>";
            }
        }
    }
    ?>

    <div class="add-book-form">
        <h1>Add a Book</h1>
        <form method="POST">
            <input type="text" name="title" placeholder="Title">
            <input type="text" name="author" placeholder="Author">
            <select name="status" id="">
                <option value="none" selected disabled hidden>Select status</option>
                <?php foreach ($status_arr as $value) : ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                <?php endforeach ?>
            </select>
            <select name="age-range" id="">
                <option value="none" selected disabled hidden>Select age range</option>
                <?php foreach ($age_arr as $value) : ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                <?php endforeach ?>
            </select>
            <input type="submit" name="submit" value="Add Book">
        </form>
    </div>
</body>

</html>