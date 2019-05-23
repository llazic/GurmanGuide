<!--Dunja Culafic-->
     <!--<link rel="stylesheet" type="text/css" href="../../../../prototip/rezultatiPretrage.css">-->
      <p class="title"> Meni restorana </p>
      <?php
        if (empty($jela) == false) { 
            foreach ($jela as $jelo) {
                echo "<div class='column'>";
                echo "<h1><a href=";
                echo site_url("C_Restoran/prikaziJelo/$jelo->IdJelo");
                echo ">$jelo->Naziv</a></h1>";
                echo "<table width='100%'>";
                    echo "<tr>";
                        echo "<td width='25%' align='center''>";
                            echo "<img class='slikaMeni' src='$jelo->Putanja'>";
                            echo "<a href=";
                            echo site_url("C_Restoran/izmeniJelo/$jelo->IdJelo"); 
                            echo " ><input type='button' name='izmeni'";
                            echo " value=";
                            echo "Izmeni";
                            echo " ></a>";
                        echo "</td>";
                        echo "<td width='75%'>";
                            //Ovo da se menja
                            echo " <p class='sastojci'>$jelo->Sastojci</p>";
                            echo "<div class='komentar'>";
                                echo "<p class='korisnik'>Opis:</p>";
                                echo "<p>$jelo->Opis</p>";
                            echo "</div>";
                            echo "<div class='komentar'>";
                                echo "<p class='korisnik'>Recenzija:</p>";
                                echo "<p'>$jelo->Recenzija</p>";
                            echo "</div>";
                        echo "</td>";
                    echo "</tr>";
                echo "</table></div>";                  
            }
        } else {
            echo "<center>Meni restorana nije moguće videti trenutno.</center>";
        }
      ?>
