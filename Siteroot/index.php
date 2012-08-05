<?php
  session_name( 'calculon' );
  session_start();
  isset( $_SESSION['M'] )?$_SESSION['M']:0;
  
	$str_browser_language = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
	$str_browser_language = !empty($_GET['language']) ? $_GET['language'] : $str_browser_language;
	switch (substr($str_browser_language, 0,2))
	{
		case 'de':
			$str_language = 'de';
			break;
		case 'en':
			$str_language = 'en';
			break;
		default:
			$str_language = 'en';
	}

	$arr_available_languages = array();
	$arr_available_languages[] = array('str_name' => 'English', 'str_token' => 'en');
	$arr_available_languages[] = array('str_name' => 'Deutsch', 'str_token' => 'de');

	$str_available_languages = (string) '';
	foreach ($arr_available_languages as $arr_language)
	{
		if ($arr_language['str_token'] !== $str_language)
		{
			$str_available_languages .= '<a href="'.strip_tags($_SERVER['PHP_SELF']).'?language='.$arr_language['str_token'].'" lang="'.$arr_language['str_token'].'" xml:lang="'.$arr_language['str_token'].'" hreflang="'.$arr_language['str_token'].'">'.$arr_language['str_name'].'</a> | ';
		}
	}
	$str_available_languages = substr($str_available_languages, 0, -3);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="<?php echo $str_language; ?>" xml:lang="<?php echo $str_language; ?>">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Calculon</title>
	<style type="text/css">
    
    @font-face {  
      font-family: "digit13";  
      src: local("digit13"), url( /style/fonts/GDDigit13LED.otf );
    } 
    /*CSS RESET*/
    body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { 
      margin:0;
      padding:0;
    }
    table {
      border-collapse:collapse;
      border-spacing:0;
    }
    fieldset,img { 
      border:0;
    }
    address,caption,cite,code,dfn,em,strong,th,var {
      font-style:normal;
      font-weight:normal;
    }
    ol,ul {
      list-style:none;
    }
    caption,th {
      text-align:left;
    }
    h1,h2,h3,h4,h5,h6 {
      font-size:100%;
      font-weight:normal;
    }
    q:before,q:after {
      content:'';
    }
    abbr,acronym { border:0;
    }
    
		body {
      /*background-image: url("/style/images/bender.jpg");*/
      background-repeat: no-repeat;
      background-position: bottom left;
      background-attachment: fixed;
      background-color: #FFF;
			color: #EFEFEF;
			font-family: "myriad pro", "Helvetica", "sans-serif";
			font-size: .9em;
			margin: 0;
			padding: 10px 20px 20px 20px;
      color: #000;
      width: 100%;
      height: 100%;
		}

    div{
      color: #333;
    }
    
    div#vertcenter{
      position: absolute;
      top: 50%;
      height: 0px;
      width: 100%;
    }
    
    div#calculon{
      background-image: url("/style/images/calculon.png");
      background-repeat: no-repeat;
      background-position: bottom left;
      background-color: transparent;
      width : 820px;
      height: 320px;
      float :none;
      clear :none;
      margin: -160px auto 0;
      border: 1px solid;
      border-radius: 12px;
      position: relative;
      box-shadow: 0 4px 4px -3px #0B2F3A;
    }
    
    div#resultdisplayGlass,
    div#resultdisplay{
      background: none repeat scroll 0 0 transparent;
      border: medium none;
      border-radius: 12px 12px 12px 12px;
      color: #FFFFFF;
    }
    
    div#resultdisplay{
    color: #0B4C5F;
    background-color: #2ECCFA;
    float: right;
    height: 64px;
    margin: 12px;
    overflow: hidden;
    padding: 0;
    position: relative;
    width: 600px;
    z-index: 64;
    }
    
    div#resultdisplayGlass{
      background-image: url("/style/images/glass.png");
      background-position: center center;
      background-repeat: no-repeat;
      border: medium none;
      height: 64px;
      left: 0;
      margin: 0;
      overflow: hidden;
      position: absolute;
      top: 0;
      width: 600px;
      z-index: 100;
    }
    
    div#results{
      color: inherit;
      font-family: 'digit13';
      font-size: 48px;
      height: 64px;
      position: absolute;
      right: 12px;
      text-align: right;
      text-transform: uppercase;
      top: 12px;
    }
    
    ul#display{
      background-color: #FFFFFF;
      left: 5px;
      position: absolute;
      top: 5px;
      z-index: 101;
    }
    
    ul#display li{
      background-color: #2ECCFA;
      clear: none;
      color: #0B4C5F;
      cursor: pointer;
      float: left;
      font-weight: bold;
      height: 12px;
      margin: 2px;
      text-align: center;
      width: 12px;
    }
    
    ul#display li.BlackOnOrange,
    div#resultdisplay.BlackOnOrange{
      color: #333;
      background-color: #FF8000;
    }
    
    ul#display li.orangeOnBlack,
    div#resultdisplay.orangeOnBlack{
      color: #FF8000;
      background-color: #333;
    }
    
    div#resultdisplay.Error{
      color: #FF0000;
      background-color: #610B0B;
    }
    
    ul#keypad{
      list-style: none;
      margin: 0px;
      padding: 0px;
      width: 298px;
      position: relative;
      float: right;
    }
    
    div#banter{
      background-color: #FFFFFF;
      border: 1px solid;
      border-radius: 0px 12px 12px 12px;
      box-shadow: 0 4px 4px -3px #0B2F3A;
      font-size: 13px;
      float: right;
      height: auto;
      max-height: 220px;
      list-style: none outside none;
      margin: 0 12px;
      padding: 6px 12px;
      position: relative;
      width: 240px;
      overflow: hidden;
    }
    
    ul#keypad li{
      background-color: #F5DA81;
      color: #333;
      border: 1px solid #FFBF00;
      border-radius: 12px 12px 12px 12px;
      box-shadow: 0 4px 4px -3px #0B2F3A;
      clear: none;
      float: left;
      font-size: 22px;
      height: 24px;
      margin: 6px 0 6px 6px;
      text-align: center;
      width: 64px;
      cursor: pointer;
    }
    
    ul#keypad li.doublew{
      width: 134px;
    }
    
    ul#keypad li.extraw{
      width: 208px;
    }
    ul#keypad li.extraf{
      font-size: 36px;
    }
    
    ul#keypad li:hover{
      background-color: #FFBF00;
    }
    ul#keypad li:active{
      box-shadow: none;
    }
    ul#memorybench.inuse li{
      color: #01DF01;
      border-color: inherit;
      background-color: #21610B;
    }
    div#fondMems{
      background-image: url("/style/images/fondmems.png");
      clear: none;
      display: none;
      float: left;
      height: 100px;
      margin-left: -36px;
      margin-top: -68px;
      position: relative;
      text-align: center;
      width: 180px;
      z-index: 101;
    }
    div#fondMems div{
      height: 32px;
      left: 8px;
      position: absolute;
      top: 18px;
      width: 128px;
      text-align: center;
      overflow: hidden;
    }
    div#fondMems div#damem{
      margin-top: 12px;
      font-size: 32px;      
    }
    
	</style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="/calculon.js"></script>
</head>

<body>
  <div id="vertcenter">
    <div id="calculon">
      <div id="fondMems">
      </div>
      <div id="resultdisplay" class="orangeOnBlack">
        <div id="results">0</div>
        <div id="resultdisplayGlass">
        </div>
      </div>  
      <ul id="keypad">
        <li>C</li><li>CE</li><li>MC</li><li>+/-</li>
        <li>MR</li>
        <ul id="memorybench">
          <li>M+</li><li>M-</li>
        </ul>
        <li>+</li>
        <li>7</li><li>8</li><li>9</li><li>-</li>
        <li>4</li><li>5</li><li>6</li><li>x</li>
        <li>1</li><li>2</li><li>3</li><li>/</li>
        <li>0</li><li>.</li><li class="doublew"> = </li>
      </ul>
      <div id="banter"></div>
      <ul id="display" title="Click to choose the display colorcombo">
        <li class="">&bull;</li>
          <li class="orangeOnBlack">&bull;</li>
          <li class="BlackOnOrange">&bull;</li>
      </ul>
    </div>
  </div>
  
  
</body>
</html>