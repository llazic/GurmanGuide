<!--Autor: Lazar Lazic 2016/0245-->
        <style>
                body{
                        background-color:rgb(198, 219, 192);
                        font-family: "Arial Black", Gadget, sans-serif;
                }

                .logo{
                        position: absolute;
                        margin-top: 20px;
                        margin-left: 30px;
                }

                .header{
                        position: absolute;
                        clear: both;
                        top: 0;
                        left: 0;
                        right: 0;
                        background-color: #efefef;
                        height: 170px;
                }

                .footer{
                        position: absolute;
                        clear: both;
                        height: 70px;
                        left: 0;
                        right: 0;
                        align: bottom;
                        background-color: #efefef;
                        text-align: center;
                }

                .title{
                        margin-top: 200px;
                        text-align: center;
                        font-size: 30px;
                }

                .tblcrt {
                        margin-left:auto;
                        margin-right:auto;
                        vertical-align:middle;
                }

                .polje {
                        text-align:center;
                }

                .crvenaSlova {
                        font-size: 13px;
                        font-family: Arial;
                        color: red;
                }

                .mojprofil{
                        text-align: right;
                        margin-right: 50px;
                        margin-top: 70px;
                }

                a{
                        color:black;
                }
        </style>
		<p class="title"> Registracija Gurmana </p>

		<table class="tblcrt" cellspacing="15" cellpadding="5">
			<tr>
				<td align="top">Korisničko ime:</td>
				<td>
					<input type="text" name="korimegurman" size="50" placeholder="&nbsp;Unesite korisničko ime">
					<br/>
				</td>
			</tr>
			<tr>
				<td>Lozinka:</td>
				<td><input type="password" name="lozinkagurman" size="50" placeholder="&nbsp;Unesite lozinku"></td>
			</tr>
			<tr>
				<td>Potvrdi lozinku:</td>
				<td><input type="password" name="potvrdalozinkegurman" size="50" placeholder="&nbsp;Ponovo unesite lozinku"></td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td><input type="text" name="email" size="50" placeholder="&nbsp;Unesite e-mail"></td>
			</tr>
			<tr>
				<td>Ime:</td>
				<td><input type="text" name="imegurman" size="50" placeholder="&nbsp;Unesite Vaše ime"></td>
			</tr>
			<tr>
				<td>Prezime:</td>
				<td><input type="text" name="prezimegurman" size="50" placeholder="&nbsp;Unesite Vaše prezime"></td>
			</tr>
			<tr>
				<td>Pol:</td>
				<td>
					<input type="radio" name="pol" checked="true">Muški
					<input type="radio" name="pol">Ženski
				</td>
			</tr>
			<tr>
				<td>Slika:</td>
				<td><input type="file" name="slikagurman" accept="image/gif, image/jpeg, image/png"></td>
			</tr>
		</table>
		<table class="center" cellspacing="50">
			<tr>
				<td class="polje" colspan="2"><input type="submit" name="potvrdi" value="Postani Gurman"></td>
			</tr>
		</table>

		<!-- ovde ubacujete ono sto hocete da bude ispod naslova-->
		<!-- ostavite dovoljan broj <br/> posle toga sto ubacujete da bi footer bio skroz dole-->

		<br/><br/><br/><br/><br/><br/>

		<div class="footer">
			<br/>
			<a href="kontakt.html"> Kontakt</a>&nbsp;
			<a href="onama.html"> O nama </a>
		</div>
	</body>
</html>
