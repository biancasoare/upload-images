<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 15/05/2018
 * Time: 16:30
 */

if (isset($_POST['add'])) {
    require_once("mysql_connect.php");
    $target = "images/";
    $target = $target . basename($_FILES['fisier']['name']);
    $nume = htmlspecialchars($_POST['titlu']);
    $ok = 1;
    $fisier_size = $_FILES['fisier']['size'];
    $fisier_type = $_FILES['fisier']['type'];

    //conditie pentru dimensiune fisier
    if ($fisier_size > 10000000) {
        echo "Fisierul ete prea mare! <br/>";
        $ok = 0;
    }

    //conditie pentru tip fisier
    if (($fisier_type == "text/php") || ($fisier_type == "application/octet-stream")) {
        echo "Fisierele PHP nu sunt acceptate<br/>";
        $ok = 0;
    }

    //daca sunt indeplinite conditiile, salveaza fisierul
    if ($ok==0) {
        echo "Fisierul nu a fost salvat";
    } else {
        if (move_uploaded_file($_FILES['fisier']['tmp_name'],$target)) {
            echo "Fisierul " . basename($_FILES['fisier']['name']) . " a fost salvat";
            $sql = "INSERT INTO imagini VALUES('', '$target', '$nume')";
            $res = mysqli_query($link, $sql);
        } else {
            echo "Fisierul nu a putut fi salvat";
        }
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Adauga imagine</title>
    </head>
    <body>
        <h1>Adaugati imagine</h1>
        <form method="post" action="add_image.php" enctype="multipart/form-data">
            <label for="titlu">Denumire:</label>
            <input id="titlu" type="text" name="titlu"/> <br/> <br/>
            <label for="fisier">Fisier:</label>
            <input id="fisier" type="file" name="fisier"/> <br/> <br/>

            <input type="hidden" name="add" value="TRUE"/>
            <input type="submit" value="Salveaza"/>
        </form>
    </body>
</html>
