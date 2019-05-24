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
		 
         .box{
			 background-color: white;
			 width: 50%;
			 border: 1px solid darkgray;
			 padding: 10px;
			 margin: auto;
			 overflow:auto;
         }
		 
         .stil {
			 font-family:"Georgia",serif;
			 font-style:italic;
         }
		 
         .center {
			text-align:center;
         }
		 
         .slikaJela {
			 border-radius: 8px;
			 object-fit: cover;
			 float: center;
			 width: 350px;
			 height: 250px;
         }
		 
         .ocena {
			 font-family: "Arial Black", Gadget, sans-serif;
			 font-size: 40px;
         }
		 
         .btn-group .button {
			 background-color: #333;
			 border-radius: 12px;
			 border: none;
			 color: white;
			 padding: 12px 20px;
			 text-align: center;
			 text-decoration: none;
			 display: inline-block;
			 font-size: 13px;
			 cursor: pointer;
			 float: center;
			 border-width: 100%;
			 width:100%;
         }
		 
         .btn-group .button:hover {
			 background-color: #ddd;
			 color: black;
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
      <link rel="stylesheet" type="text/css" href="../../../../prototip/rezultatiPretrage.css">
      <?php
      echo "<p class='title'>$jelo->Naziv</p>";
      echo "<p class='center'><img class='slikaJela' src='$jelo->Putanja'/></p>";
      echo "<br/>";
      echo "<center>
                <table width='50%'>
                    <tr>
                        <td align='center' width='20%'>
                            <div class='komentar'>";
                                echo "<font class='ocena'>$jelo->Ocena</font>/5";
                      echo "</div>";
                      //Dugme za ostavljanje recenzije prikazati samo ako je korisnik ulogovan!
                      if (($this->session->userdata('korisnik')) != NULL) {
                          if ($this->session->userdata('korisnik')->tipKorisnika == "gurman") {
                            echo "<div class='btn-group'>";
                              echo "<button class='button' name='recenzijaBtn' onclick=\"location.href='";
                              echo site_url("C_Gost/napisiRecenziju/");
                              echo "'\">Napisi recenziju</button>";
                            echo "</div>";
                          }
                      }
                  echo "</td>";
                  echo "<td>";
                    echo "<div class='komentar'>
                            <p class='korisnik'>Sastav:</p>";
                      echo "<p>$jelo->Sastojci</p>";
                    echo "</div>";
                    echo "<div class='komentar'>
                            <p class='korisnik'>Opis:</p>";
                      echo "<p>$jelo->Opis</p>";
                    echo "</div>";
                    echo "<div class='komentar'>
                             <p class='korisnik'>Ovo jelo ponosno nudi:</p>";
                             echo "<p><a title='Odvedi me u restoran' href=";
                             echo site_url("C_Gost/prikaziRestoran/$jelo->IdRestoran");
                             echo ">$jelo->imeRestorana</a></p>";
                             echo "</div>
                        </td>
                     </tr>
                  </table>
               </center>";
        echo "<br>";
        
        if (empty($recenzije) == false) {
            foreach ($recenzije as $recenzija) {
                echo "<div class='box'>
             <img src='$recenzija->Slika' class='slika' style='width:120px;height:120px;margin-right:40px;'/>";
                echo "<p><a href='";
                echo site_url("C_Gost/pregledProfilaGurmana/$recenzija->idK");
                echo "'>$recenzija->kIme</a>";
                for ($i = 0; $i < $recenzija->Ocena; $i++){
                    echo "<img src='http://localhost/GurmanGuide/images/star.png' style='margin-top:2px; margin:right:5px; height:20px; width:20px;' align='right'>";
                }
                echo "</p>";
                echo "<font class='stil'>'$recenzija->Komentar'</font>";
                echo "</p>
                    </div>
                    <br/>";
            }
        } else {
            echo "<center>Trenutno nema recenzija za ovo jelo.</center>";
        }
        
      ?>
      <!-- ovde ubacujete ono sto hocete da bude ispod naslova-->
      <!-- ostavite dovoljan broj <br/> posle toga sto ubacujete da bi footer bio skroz dole-->
