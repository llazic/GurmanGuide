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
   .mojprofil{
   text-align: right;
   margin-right: 50px;
   margin-top: 70px;
   }
   a{
   color:black;
   }
   .tekst{
   resize:none;
   }
</style>
<p class="title"> Registracija restorana </p>
<?php if(isset($poruka))
        echo "<center><font color='red' size='3'>$poruka</font></center><br>";
?>
<form name="loginform" action="<?php echo site_url('C_Gost/proveraRegistracijeRestoran') ?>" method="post" enctype="multipart/form-data">
    <table class="tblcrt" cellspacing="15" cellpadding="5">
       <tr>
          <td> Korisničko ime: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('korimerestoran') ."</font>"?>
              <input type="text" name="korimerestoran" size="50" placeholder="&nbsp;Unesite korisničko ime" value="<?php echo set_value('korimerestoran'); ?>">
          </td>
       </tr>
       <tr>
          <td> Lozinka: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('lozinkarestoran') ."</font>"?>
              <input type="password" name="lozinkarestoran" size="50" placeholder="&nbsp;Unesite lozinku" >
          </td>
       </tr>
       <tr>
          <td> Potvrdi lozinku: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('potvrdalozinkerestoran') ."</font>"?>
              <input type="password" name="potvrdalozinkerestoran" size="50" placeholder="&nbsp;Ponovo unesite lozinku" >
          </td>
       </tr>
       <tr>
          <td> E-mail: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('email') ."</font>"?>
              <input type="text" name="email" size="50" placeholder="&nbsp;Unesite e-mail" value="<?php echo set_value('email'); ?>">
          </td>
       </tr>
       <tr>
          <td> Kontakt telefon: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('telefon') ."</font>"?>
              <input type="text" name="telefon" size="50" placeholder="&nbsp;Unesite kontakt telefon" value="<?php echo set_value('telefon'); ?>">
          </td>
       </tr>
       <tr>
          <td> Naziv restorana: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('nazivrestorana') ."</font>"?>
              <input type="text" name="nazivrestorana" size="50" placeholder="&nbsp;Unesite naziv restorana" value="<?php echo set_value('nazivrestorana'); ?>">
          </td>
       </tr>
       <tr>
          <td> Radno vreme: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('radnovreme') ."</font>"?>
              <textarea cols="47" rows="7" name="radnovreme" class="tekst" placeholder="&nbsp;Unesite radno vreme" value="<?php echo set_value('radnovreme'); ?>"></textarea>
          </td>
       </tr>
       <tr>
          <td> Adresa: </td>
          <td>
              <?php echo "<font color='red' size='2'>" .form_error('adresarestorana') ."</font>"?>
              <input type="text" name="adresarestorana" size="50" placeholder="&nbsp;Unesite adresu" value="<?php echo set_value('adresarestorana'); ?>">
          </td>
       </tr>
       <tr>
          <td> Grad: </td>
          <td>
            <select name="grad">
                <?php 
                    foreach($gradovi as $grad){
                        echo '<option value="'.$grad->IdGrad.'">' .$grad->Naziv .'</option>';
                    }
                ?>
            </select>
          </td>
       </tr>
       <!--<tr>
          <td> Država: </td>
          <td><input type="text" name="drzavarestorana" size="50" placeholder="&nbsp;Unesite državu" ></td>
       </tr>-->
       <tr>
          <td> Slika: </td>
          <td><input type="file" name="slikarestoran" accept="image/gif, image/jpeg, image/png"></td>
       </tr>
    </table>
    <table class="center" cellspacing="50">
       <tr>
          <td class="polje"><input type="submit" name="potvrdi" value="Registruj se" ></td>
       </tr>
    </table>
</form>
<!-- ovde ubacujete ono sto hocete da bude ispod naslova-->
<!-- ostavite dovoljan broj <br/> posle toga sto ubacujete da bi footer bio skroz dole-->
<br/><br/><br/><br/><br/>
<div class="footer">
   <br/>
   <a href="kontakt.html"> Kontakt</a>&nbsp;
   <a href="onama.html"> O nama</a>
</div>
</body>
</html>