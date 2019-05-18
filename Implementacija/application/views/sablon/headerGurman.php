<html>
	<head>
		<title><?php echo $title?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="icon" href="http://localhost/GurmanGuide/images/icon.png">
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
			
			.slika{
				float:left;
			}
			
			.star{
				margin-top: 2px;
				margin-right: 5px;
				height: 20px;
				width: 20px;
			}

			table.center {
				margin-left:auto;
				margin-right:auto;
				vertical-align:middle;
			}

			.polje {
				text-align:center;
			}

			.crvenaSlova {
				font-size: 13px;
				font-family: Arial;
				color: red;
			}

			.mojprofil{
				text-align: right;
				margin-right: 50px;
				margin-top: 70px;
			}

			a{
				color:black;
			}
                        

			.sredina{
				margin-left:auto;
				margin-right:auto;
				vertical-align:middle;
			}
		</style>
	</head>
	<body>
		<div class="header">
                    <a href="<?php echo site_url('C_Gurman/index');?>"> <img src="http://localhost/GurmanGuide/images/logo.png" width="300" class="logo"> </a>
			<div class="mojprofil">
                            <a href="<?php echo site_url('C_Gurman/izmenaProfila');?>" align="right"> Moj profil</a> &nbsp;
				<a href="<?php echo site_url('C_Gurman/izlogujSe');?>" align="right"> Izloguj se </a>
			</div>
		</div>