<!--Autor: Nikola Bozovic 2016/0439-->
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <script type="text/javascript">
           window.onload = function () {
                document.getElementById('search').onchange = function () {
                document.getElementById('l1').setAttribute( 'href', 'pretragaJelaPoNazivu/' + this.value);
                document.getElementById('l2').setAttribute( 'href', 'pretragaJelaPoSastojku/' + this.value);
                document.getElementById('l3').setAttribute( 'href', 'pretragaJelaPoRestoranu/' + this.value);
                };
            };
        </script>
<form name="forma" action="" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="leftcolumn">
			<input type="text" class="pretraga" id="search" name="target" placeholder="Pretraži...">
		</div>
		<div class="rightcolumn">
			<div class="dropdown">
  			<button class="dropbtn">Pretraga jela</button>
  			<div class="dropdown-content">
                                <a href="" id = "l1">po nazivu</a>
  				<a href="" id = "l2">po sastojku</a>
  				<a href="" id = "l3">po restoranu</a>
                        </div>
		</div>
		<div class="dropdown">
			<button class="dropbtn">Pretraga restorana</button>
			<div class="dropdown-content">
				<a href="<?php echo site_url('C_Gost/pretragaRestoranaPoNazivu');?>">po nazivu</a>
				<a href="<?php echo site_url('C_Gost/pretragaRestoranaPoAdresi');?>">po adresi</a>
			</div>
		</div>
	</div>
</div>
</form>
<br>
<div class="row">
<h1 class="naslovH1"><b>Gurmani preporučuju</b></h1>
</div>

<div class="card">
	<img src="../Images/calzone1.png" alt="Calzone" style="float:left;width:120px;height:120px;margin-right:40px;"/>
	<a href="prikazJela.html">Calzone</a>
	<img src="../images/star.png" style="margin-top:2px; margin:right:5px; height:20px; width:20px;" align="right">
	<img src="../images/star.png" style="margin-top:2px; margin:right:5px; height:20px; width:20px;" align="right">
	<img src="../images/star.png" style="margin-top:2px; margin:right:5px; height:20px; width:20px;" align="right">
	<img src="../images/star.png" style="margin-top:2px; margin:right:5px; height:20px; width:20px;" align="right">
	<img src="../images/star.png" style="margin-top:2px; margin:right:5px; height:20px; width:20px;" align="right">
	<p class="lugano">	"Danas poznati italijanski specijalitet, ali malo ko zna da je nastao za vreme starog Rima. Prvi čovek koji ju je probao bio je, ni manje ni više, nego Gaj Julije Cezar."
</p>
</div>





</body>


</html>
