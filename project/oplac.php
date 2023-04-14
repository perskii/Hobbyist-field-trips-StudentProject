
<?php
    session_start();
    include "config.php";
 ?>

<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep</title>
    <link rel="stylesheet" href="css/galeriastyle.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .main_window {
            width: 500px;
            margin: 0 auto;
            margin-top: 150px;
            border: 1px solid lightgrey;
        }

        .title_span {
            font-weight: 600;
            font-size: 30px;
            margin-bottom: 50px;
        }

        .btn {
            width: 200px;
        }

    </style>
</head>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_GET['zamowienie_id'])) $zamowienie_id = $_GET['zamowienie_id'];

        if(isset($_GET['zaliczka'])) {
            $sql = "UPDATE platnosc SET zaliczka = '1' WHERE platnosc_id = '{$zamowienie_id}' ";
            mysqli_query($conn, $sql);
        } else if(isset($_GET['oplacone'])) {
            $sql = "UPDATE platnosc SET oplacone = '1' WHERE platnosc_id = '{$zamowienie_id}' ";
            mysqli_query($conn, $sql);
        }
        header('Location: profil.php');
    }
 ?>
 <body>
     <div class="main_window">
         <span class="title_span">Strona płatności <br> - Opłacanie
             <?php
             if(isset($_GET['zaliczka'])) {
                 echo 'zaliczki';
             } else if(isset($_GET['oplacone'])) {
                 echo 'całej wycieczki';
             }
             ?></span><br>

         <br><br><div>
             <form method="POST">
                 <a href="profil.php"><input class="btn btn-lg btn-warning" value="Anuluj płatność"></a>
                 <input class="btn btn-lg btn-success" type="submit" name="opacone" value="Opłać">
             </form>
         </div>
     </div>
 </body>
