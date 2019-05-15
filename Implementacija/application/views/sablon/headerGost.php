<html>

<head>
	<title>GurmanGuide</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="icon" href="../images/icon.png">
	<style>
		body{
			background-color:rgb(198, 219, 192);
			font-family: "Arial Black", Gadget, sans-serif;

		}
		* {
		  box-sizing: border-box;
		}

		input[type=text] {
		  width: 60%;
		  padding : 20px;
		  border: 2px solid #ccc;
			margin-left: 40%;
			height: 50px;
		  border-radius: 4px;
		  resize: vertical;
		}
		h1{
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
			width: 55%
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
	</style>
</head>

<body>
	<div class="topnav">
		<a href="registracijaGurmana.html">Postani Gurman</a>
		<a href="registracijaRestorana.html">Registruj restoran</a>
		<a href="login.html">Prijavi se</a>
	</div>