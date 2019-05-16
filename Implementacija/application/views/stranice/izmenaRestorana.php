<p class="title"> Moj profil </p>
<form name="izmenaR" action="<?php echo site_url('C_Restoran/izmenaRestorana')?>" method=post"">
    <?php if(isset($poruka))
        echo "<font color='red'>$poruka</font><br>";
    ?>
    <table class="tblctr" cellspacing="15" cellpadding="5">
	<tr>
            <td> Korisničko ime: </td>
            <td> <?php echo $korime; ?> </td>
	</tr>
        <tr>
            <td> Lozinka: </td>
            <td><input type="password" name="lozinkarestoran" size="50" value="<?php echo $lozinka; ?>"></td>
        </tr>
	<tr>
            <td> Potvrdi lozinku: </td>
            <td><input type="password" name="potvrdalozinke" size="50" value="<?php echo $lozinka; ?>"></td>
	</tr>
	<tr>
            <td> E-mail: </td>
            <td> <?php echo $email; ?> </td>
            </tr>
	<tr>
            <td> Kontakt telefon: </td>
            <td><input type="text" name="telefon" size="50" value="<?php echo $brTelefona; ?>" ></td>
	</tr>
	<tr>
            <td> Naziv restorana: </td>
            <td><input type="text" name="imerestorana" size="50" value="<?php echo $imeRestorana; ?>"></td>
	</tr>
	<tr>
            <td> Radno vreme: </td>
            <td><textarea cols="47" rows="7" class="tekst">ponedeljak  10:00-00:00&#13;utorak 10:00-00:00&#13;sreda 10:00-00:00&#13;četvrtak 10:00-00:00&#13;petak 10:00-01:00&#13;subota 10:00-01:00&#13;nedelja 10:00-00:00</textarea></td>
	</tr>
	<tr>
            <td> Adresa: </td>
            <td><input type="text" name="adresarestorana" size="50" value="<?php echo $adresaRestorana; ?>"></td>
	</tr>
	<tr>
            <td> Grad: </td>
            <td><input type="text" name="gradrestorana" size="50" value="<?php echo $gradRestorana; ?>"></td>
	</tr>
	<tr>
            <td> Država: </td>
            <td><input type="text" name="drzavarestorana" size="50" value="<?php echo $drzavaRestorana; ?>"></td>
	</tr>
	<tr>
            <td> Slika: </td>
            <td><input type="file" name="slikarestoran" accept="image/gif, image/jpeg, image/png"></td>
	</tr>
    </table>
    <table class="tblctr" cellspacing="50">
	<tr>
            <td class="polje"><a href="Unos jela/unosJela.html"><input type="button" name="dodajJelo" value="Dodaj jelo"></a></td>
	</tr>
	<tr>
            <td class="polje"><input type="submit" name="izmeni" value="Sačuvaj izmene"></td>
	</tr>
    </table>
</form>