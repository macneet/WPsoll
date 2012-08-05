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
  <link href="/style/calculon.css" title="calculon" type="text/css" rel="stylesheet">
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