<html>
	<head>
		<title><?php $title?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="icon" href="http://localhost/GurmanGuide/images/icon.png">
		<script language="Javascript">
                    function append()
                    {

                        var noviSastojak = document.getElementById('noviSastojak').value;
                        document.getElementById('noviSastojak').value = '';
                        var i = parseInt(document.getElementById( "iCheckboxes" ).value);
                        var cb = document.createElement( "input" );
                        cb.type = "checkbox";
                                //cb.onclick = "remove(" + i + ")";
                        cb.id = "id"+i;
                        cb.name = "name"+i;
                                cb.value = noviSastojak;
                        cb.checked = true;
                        var text = document.createTextNode(noviSastojak);
                        document.getElementById( 'append' ).appendChild( text );
                        document.getElementById( 'append' ).appendChild( cb );
                        document.getElementById( "iCheckboxes" ).value = parseInt(document.getElementById( "iCheckboxes" ).value) + 1;
                     }
                </script>
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
                        
                        .slikaMeni {
                            border-radius: 8px;
                            object-fit: cover;
                            float: left;
                            width: 290px;
                            height: 200px;
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
                        
                        .tags {
                                list-style: none;
                                margin: 0;
                                overflow: hidden;
                                padding: 0;
                        }

                        .tags li {
                                float: left;
                        }

                        .tag {
                                background: #eee;
                                border-radius: 3px 0 0 3px;
                                color: #999;
                                display: inline-block;
                                height: 26px;
                                line-height: 26px;
                                padding: 0 20px 0 23px;
                                position: relative;
                                margin: 0 10px 10px 0;
                                text-decoration: none;
                                -webkit-transition: color 0.2s;
                        }

                        .tag::before {
                                background: #C6DBC0;
                                border-radius: 10px;
                                box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
                                content: '';
                                height: 6px;
                                left: 10px;
                                position: absolute;
                                width: 6px;
                                top: 10px;
                        }

                        .tag::after {
                                background: #C6DBC0;
                                border-bottom: 13px solid transparent;
                                border-left: 10px solid #eee;
                                border-top: 13px solid transparent;
                                content: '';
                                position: absolute;
                                right: 0;
                                top: 0;
                        }

                        .tag:hover {
                                background-color: #923b7a;
                                color: white;
                        }

                        .tag:hover::after {
                                border-left-color: #923b7a;
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
                        
                        table.center {
                            margin-left:auto;
                            margin-right:auto;
                            vertical-align:middle;
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