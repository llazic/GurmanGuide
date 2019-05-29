<!--Autor: Nikola Bozovic 2016/0439-->
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

			.headerH{
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
			
			a{
				color:black;
			}

			.mojprofil{
				text-align: right;
				margin-right: 50px;
				margin-top: 70px;
			}

                        * {
                          box-sizing: border-box;
                        }

                        .pretraga {
                          width: 60%;
                          padding : 20px;
                          border: 2px solid #ccc;
                                margin-left: 40%;
                                height: 50px;
                          border-radius: 4px;
                          resize: vertical;
                        }
                        
                        .naslovH1 {
                                text-align: center;
                                font-size: 45px;
                                letter-spacing: 2px;
                                font-weight: bold;
                        }
                        .card {
                          background-color: white;
                                border-radius: 10px;
                          padding: 25px;
                          margin-left: 23%;
                                margin-right: 20%;
                                margin-top: 2%;
                                margin-bottom: 2%;
                                width: 55%;
                                height: 170px;
                                 
                        }
                        .topnav {
                          overflow: hidden;
                          background-color: #333;
                        }

                        .topnav a {
                          float: right;
                          display: block;
                          color: #f2f2f2;
                          text-align: center;
                          padding: 14px 16px;
                          text-decoration: none;
                        }

                        .topnav a:hover {
                          background-color: #ddd;
                          color: black;
                        }
                        .header {
                            padding: 30px;
                            margin-left: 25%;
                            margin-right: 25%;

                        }
                        .row:after {
                          content: "";
                          display: table;
                          clear: both;
                        }
                        .leftcolumn {
                          float: left;
                          width: 60%;
                        }

                        .rightcolumn {
                          float: left;
                          width: 40%;
                          padding-left: 20px;
                        }
                        .row:after {
                          content: "";
                          display: table;
                          clear: both;
                        }
                        @media screen and (max-width: 800px) {
                          .leftcolumn, .rightcolumn {
                                width: 100%;
                                padding: 0;
                          }
                        }
                        .dropbtn {
                          background-color: #333;
                                border-radius: 10px;
                          color: white;
                          padding: 14px;

                          font-size: 16px;
                          border: none;
                          cursor: pointer;
                                text-align: center;
                        }
                        .topnav .dropdown{
                                display: inline-block;
                        }
                        .dropdown {
                          position: relative;
                          display: inline-block;
                        }

                        .dropdown-content {
                          display: none;
                          position: absolute;
                          background-color: #f2f2f2;
                                border-radius: 10px;
                          min-width: 160px;
                          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                          z-index: 1;
                        }

                        .dropdown-content a {
                          color: black;
                          padding: 12px 16px;
                          text-decoration: none;
                          display: block;
                                border-radius: 10px;
                        }

                        .dropdown-content a:hover {background-color: #333; color: white;border-radius: 10px;}

                        .dropdown:hover .dropdown-content {
                          display: block;
                                border-radius: 10px;
                        }

                        .dropdown:hover .dropbtn {
                          background-color: white;
                                color: black;
                                border-radius: 10px;
                        }
                        .lugano {
                                font-family:"Georgia",serif;
                                font-style:italic;
                        }
                        
                       .center{
                            text-align:center;
			}
                        
                        .sredina{
				margin-left:auto;
				margin-right:auto;
				vertical-align:middle;
			}
                        /*Ovo je samo zbog meniRestorana.php ...*/
                         .slikaMeni {
                            border-radius: 8px;
                            object-fit: cover;
                            float: left;
                            width: 290px;
                            height: 200px;
                        }
                        
                        .korisnik {
                                font-size: 12px;
                                color: #923b7a;
                        }

                        .komentar {
                                border-style: ridge;
                                border-color: #2d022b;
                                border-width: 2px;
                                margin-bottom: 10px;
                                font-size: 13px;
                                border-radius: 15px;
                                padding-left: 5px;
                                padding-right: 5px;
                        }

                        p.sastojci {
                                font-size: 15px;
                                font-style: italic;
                        }
                        .column {
                            height: auto;
                            width: auto;
                            padding: 10px;
                            border: 1px solid #000000;
                            float: center;
                            margin-left: 0px;
                            margin-top: 10px;
                            margin-right: 0px;
                        }
                        .column h1 {
                                width: 300px;
                                font-size: 20px;
                                border-bottom: 1px solid #000000;
                        }
                        /*Ovo je samo zbog meniRestorana.php ...*/
		</style>
	</head>
	<body onload="clear()">
		<div class="headerH">
                    <a href="<?php echo site_url('C_Gost/index')?>">
			<img src="http://localhost/GurmanGuide/images/logo.png" width="300" class="logo">
			<div class="mojprofil">
				<a href="<?php echo site_url('C_Gost/prijaviSe');?>" align="right"> Prijavi se</a> &nbsp;
				<a href="<?php echo site_url('C_Gost/registrujRestoran');?>" align="right"> Registruj restoran</a> &nbsp;
				<a href="<?php echo site_url('C_Gost/registrujGurmana');?>" align="right"> Postani Gurman</a>
			</div>
		</a>
		</div>
