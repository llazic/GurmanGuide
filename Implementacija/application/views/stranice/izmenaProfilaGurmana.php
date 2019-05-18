<p class="title"> Moj profil </p>
<form name="profil" action="<?php echo site_url('C_Gurman/sacuvajIzmene')?>" method="POST">
		<table class="center" cellspacing="15" cellpadding="5">
			<tr>
				<td align="top">Korisničko ime:</td>
				<td>
					<?php echo $korisnickoIme; ?>
				</td>
			</tr>
			<tr>
				<td>Lozinka:</td>
				<td><?php echo "<font color='red' size='2'>" .form_error('lozinkagurman') ."</font>"?>
                                    <input type="password" name="lozinkagurman" size="50" placeholder="&nbsp;Unesite lozinku" value="<?php echo set_value('lozinkagurman', $lozinka); ?>"></td>
			</tr>
			<tr>
				<td>Potvrdi lozinku:</td>
				<td><?php echo "<font color='red' size='2'>" .form_error('potvrdalozinkegurman') ."</font>"?>
                                    <input type="password" name="potvrdalozinkegurman" size="50" placeholder="&nbsp;Ponovo unesite lozinku" value="<?php echo set_value('potvrdalozinkegurman', $lozinka); ?>"></td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td>
					<?php echo $email; ?>
				</td>
			</tr>
			<tr>
				<td>Ime:</td>
				<td><?php echo "<font color='red' size='2'>" .form_error('imegurman') ."</font>"?>
                                    <input type="text" name="imegurman" size="50" placeholder="&nbsp;Unesite Vaše ime" value="<?php echo set_value('imegurman', $ime); ?>"></td>
			</tr>
			<tr>
				<td>Prezime:</td>
				<td><?php echo "<font color='red' size='2'>" .form_error('prezimegurman') ."</font>"?>
                                    <input type="text" name="prezimegurman" size="50" placeholder="&nbsp;Unesite Vaše prezime" value="<?php echo set_value('prezimegurman', $prezime); ?>"></td>
			</tr>
			<tr>
				<td>Pol:</td>
				<td>    <?php echo "<font color='red' size='2'>" .form_error('pol') ."</font>"?>
                                        <input type="radio" name="pol" value="M"<?php if(set_value('pol', $pol)=="M"){ echo 'checked="true"';}?>>Muški
                                        <input type="radio" name="pol" value="Z"<?php if(set_value('pol', $pol)=="Z"){ echo 'checked="true"';}?>>Ženski
				</td>
			</tr>
			<tr>
				<td>Slika:</td>
				<td>   
					<input type="file" name="slikagurman" accept="image/gif, image/jpeg, image/png">
				</td>
			</tr>
		</table>
		<table class="center" cellspacing="50">
			<tr>
				<td class="polje" colspan="2"><input type="submit" name="sacuvajizmene" value="Sačuvaj izmene"></td>
			</tr>
		</table>
    </form>