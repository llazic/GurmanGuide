<p class="title">Upravljanje jelima </p>
<?php 
	 if (empty($jela) == false) { 
		foreach ($jela as $jelo){
			echo "<div class='box'>";
			echo "<div class='btn-group-green'>";
			echo "<button class='button' onclick='".site_url('C_Administrator/pregledaj_jelo/').$jelo->IdJelo."'>Pregledano</button>";
			echo "</div>";
			echo "<div class='btn-group-red'>";
			echo "<button class='button' onclick='".site_url('C_Administrator/obrisi_jelo/').$jelo->IdJelo."'>Obrisi</button>";
			echo "</div>";
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

		}
	}else{
	  echo "<center>Nema nepregledanih jela</center>";
	}
?>