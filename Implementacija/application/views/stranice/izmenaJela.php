  <p class="title"> Izmena jela </p>
    <?php if(isset($poruka))
        echo "<center><font color='red' size='3'>$poruka</font></center><br>";
    ?>
    <p class="center"><img src="<?php echo $slika?>" width="350" class="border"/></p>
    <form action="<?php echo site_url("{$this->router->class}/sacuvajIzmeneJela/$idJela")?>" name="izmenaJ" id="form" method="post" enctype="multipart/form-data"> 
      <table class="tblctr" cellspacing="15" cellpadding="5">
         <tr>
            <td>Naziv jela:</td>
            <td><?php echo "<font color='red' size='2'>" .form_error('naziv') ."</font>"?>
                <input type="text" name="naziv" size="50" value="<?php echo set_value('naziv', $naziv); ?>"></td>
         </tr>
         <tr>
            <td>Opis jela:</td>
            <td><?php echo "<font color='red' size='2'>" .form_error('opisjela') ."</font>"?>
                <textarea cols="50" rows="20" class="tekst"  value="" name="opisjela"><?php echo set_value('opisjela', $opisjela); ?></textarea></td>
         </tr>
         <tr>
            <td valign="top">Sastojci:</td>
            <td>
                
                    <input type="hidden" value="<?php echo count($sastojci)*3;?>" name="iCheckboxes" id="iCheckboxes">
                    <input type="text" value="" name="sastojci" id="noviSastojak">
                    <input type="button" value="Dodaj sastojak" onclick="append()" />
                    <div id="append" name="append">
                        <?php
                            $i = 0;
                            foreach ($sastojci as $sastojak){
                                echo '<input type="hidden" id="id'.$i.'" name="name'.$i.'" value="'.$sastojak->Naziv.'"/>';
                                echo '<input type="button" id="id'.($i+2).'" value="x" onclick="brisi(\''.$i.'\', \''.($i+1).'\', \''.($i+2).'\')"/>';
                                echo '<font id="id'.($i+1).'"> '.$sastojak->Naziv.'<br/></font>';
                                $i += 3;
                            }
                        ?>
                    </div>
                    <!--<input type="submit" value="submit" />-->
                <!--</form>-->
            </td>
         </tr>
         <tr>
            <td>Slika:</td>
            <td><input type="file" name="slikajelo" accept="image/gif, image/jpeg, image/png"></td>
         </tr>
      </table>
      <table class="tblctr" cellspacing="50">
         <tr>
            <td class="polje">
                <a href="<?php echo site_url('C_Restoran/ukloniJelo/'.$idJela)?>"><input type="button" name="ukloni" value="Ukloni jelo"></a>
		<input type="submit" name="potvrdi" value="Potvrdi izmenu">
            </td>
         </tr>
      </table>
</form>
    