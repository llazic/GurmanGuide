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
   a{
   color:black;
   }
   .mojprofil{
   text-align: right;
   margin-right: 50px;
   margin-top: 70px;
   }
</style>
<p class="title">Prijavljivanje </p>
<?php if(isset($poruka))
        echo "<center><font color='red' size='3'>$poruka</font></center><br>";
?>
<form name="loginform" action="<?php echo site_url('C_Gost/proveraPrijave') ?>" method="post">
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
    </table>
    <table class="center" cellspacing="50">
       <tr>
          <td class="polje" colspan="2"><input type="submit" name="potvrdi" value="Prijavi me" ></td>
       </tr>
    </table>
</form>