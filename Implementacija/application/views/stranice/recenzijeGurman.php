<p class="title"> Moje recenzije </p> <br/>
                <?php 
                    $imaRecenzija = false;
                    foreach($recenzije as $recenzija){
                        echo '<div class="box"> <a href="#'./*UMETNUTI LINK KA JELU*/'"> <img src="'.$recenzija->PutanjaSlike.'" class="slika" style="width:120px;height:120px;margin-right:40px;"/> </a>';
                        echo '<p>';
                        echo $recenzija->NazivJela;
                        for ($i = 0; $i < $recenzija->Ocena; $i++){
                            echo '<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">';
                        }
                        echo '</p>';
                        echo '<font class="stil">"';
                        echo $recenzija->Komentar;//ILI OVDE STAVITI LINK
                        echo '" <a href="'.site_url('C_Gurman/postaviPromeniRecenziju/'.$recenzija->IdJelo).'">izmeni</a>';
                        echo '</font>';
                        echo '</div> <br/>';
                        $imaRecenzija = true;
                    }
                    if ($imaRecenzija == false){
                        echo '<center>Nema odobrenih recenzija.</center>';
                    }
                ?>