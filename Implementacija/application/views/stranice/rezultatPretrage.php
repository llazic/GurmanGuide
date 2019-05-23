<!--Nenad Babin-->
      <link rel="stylesheet" type="text/css" href="../../../../prototip/rezultatiPretrage.css">
      <p class="title"> Rezultat pretrage </p>
      <?php
        if (empty($jela) == false) { 
            foreach ($jela as $jelo) {
                echo "<div class='column'>";
                echo "<h1><a href=";
                echo site_url("C_Gost/prikaziJelo/$jelo->IdJelo");
                echo ">$jelo->Naziv</a></h1>";
                echo "<table width='100%'>";
                    echo "<tr>";
                        echo "<td width='25%' align='center''>";
                            echo "<img class='slika' src='$jelo->Putanja'>";
                        echo "</td>";
                        echo "<td width='75%'>";
                            //Ovo da se menja
                            echo " <p class='sastojci'>$jelo->Sastojci</p>";
                            echo "<div class='komentar'>";
                                echo "<p class='korisnik'>Opis:</p>";
                                echo "<p>$jelo->Opis</p>";
                            echo "</div>";
                            echo "<div class='komentar'>";
                                echo "<p class='korisnik'>Gde probati:</p>";
                                echo "<p><a title='Odvedi me u restoran' href=";
                                echo site_url("C_Gost/prikaziRestoran/$jelo->IdRestoran");
                                echo ">$jelo->Restoran</a></p>";
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
            echo "<center>Nije pronađen ni jedan rezultat po zadatom kriterijumu... Pokušajte ponovo.</center>";
        }
      ?>
