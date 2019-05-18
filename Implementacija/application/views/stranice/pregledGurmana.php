<p class="title"> <?php echo $ime." ".$prezime?></p>

<p style="text-align:center;"><img src="<?php echo $slikagurman?>" width="350" class="border"/></p>
		<p style="text-align:center;"><font>
			Korisničko ime:&nbsp;<?php echo $korime?><br></br>
		</p>
		<p style="text-align:center;"><font>
			Recenzije jela:
		</p>
                <?php 
                    foreach($recenzije as $recenzija){
                        echo '<div class="box"> <a href="#'./*UMETNUTI LINK KA JELU*/'"> <img src="'.$recenzija->PutanjaSlike.'" class="slika" style="width:120px;height:120px;margin-right:40px;"/> </a>';
                        echo '<p>';
                        echo $recenzija->NazivJela;
                        for ($i = 0; $i < $recenzija->Ocena; $i++){
                            echo '<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">';
                        }
                        echo '</p>';
                        echo '<font class="stil">';
                        echo $recenzija->Komentar;//ILI OVDE STAVITI LINK
                        echo '</font>';
                        echo '</div> <br/>';
                    }
                ?>
<!--		<div class="box"> <a href="#"> <img src="../Images/calzone1.png" class="slika" style="width:120px;height:120px;margin-right:40px;"/> </a>
						<p>
							Calzone
							<img src="../images/star.png" class="star" align="right">
							<img src="../images/star.png" class="star" align="right">
							<img src="../images/star.png" class="star" align="right">
							<img src="../images/star.png" class="star" align="right">
							<img src="../images/star.png" class="star" align="right">
						</p>
						<font class="stil">
							"Fenomenalan i ocaravajuci ukus. Kada jednom probate, sigurno cete se vratiti da probate opet!"
						</font>

		</div>
		<br/>
		<div class="box"> <a href="#"> <img src="../Images/carbonara.jpeg" class="slika" style="width:120px;height:120px;margin-right:40px;"/> </a>
						<p>
							Pizza carbonara
							<img src="../images/star.png" class="star" align="right">
							<img src="../images/star.png" class="star" align="right">
							<img src="../images/star.png" class="star" align="right">

						</p>
						<font class="stil">
							"Jeo sam i bolje pice. Mozda mi samo nije legla..."
						</font>

		</div>-->