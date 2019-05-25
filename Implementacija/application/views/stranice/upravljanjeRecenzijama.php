<p class="title">Upravljanje Recenzijama </p>
<?php
if (empty($recenzije) == false) {
    foreach ($recenzije as $recenzija) {
        echo "<div class='box'>";
        echo '<a href ="' . site_url('C_Administrator/pregledanaRecenzija?idk=') . $recenzija->IdKor . '&idj=' . $recenzija->IdJel . '">';
        echo "<div class='btn-group-green'>";
        echo "<button class='button' >Pregledano</button>";
        echo "</div></a>";
        echo '<a href ="' . site_url('C_Administrator/obrisiRecenziju?idk=') . $recenzija->IdKor . '&idj=' . $recenzija->IdJel . '">';
        echo "<div class='btn-group-red'>";
        echo "<button class='button' >Obrisi</button>";
        echo "</div></a>";
        echo "<p>Postavio: <font class='stil'>";
        echo $recenzija->NazKor;
        echo "</font></p><p>Restoran: <font class='stil'>";
        echo $recenzija->NazRes;
        echo "</font></p><p>Naziv jela: <font class='stil'>";
        echo $recenzija->NazJel;
        echo "</font></p><p>Utisak Gurmana: <font class='stil'>";
        echo $recenzija->Opis;
        echo "</font></p><p>Ocena: ";
        for ($x = 0; $x < $recenzija->Ocena; $x++) {
            echo '<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="middle">';
        }
        echo "</p></div>";
        echo "<br>";
    }
} else {
    echo "<center>Nema nepregledanih recenzija</center>";
}
?>