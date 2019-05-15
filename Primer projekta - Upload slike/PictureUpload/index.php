<!--Cilj je da korisnik moze da izvrsi upload slike i da mu se nakon upload-a prikazu informacije o slici i sama slika-->
<!--Moguca poboljsanja: proveriti maksimalnu velicinu slike, proveriti da li je fajl slika...-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Picture upload</title>
    </head>
    <body>
        <!--Forma za upload slike od strane korisnika-->
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="user_file">
            <input type="submit" name = "submit">
            <br />
        </form>
        <!--Kada korisnik pritisne dugme submit, slika se upload-uje, popunjava se $_POST["submit"] i opet ucitava stranica-->
        <?php
            //Kada se opet ucita stranica, popunjeno je $_POST["submit"] i $_FILES['user_file']
            //$_FILES['xxx'] mora da odgovara <input type="file" name="xxx"> iz forme
            //Potrebno je jos proveriti da li je slika upload-ovana
            //https://php.net/is_uploaded_file
            if (isset($_POST["submit"]) && is_uploaded_file($_FILES['user_file']['tmp_name'])) {
                echo 'file info: <br />'; 
                //U nastavku se ispisuju informacije o slici
                //Obratite paznju o tome kako se pristupa informacijama o slici
                //$_FILES['user_file']['name'] je naziv slike na racunaru korisnika
                echo $_FILES['user_file']['name'] .'<br />';
                //Slika se smesta u folderu wamp64\tmp u vidu .tmp fajla na serveru
                //U $_FILES['user_file']['tmp_name'] se nalazi ime tog .tmp fajla
                echo ($tmp_image_path = $_FILES['user_file']['tmp_name']) .'<br />';
                echo $_FILES['user_file']['size'] .'<br />';
                echo $_FILES['user_file']['type'] .'<br />';
                echo $_FILES['user_file']['error'] .'<br />';
                //U $imageData smestamo sadrzaj tog .tmp fajla u vidu stringa
                //https://www.php.net/manual/en/function.file-get-contents.php
                $imageData = file_get_contents($tmp_image_path);
                //Sada na stranici prikazujemo sliku
                //https://www.php.net/manual/en/function.base64-encode.php
                //Jako vazno: na ovaj nacin mozemo da pristupimo u slici koja vec uploadovana, samo sto...
                //...umesto putanje iz tmp fajla navodimo putanju u kojoj inace cuvamo slike
                //Na primer: 
                //$putanja_slike = 'C:\wamp64\www\PictureUpload\pics\\'.$naziv_slike;
                //echo sprintf('<img src="data:image/png;base64,%s"/>', base64_encode($putanja_slike));
                echo sprintf('<img src="data:image/png;base64,%s" width="400px"/>', base64_encode($imageData));
                //Potrebno je jos sacuvati sliku u folderu koji zelimo
                //Na osnovu imena slike dohvatamo informacije o njenoj putanji (ideja je da se dohvati ekstenzija)
                $info = pathinfo($_FILES['user_file']['name']);
                //Dohvatamo ekstenziju slike koja je upload-ovana
                $ext = $info['extension'];
                //Generisemo ime nove slike
                //Ovde je potrebno da ubacimo neki timestamp kako je slike ne bi preklapale
                $newname = "ime_slike.".$ext; 
                //U $target je putanja na serveru na kojoj ce se slika cuvati
                $target = 'C:\wamp64\www\PictureUpload\pics\\'.$newname;
                //Slika se premesta na novu lokaciju na serveru
                //https://www.php.net/manual/en/function.move-uploaded-file.php
                move_uploaded_file($_FILES['user_file']['tmp_name'], $target);
            }
        //linkovi:
        //https://www.w3schools.com/php/php_file_upload.asp
        //https://www.tutorialspoint.com/php/php_file_uploading.htm
        //http://si3psi.etf.rs/materijali/vezbe/PSI_Vezbe05-07_PHP.pdf
        //Sve ovo isto, ali preko Code Ignitera:
        //https://www.guru99.com/codeigniter-file-upload.html
        ?>
    </body>
</html>