<html>
	<head>
		<title><?php $title?></title>
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

			.tblctr {
				margin-left:auto;
				margin-right:auto;
				vertical-align:middle;
			}
			.polje {
				text-align:center;
			}

			.user {
				text-align:right;
				margin-right:10px;
				font-size: 15px;
				font-family:"Arial", Gadget, sans-serif
			}

			.profil{
				text-align: right;
				margin-right: 50px;
				margin-top: 70px;
			}

			a{
				color:black;
			}

			.tekst{
				resize:none;
			}
                        
			.center{
                text-align: center;
            }
                        
            .sredina{
				margin-left:auto;
				margin-right:auto;
				vertical-align:middle;
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
                        
            .stil {
				font-family:"Georgia",serif;
				font-style:italic;
			}
                        
            .border {
				padding:1px;
				border:4px solid #021a40;
			}
                        
            .gore{
				vertical-align:top;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div class="header">
                    <a href="<?php echo site_url('C_Restoran/index');?>"><img src="http://localhost/GurmanGuide/images/logo.png" width="300" class="logo"></a>
			<div class="profil">
				<a href="<?php echo site_url('C_Restoran/izmenaRestorana');?>" align="right"> Moj profil</a> &nbsp;
				<a href="<?php echo site_url('C_Restoran/izlogujse');?>" align="right"> Izloguj se</a>
			</div>
		</div>