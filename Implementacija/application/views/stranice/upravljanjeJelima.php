<p class="title">Upravljanje jelima </p>
<?php 
	 if (empty($jela) == false) { 
		foreach ($jela as $jelo){
			echo "<div class='box'>";
                        echo '<a href ="'.site_url('C_Administrator/pregledanoJelo?id=').$jelo->IdJelo.'">';
			echo "<div class='btn-group-green'>";
			echo "<button class='button' >Pregledano</button>";
			echo "</div></a>";
                        echo '<a href ="'.site_url('C_Administrator/obrisiJelo?id=').$jelo->IdJelo.'">';
			echo "<div class='btn-group-red'>";
			echo "<button class='button' >Obrisi</button>";
			echo "</div></a>";
			echo "<p>Restoran: <font class='stil'>";
			echo $restoran[$jelo->IdJelo]->Naziv;
                        echo "</font></p><p>Naziv jela: <font class='stil'>";
			echo $jelo->Naziv;
                        echo "</font></p><p>Sastav: <font class='stil'>";
                        foreach ($sastojci[$jelo->IdJelo] as $sastojak){
                            echo $sastojak->Naziv;
                            if($sastojak!=$sastojci[$jelo->IdJelo][count($sastojci[$jelo->IdJelo])-1])
                            echo ",";
                        }
			echo "</font></p><p>Opis: <font class='stil'>";
                        echo $jelo->Opis;
                        echo "</font></p></div>"; 
                        echo "<br>";

		}
	}else{
	  echo "<center>Nema nepregledanih jela</center>";
	}
?>