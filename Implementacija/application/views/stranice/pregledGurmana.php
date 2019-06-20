<p class="title"> <?php echo $ime." ".$prezime?></p>

<p style="text-align:center;"><img src="<?php echo $slikagurman?>" width="350" class=""/></p>
		<p style="text-align:center;"><font>
			Korisničko ime:&nbsp;<?php echo $korime?><br></br>
		</p>
		<p style="text-align:center;"><font>
			Recenzije jela:
		</p>
                <?php 
                    foreach($recenzije as $recenzija){
                        echo '<div class="box"><img src="'.$recenzija->PutanjaSlike.'" class="slika" style="width:120px;height:120px;margin-right:40px;"/>';
                        echo '<p><a href="'.site_url($this->router->class.'/prikaziJelo/'.$recenzija->IdJelo).'">';
                        echo $recenzija->NazivJela;
                        echo '</a>';
                        for ($i = 0; $i < $recenzija->Ocena; $i++){
                            echo '<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">';
                        }
                        echo '</p>';
                        echo '<font class="stil">"';
                        echo $recenzija->Komentar;
                        echo '"</font>';
                        echo '</div> <br/>';
                    }
                ?>