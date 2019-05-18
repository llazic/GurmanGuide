<p class="title"> Recenzija </p>
<?php if(isset($poruka))
        echo "<center><font color='red' size='3'>$poruka</font></center><br>";
?>
                <form action="<?php echo site_url('C_Gurman/sacuvajRecenziju/'.$idJelo);?>" method="POST">
                    <table class="center" cellspacing="15" cellpadding="5">

                            <tr>
                                    <td> Jelo: </td>
                                    <td> <?php echo $nazivJela?> </td>
                            </tr>
                            <tr>
                                    <td> Unesite ocenu: </td>
                                    <td>
                                                    <input type="radio" name="rate" value="1"> 1
                                                    &nbsp;<input type="radio" name="rate" value="2"> 2
                                                    &nbsp;<input type="radio" name="rate" value="3"> 3
                                                    &nbsp;<input type="radio" name="rate" value="4"> 4
                                                    &nbsp;<input type="radio" name="rate" value="5" checked="true"> 5

                                    </td>
                            </tr>
                            <tr>
                                    <td class="vertikalno"> Unesite komentar: </td>
                                    <td><textarea cols="50" rows="20" class="tekst" name="komentar" placeholder="&nbsp;Unesite Vaš komentar" ></textarea></td>
                            </tr>
                    </table>
                    <table class="center" cellspacing="50">
                            <tr>
                                    <td class="polje"><input type="submit" name="postavi" value="Postavi recenziju" ></td>
                            </tr>
                    </table>
                </form>