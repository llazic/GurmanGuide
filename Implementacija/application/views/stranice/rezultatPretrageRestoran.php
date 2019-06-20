<!--Nenad Babin-->
      <link rel="stylesheet" type="text/css" href="../../../../prototip/rezultatiPretrage.css">
      <?php
        echo "<p class='title'>";
        echo $naslov;
        echo "</p>";
        if (empty($restorani) == false) { 
            foreach ($restorani as $restoran) {
                echo "<div class='column'>";
                echo "<h1><a href=";
                echo site_url("{$this->router->class}/pregledRestorana/$restoran->IdKorisnik");
                echo ">$restoran->Naziv</a></h1>";
                echo "<table width='100%'>";
                    echo "<tr>";
                        echo "<td width='25%' align='center''>";
                            echo "<img class='slika' src='$restoran->Putanja'>";
                        echo "</td>";
                        echo "<td width='75%'>";
                            //Ovo da se menja
                            //echo " <p class='sastojci'>$restoran->Sastojci</p>";
                            echo "<div class='komentar'>";
                                echo "<p class='korisnik'>Adresa:</p>";
                                echo "<p>$restoran->Adresa, " .$restoran->Grad ."</p>";
                            echo "</div>";
                            echo "<div class='komentar'>";
                                echo "<p class='korisnik'>Top jelo:</p>";
                                if ($restoran->topJeloNaziv == "Restoran nema jela") {
                                    echo "<p>Restoran nema jela</p>"; //ovo ispravi posle
                                } else {
                                    echo "<p><a title='Prikaži mi jelo' href=";
                                    echo site_url("{$this->router->class}/prikaziJelo/$restoran->topJeloId"); //ovo ispravi posle
                                    echo ">$restoran->topJeloNaziv</a></p>"; //ovo ispravi posle
                                }
                            echo "</div>";
                            echo "<div class='komentar'>";
                                echo "<p><a title='Prikaži mi sva jela ovog restorana' href=";
                                echo site_url("{$this->router->class}/prikaziMeniRestorana/$restoran->IdKorisnik");
                                echo ">Prikaži mi meni restorana</a></p>";
                            echo "</div>";
                        echo "</td>";
                    echo "</tr>";
                echo "</table></div>";                  
            }
        } else {
            echo "<center>Nije pronađen ni jedan rezultat po zadatom kriterijumu... Pokušajte ponovo.</center>"
            . "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
        }
      ?>
