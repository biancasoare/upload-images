<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Galerie foto</title>
    </head>
    <body>
    <?php
        require_once("mysql_connect.php");
        $sql = "SELECT COUNT(*) FROM imagini";
        $res = mysqli_query($link,$sql);

        $row = mysqli_fetch_array($res);

        $n = ceil($row[0]/2);

        if ($row[0] > 0) {
            $sql = "SELECT * FROM imagini";
            $res = mysqli_query($link, $sql);

            echo "<table border='1'>\n";
            for ($i = 0; $i < $n; $i++) {
               echo "<tr>\n";
               for ($j = 0; $j < 2; $j++) {
                    if ($img = mysqli_fetch_array($res)) {
                        echo "<td><img src='".$img['file']."' alt='".$img['name']."' width=20% /></td>\n";
                    } else {
                         echo "<td></td>\n";
                    }
                }
               echo "</tr>\n";
            }
            echo "</table>";
        }
    ?>
    </body>
</html>

