<!--Autor: Nikola Bozovic 2016/0439-->
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <script type="text/javascript">
           window.onload = function () {
                document.getElementById('search').onchange = function () {
                document.getElementById('l1').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/C_Gost/pretragaJelaPoNazivu/' + this.value);
                document.getElementById('l2').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/C_Gost/pretragaJelaPoSastojku/' + this.value);
                document.getElementById('l3').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/C_Gost/pretragaJelaPoRestoranu/' + this.value);
                document.getElementById('l4').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/C_Gost/pretragaRestoranaPoNazivu/' + this.value);
                document.getElementById('l5').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/C_Gost/pretragaRestoranaPoAdresi/' + this.value);
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
				<a href="" id = "l4">po nazivu</a>
  				<a href="" id = "l5">po adresi</a>
			</div>
		</div>
	</div>
</div>
</form>
<br>
<div class="row">
<h1 class="naslovH1"><b>Gurmani preporučuju</b></h1>
</div>


<?php
    echo "<div class='card'> <img src='$jelo->Putanja' style='float:left;width:120px;height:120px;margin-right:40px;'/>";
    echo "<a href='";
    echo site_url("C_Gost/prikaziJelo/$jelo->IdJelo");
    echo "'>$jelo->Naziv</a>";
    for ($i = 0; $i < $jelo->Ocena; $i++){
        echo "<img src='http://localhost/GurmanGuide/images/star.png' style='margin-top:2px; margin:right:5px; height:20px; width:20px;' align='right'>";
    }
    echo "<p class='lugano'>$jelo->Komentar</p></div>";
?>

</body>
</html>