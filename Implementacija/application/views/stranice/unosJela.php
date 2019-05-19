 <p class="title"> Unos jela </p>
    <form action="<?php echo site_url('C_Restoran/unesiJelo')?>" name="form" id="form" method="post"> 
      <table class="center" cellspacing="15" cellpadding="5">
         <tr>
            <td>Naziv jela:</td>
            <td><?php echo "<font color='red' size='2'>" .form_error('naziv') ."</font>"?>
                <input type="text" name="naziv" size="50" placeholder="&nbsp;Unesite naziv jela" value="<?php echo set_value('naziv',$naziv); ?>"></td>
         </tr>
         <tr>
            <td>Opis jela:</td>
            <td><?php echo "<font color='red' size='2'>" .form_error('opisjela') ."</font>"?>
                <textarea cols="50" rows="20" class="tekst" placeholder="Unesite opis jela" value="" name="opisjela"><?php echo set_value('opisjela',$opisjela); ?></textarea></td>
         </tr>
         <tr>
            <td>Sastojci</td>
            <td>
                
                    <div id="append" name="append"></div>
                    <input type="hidden" value="0" name="iCheckboxes" id="iCheckboxes">
                    <input type="text" value="" name="sastojci" id="noviSastojak">
                    <input type="button" value="append" onclick="javascript:append()" />
                    <!--<input type="submit" value="submit" />-->
                <!--</form>-->
            </td>
         </tr>
         <tr>
            <td>Slika:</td>
            <td><input type="file" name="slikajelo" accept="image/gif, image/jpeg, image/png"></td>
         </tr>
      </table>
      <table class="center" cellspacing="50">
         <tr>
            <td class="polje"><input type="submit" name="potvrdi" value="Potvrdi unos" ></td>
         </tr>
      </table>
</form>