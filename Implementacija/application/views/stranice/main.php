<!--Autor: Nikola Bozovic 2016/0439-->
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <script type="text/javascript">
           function insert() {
               var input = document.getElementById('search').value;
               if (input != "") {
                    document.getElementById('l1').setAttribute( 'href', "http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/pretragaJelaPoNazivu/" + input);
                    document.getElementById('l2').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/pretragaJelaPoSastojku/' + input);
                    document.getElementById('l3').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/pretragaJelaPoRestoranu/' + input);
                    document.getElementById('l4').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/pretragaRestoranaPoNazivu/' + input);
                    document.getElementById('l5').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/pretragaRestoranaPoAdresi/' + input);
                } else {
                    document.getElementById('l1').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/index/');
                    document.getElementById('l2').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/index/');
                    document.getElementById('l3').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/index/');
                    document.getElementById('l4').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/index/');
                    document.getElementById('l5').setAttribute( 'href', 'http://localhost/GurmanGuide/Implementacija/index.php/<?php echo "{$this->router->class}";?>/index/');
                }
           };
        </script>
<?php if(isset($poruka))
        echo "<center><font color='red' size='3'>$poruka</font></center><br>";
?>
<form name="forma" action="" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="leftcolumn">
			<input type="text" class="pretraga" id="search" name="target" placeholder="Pretraži...">
		</div>
                <div class="rightcolumn">
                    <div class="dropdown">
                        <div class="dropbtn">Pretraga jela</div>
                        <div class="dropdown-content">
                                <a href="" id = "l1" onclick="insert()">po nazivu</a>
                                <a href="" id = "l2" onclick="insert()">po sastojku</a>
                                <a href="" id = "l3" onclick="insert()">po restoranu</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <div class="dropbtn">Pretraga restorana</div>
                        <div class="dropdown-content">
                                <a href="" id = "l4" onclick="insert()">po nazivu</a>
                                <a href="" id = "l5" onclick="insert()">po adresi</a>
                        </div>
                    </div>
                </div>
        </div>
</form>


<?php
    if (empty($jelo) == false) {
        echo "<br><div class='row'><h1 class='naslovH1'><b>Gurmani preporučuju</b></h1></div>";
        echo "<div class='box'> <img class='slika'style='width:120px;height:120px;margin-right:40px;' src=' $jelo->Putanja'/>";
        echo "<p>";
        echo "<a href='";
        echo site_url("{$this->router->class}/prikaziJelo/$jelo->IdJelo");
        echo "'>$jelo->Naziv</a>";
        for ($i = 0; $i < $jelo->Ocena; $i++){
            echo "<img src='http://localhost/GurmanGuide/images/star.png' style='margin-top:2px; margin:right:5px; height:20px; width:20px;' align='right'>";
        }
        echo "</p>";
        echo "<p class='lugano'>$jelo->Komentar</p>";
        echo "<p style='float:right'>";
        echo "<a href='";
        echo site_url("{$this->router->class}/pregledProfilaGurmana/$jelo->idK");
        echo "'>$jelo->kIme</a></p></div>";
    }

?>