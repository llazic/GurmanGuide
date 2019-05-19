<p class="title"> Moj profil </p>
<form name="izmenaR" action="<?php echo site_url('C_Restoran/sacuvajIzmeneRestorana')?>" method="post">
    <table class="tblctr" cellspacing="15" cellpadding="5">
	<tr>
            <td> Korisničko ime: </td>
            <td> <?php echo $korime; ?> </td>
	</tr>
        <tr>
            <td> Lozinka: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('lozinkarestoran') ."</font>"?>
                <input type="password" name="lozinkarestoran" size="50" value="<?php echo set_value('lozinkarestoran',$lozinka); ?>"></td>
        </tr>
	<tr>
            <td> Potvrdi lozinku: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('potvrdalozinkerestoran') ."</font>"?>
                <input type="password" name="potvrdalozinkerestoran" size="50" value="<?php echo set_value('potvrdalozinkerestoran', $lozinka); ?>"></td>
	</tr>
	<tr>
            <td> E-mail: </td>
            <td> <?php echo $email; ?> </td>
            </tr>
	<tr>
            <td> Kontakt telefon: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('telefon') ."</font>"?>
                <input type="text" name="telefon" size="50" value="<?php echo set_value('telefon', $brTelefona); ?>" ></td>
	</tr>
	<tr>
            <td> Naziv restorana: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('imerestorana') ."</font>"?>
                <input type="text" name="imerestorana" size="50" value="<?php echo set_value('imerestorana', $imeRestorana); ?>"></td>
	</tr>
	<tr>
            <td> Radno vreme: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('radnovreme') ."</font>"?>
                <textarea cols="47" rows="7" name="radnovreme" class="tekst" value=""><?php echo set_value('radnovreme', $radnoVreme); ?></textarea></td>
	</tr>
	<tr>
            <td> Adresa: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('adresarestorana') ."</font>"?>
                <input type="text" name="adresarestorana" size="50" value="<?php echo set_value('adresarestorana', $adresaRestorana); ?>"></td>
	</tr>
	<tr>
            <td> Grad: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('gradrestorana') ."</font>"?>
                <input type="text" name="gradrestorana" size="50" value="<?php echo set_value('gradrestorana', $gradRestorana); ?>"></td>
	</tr>
	<tr>
            <td> Država: </td>
            <td><?php echo "<font color='red' size='2'>" .form_error('drzavarestorana') ."</font>"?>
                <input type="text" name="drzavarestorana" size="50" value="<?php echo set_value('drzavarestorana', $drzavaRestorana); ?>"></td>
	</tr>
	<tr>
            <td> Slika: </td>
            <td><input type="file" name="slikarestoran" accept="image/gif, image/jpeg, image/png"></td>
	</tr>
    </table>
    <table class="tblctr" cellspacing="50">
	<tr>
            <td class="polje"><a href="<?php echo site_url('C_Restoran/unosJela')?>"><input type="button" name="dodajJelo" value="Dodaj jelo"></a></td>
	</tr>
	<tr>
            <td class="polje"><input type="submit" name="izmeni" value="Sačuvaj izmene"></td>
	</tr>
    </table>
</form>