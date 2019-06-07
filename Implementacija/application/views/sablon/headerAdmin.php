<html>
    <head>
        <title><?php echo $title ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="icon" href="http://localhost/GurmanGuide/images/icon.png">
        <style>
            * {
                box-sizing: border-box;
            }
            .naslovH1 {
                text-align: center;
                font-size: 45px;
                letter-spacing: 2px;
                font-weight: bold;
            }
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
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
                border: none;
                //cursor: pointer;
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
            .pretraga {
                width: 60%;
                padding : 20px;
                border: 2px solid #ccc;
                margin-left: 40%;
                height: 50px;
                border-radius: 4px;
                resize: vertical;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <a href="<?php echo site_url('C_Administrator/index') ?>"> <img src="http://localhost/GurmanGuide/images/logo.png" width="300" class="logo"></a>
            <div class="mojprofil">
                <a href="<?php echo site_url('C_Administrator/upravljanjeRegistracijama'); ?>" align="right"> Upravljanje registracijama</a> &nbsp;
                <a href="<?php echo site_url('C_Administrator/upravljanjeRecenzijama'); ?>" align="right"> Upravljanje recenzijama</a> &nbsp;
                <a href="<?php echo site_url('C_Administrator/upravljanjeJelima'); ?>" align="right"> Upravljanje jelima</a> &nbsp;
                <a href="<?php echo site_url('C_Administrator/izlogujSe'); ?>" align="right"> Izloguj se</a>
            </div>
        </div>