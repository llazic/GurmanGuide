<p class="title">Upravljanje Registracijama </p>
<?php
if (empty($registracije) == false) {
    foreach ($registracije as $registracija) {
        echo "<div class='box'>";
        echo '<a href ="' . site_url('C_Administrator/pregledanaRegistracija?id=') . $registracija->id . '">';
        echo "<div class='btn-group-green'>";
        echo "<button class='button' >Pregledano</button>";
        echo "</div></a>";
        echo '<a href ="' . site_url('C_Administrator/obrisiRegistraciju?id=') . $registracija->id  . '">';
        echo "<div class='btn-group-red'>";
        echo "<button class='button' >Obrisi</button>";
        echo "</div></a>";
        echo "<p>Restoran: <font class='stil'>";
        echo $registracija->imeRestorana;
        echo "</font></p><p>Kontakt telefon: <font class='stil'>";
        echo $registracija->brTelefona;
        echo "</font></p><p>Adresa: <font class='stil'>";
        echo $registracija->adresaRestorana;
        echo "</font></p><p>Grad: <font class='stil'>";
        echo $registracija->gradRestorana;
         echo "</font></p><p>Drzava: <font class='stil'>";
        echo $registracija->drzavaRestorana;
        echo "</font></p><p>Radno vreme: <font class='stil'>";
        echo $registracija->radnoVreme;
        echo "</font>";
        echo "</p></div>";
        echo "<br>";
    }
} else {
    echo "<center>Nema nepregledanih registracija</center>";
}
?>