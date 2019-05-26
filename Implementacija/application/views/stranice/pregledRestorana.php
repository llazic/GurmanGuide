<p class="title"> <?php echo $imeRestorana; ?> </p>
<p class="center"><img src="<?php echo $slikaRestorana?>" width="350" class="border"/></p>
<p class="center">
    <table class="sredina" cellspacing="15" cellpadding="5">
	<tr>
            <td> Kontakt telefon: </td>
            <td> <?php echo $brTelefona; ?> </td>
	</tr>
	<tr>
            <td> Adresa: </td>
            <td> <?php echo $adresaRestorana; ?> </td>
	</tr>
	<tr>
            <td class="gore"> Radno vreme: </td>
            <td><?php echo $radnoVreme; ?>
            </td>
	</tr>
	<tr>
            <td> Grad: </td>
            <td> <?php echo $gradRestorana; ?> </td>
	</tr>
	<tr>
            <td> Država: </td>
            <td> <?php echo $drzavaRestorana; ?> </td>
	</tr>
    </table>
</p>
<br/>
<p class="center"><font>
Top 3 jela:
</p>
<?php   
        if (empty($jela) == false) { 
            foreach ($jela as $jelo) {
                echo "<div class='box'>";
                    echo "<a href=";
                        echo site_url("C_Gost/prikaziJelo/$jelo->IdJelo");
                        echo ">";
                        echo"<img class='slika' src='$jelo->Putanja' style='width:120px;height:120px;margin-right:40px;' />";
                    echo "</a>";
                    for ($i = 0; $i < $jelo->Ocena; $i++){
                        echo '<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">';
                    }
                    echo "<p>";
                        echo "<a href=";
                        echo site_url("C_Gost/prikaziJelo/$jelo->IdJelo");
                        echo ">";
                            echo "$jelo->Naziv";
                        echo "</a>";
                    echo "</p>";
                    echo "<font class='stil'>";
                        echo "$jelo->Opis";
                    echo "</font>";
                echo "</div>";
                echo "</br>";
            }
        } else {
            echo "<center>Ovaj restoran nema ocenjenih jela.</center>";
        }
?>
<br/><br/>
<table class="sredina">
    <tr>
	<td><a href="<?php echo site_url("C_Restoran/prikaziMeniRestorana/$idRestoran")?>"><input type="button" name="dugmeMeni" value="Pređi na meni restorana"></a></td>
    </tr>
</table>