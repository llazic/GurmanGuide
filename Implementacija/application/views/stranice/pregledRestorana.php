<p class="title"> <?php echo $imeRestorana; ?> </p>
<p class="center"><img src="http://localhost/GurmanGuide/Images/madera.jpg" width="350" class="border"/></p>
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
		<!--<table class="sredina">
                     <tr>
			<td> ponedeljak </td>
			<td> 10:00-00:00 </td>
                    </tr>
                    <tr>
			<td> utorak </td>
			<td> 10:00-00:00 </td>
                    </tr>
                    <tr>
			<td> sreda </td>
			<td> 10:00-00:00 </td>
                    </tr>
                    <tr>
			<td> četvrtak </td>
			<td> 10:00-00:00 </td>
                    </tr>
                    <tr>
			<td> petak </td>
			<td> 10:00-01:00 </td>
                    </tr>
                    <tr>
			<td> subota </td>
			<td> 10:00-01:00 </td>
                    </tr>
                    <tr>
			<td> nedelja </td>
			<td> 10:00-00:00 </td>
                    </tr>
		</table>-->
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
<div class="box"><a href="#"> <img src="http://localhost/GurmanGuide/Images/calzone1.png" class="slika" alt="Calzone" style="width:120px;height:120px;margin-right:40px;"/></a>
    <p>
	Calzone
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
    </p>
    <font class="stil">
	"Danas poznati italijanski specijalitet, ali malo ko zna da je nastao za vreme starog Rima. Prvi čovek koji ju je probao bio je, ni manje ni više, nego Gaj Julije Cezar."
    </font>
</div>
<br/>
<div class="box"><a href="#"> <img src="http://localhost/GurmanGuide/Images/hrana1.png" class="slika" alt="Svinjetina sa povrćem" style="width:120px;height:120px;margin-right:40px;"/></a>
    <p>
	Svinjetina sa povrćem
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
    </p>
    <font class="stil">
	"Poznat turski specijalitet pre nego što su primili islam, prepuno orijentalnih začina koji Vas vraćaju u peti vek p.n.e. u Malu Aziju."
    </font>
</div>
<br/>
<div class="box"><a href="#"> <img src="http://localhost/GurmanGuide/Images/krilca.png" class="slika" alt="Pileća krilca" style="width:120px;height:120px;margin-right:40px;"/></a>
    <p>
	Pileća krilca u BBQ sosu
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
	<img src="http://localhost/GurmanGuide/images/star.png" class="star" align="right">
    </p>
    <font class="stil">
	"Originalan recept za BBQ sos koji je napravio Sveti Sava dok je učio školu. Prenosio se sa kolena na koleno, a original se nalazi u kripti manastira Manasije."
    </font>
</div>
<br/><br/>
<table class="sredina">
    <tr>
	<td><a href="<?php echo site_url('C_Restoran/prikaziMeniRestorana')?>"><input type="button" name="dugmeMeni" value="Pređi na meni restorana"></a></td>
    </tr>
</table>