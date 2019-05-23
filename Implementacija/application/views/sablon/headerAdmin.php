<html>
	<head>
		<title><?php echo $title?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="icon" href="../images/icon.png">
		<style>
			body{
				background-color:rgb(198, 219, 192);
				font-family: "Arial Black", Gadget, sans-serif;
			}
                        .btn-group-red .button {
                          background-color: #FF0000;
                          border-radius: 12px;
                          border: none;
                          color: white;
                          padding: 12px 20px;
                          text-align: center;
                          text-decoration: none;
                          display: inline-block;
                          font-size: 15px;
                          cursor: pointer;
                          float: right;
                        }
                        .btn-group-green .button {
                          background-color: #33CC33;
                          border-radius: 12px;
                          border: none;
                          color: white;
                          padding: 12px 20px;
                          text-align: center;
                          text-decoration: none;
                          display: inline-block;
                          font-size: 15px;
                          cursor: pointer;
                          float: right;
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

			.stil {
				font-family:"Georgia",serif;
				font-style:italic;
			}

			.center{
				text-align:center;
			}

			.box{
			  background-color: white;
				width: 50%;
				border: 2px solid darkgray;
				padding: 10px;
				margin: auto;
				overflow:auto;
			}

			.slika{
				float:left;
			}

			.mojprofil{
				text-align: right;
				margin-right: 50px;
				margin-top: 70px;
			}

			.star{
				margin-top: 2px;
				margin-right: 5px;
				height: 20px;
				width: 20px;
			}

			a {
				color:black;
			}

			.sredina{
				margin-left:auto;
				margin-right:auto;
				vertical-align:middle;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div class="header">
			<a href="<?php echo site_url('C_Admin/index')?>"> <img src="http://localhost/GurmanGuide/images/logo.png" width="300" class="logo"></a>
			<div class="mojprofil">
				<a href="<?php echo site_url('C_Administrator/upravljanje_registracijama');?>" align="right"> Upravljanje registracijama</a> &nbsp;
				<a href="<?php echo site_url('C_Administrator/upravljanje_recenzijama');?>" align="right"> Upravljanje recenzijama</a> &nbsp;
				<a href="<?php echo site_url('C_Administrator/upravljanje_jelima');?>" align="right"> Upravljanje jelima</a> &nbsp;
				<a href="<?php echo site_url('C_Administrator/izlogujSe');?>" align="right"> Izloguj se</a>
			</div>
		</div>