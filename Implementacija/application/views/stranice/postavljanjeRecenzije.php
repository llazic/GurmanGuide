<p class="title"> Recenzija </p> 
<?php if(isset($poruka))
        echo "<center><font color='red' size='3'>$poruka</font></center><br>";
?>
                <form name="recenzija" action="<?php echo site_url('C_Gurman/sacuvajRecenziju/'.$idJelo);?>" method="POST">
                    <table align="center" cellspacing="15" cellpadding="5">

                            <tr>
                                    <td> Jelo: </td>
                                    <td> <?php echo $nazivJela?> </td>
                            </tr>
                            <tr>
                                    <td> Restoran: </td>
                                    <td> <?php echo $nazivRestorana?> </td>
                            </tr>
                            <tr>
                                    <td> Unesite ocenu: </td>
                                    <td>
                                                    <input type="radio" name="rate" value="1" <?php if (isset($ocena) && $ocena == 1) {echo 'checked="true"';}?>> 1
                                                    &nbsp;<input type="radio" name="rate" value="2" <?php if (isset($ocena) && $ocena == 2) {echo 'checked="true"';}?>> 2
                                                    &nbsp;<input type="radio" name="rate" value="3" <?php if (isset($ocena) && $ocena == 3) {echo 'checked="true"';}?>> 3
                                                    &nbsp;<input type="radio" name="rate" value="4" <?php if (isset($ocena) && $ocena == 4) {echo 'checked="true"';}?>> 4
                                                    &nbsp;<input type="radio" name="rate" value="5" <?php if (isset($ocena) && $ocena != 5) {} else {echo 'checked="true"';} ?>> 5

                                    </td>
                            </tr>
                            <tr>
                                    <td class="vertikalno"> Unesite komentar: </td>
                                    <td>
                                        <textarea cols="50" rows="20" class="tekst" name="komentar" placeholder="&nbsp;Unesite Vaš komentar"><?php if (isset($komentar)) {echo $komentar;}?></textarea>
                                    </td>
                            </tr>
                    </table>
                    <table class="center" cellspacing="50">
                            <tr>
                                    <td class="polje"><input type="submit" name="postavi" value="Postavi recenziju" ></td>
                            </tr>
                    </table>
                </form>