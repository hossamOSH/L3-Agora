<?php if (!defined('PmWiki')) exit();
/* BuildForms: HTML forms creation with pmwiki markup rev0.8 - 16 may 2005
* for PmWiki2 @author Pierre Rouzeau <pierre àt rouzeau döt net>  
* @license http://www.gnu.org/licenses/gpl.html GNU General Public License
* parameters saved in /wiki.d/$pagename.prm
* values saved in /wiki.d/$pagename.val
*/

Markup('frminput','inline','/\\(:frm([a-z0-9]+)(\\s+.*)?:\\)/e',
  "Keep(BFrmInput('$1',PSS('$2')))");

Markup('frmread','inline','/\\(:frd([a-z0-9]*)(\\s+.*)?:\\)/e',
  "Keep(BFrmRead('$1',PSS('$2')))");
  
Markup('testp','inline','/\\(:testp:\\)/e', "Keep(\$_POST['testok'])");  

$HandleActions['zform'] = 'Handlezform';  

function BFrmInput($type, $MatchList) {
  global $ScriptUrl, $WorkDir, $pagename;
  static $mult, $Fields, $FieldIdx, $vals, $BFrmNmParms;
  $args = ParseArgs($MatchList);
  $name = $args[''][0];
  if ($type!='op' and $type!='init') {
	if ($mult!='') {
      if ($mult=='select') $out = '</select><br />'; 
      $mult='';
	}
    if  ($type!='end') {
      if (isset($BFrmNmParms) and $name!='')
        foreach ($BFrmNmParms as $v) $Fields[$name][$v] = $args[$v];
      if (isset($args['regex']))  
	    $Fields[$name]['regex'] = $args['regex'];
      if (isset($vals[$name])) $value = $vals[$name];
	  else if ($args['value']) $value = $args['value'];
	  if (isset($value)) $Fields[$name]['value'] = $value;
	  $Fields[$name]['type'] = $type;
    }	
  }  
  if ($type == 'init') {
	if ($args['param'])
      foreach ($args['param'] as $v) $BFrmNmParms = $v;
    $out = "<form enctype='multipart/form-data' action='$ScriptUrl' method='post'>\n";
    $out .= BFrmInp ('hidden', 'pagename', $pagename).
    BFrmInp('hidden', 'action', 'zform');
	if (isset($args['action']))
	  $out .= BFrmInp('hidden', 'runaction', $args['action']);	
    if ($args['params'] !='')
	  $BFrmNmParms = explode(',', $args['params']);
    $vals = BFrmReadPars("$WorkDir/$pagename.val", TRUE); // read previous value
    return $out;
  }
  else if ($type=='end') {
    $fp = fopen("$WorkDir/$pagename.prm", "wb"); 
    foreach ($Fields as $fld=>$parm) {
      fwrite($fp,"\n$fld:");
	  foreach ($parm as $pm=>$v) 
	    if (substr($pm,0,4)=='disp' or in_array($pm, array('type','value','regex','function')))
          fwrite($fp," $pm=\"".myaddslashes($parm[$pm]).'"');
      if (isset($BFrmNmParms)) 
        foreach ($BFrmNmParms as $v) fwrite($fp," $v=\"{$parm[$v]}\""); 
    }
    fclose($fp);  
    return "</p>$out</form><p>";
  }
  else {
	if ($args['size']) $size = " size=".$args['size'];
	if (isset($args['disp'])) $disp = $args['disp'];
    else					$disp = $name;
	if ($type!='op') $Fields[$name]["disp"] = $disp;  
    if ($type=='op') {
	  $dsp = str_replace('-', '', "disp_$name");
	  $Fields[$FieldIdx][$dsp] = $disp;
	  if (isset($Fields[$FieldIdx]['value'])) {
        if ($Fields[$FieldIdx]['value']==$name) { 
          $sel=' selected';		  
          $chk=' checked';		  
		}  
	  } 
	} else if ($type=='check') {
      if (isset($value))
        if ($value==$name) $chk=' checked';
	}
	else 
	  $FieldIdx=$name;
    switch ($type) {
    case 'button':
	  if ($args['function'])
	    $Fields[$name]['function'] = $args['function'];
	  $out .= BFrmInp('submit', $name, "&nbsp;&nbsp;$disp&nbsp;&nbsp;");
    break;
    case 'msg':
	  if ($args['function']) 
	    $out .= $args['function']();
	  else
        $out .= "$vals[$name]";
    break;
    case 'field':
	  $fld = "<input name='$name'$size value=\"$value\" />";
	  if (strtolower($args['pos'])=='right') 
        $out .= "$disp $fld";
      else 
        $out .= "$fld $disp";
    break;
	case 'hidden':
	  $out .= "\n".BFrmInp('hidden', $name, $value);
	break;
    case 'check':
      $out .= BFrmInp('checkbox', $name, $name, $chk)." $disp";
    break;
	case 'text':
	  $rows = $args['rows'] ? $args['rows'] : 4;
	  $cols = $args['cols'] ? $args['cols'] : 40;
	  $value = str_replace('`', "\n", $value); 
	  $out .= "<textarea name='$name' rows=$rows cols=$cols>$value</textarea>";
	break;
    case 'radio':
	  if (!isset($value)) $Fields[$name]['value']= '';
      $mult='radio';
    break;
	case 'select':
	  if (!isset($value)) $Fields[$name]['value']= '';
	  $out .= "<select name='$name'$size>";
	  if ($args['function']) {
        foreach ($args['function']() as $k=>$v) {
		  $sel = $k==$value ? ' selected' : '';
		  $out .= "<option$sel value=$k> $v</option>";	
        }
        $out .= "</select>"; 
      }
	  else 
        $mult='select';
	break;  
	case 'op':
	  if ($mult=='radio') 
	    $out .= BFrmInp('radio', $FieldIdx, $name, $chk)." $disp";
	  else if ($mult=='select') 
	    $out .= "<option$sel value=$name> $disp";	
	break;
    }
    return $out;
  }
}

function myaddslashes($string) {
  return get_magic_quotes_gpc() ? $string : addslashes($string);
} 

function BFrmInp ($type, $name, $value, $sup='') {
  return "<input type='$type' name='$name' value=\"$value\"$sup />";
}

function Handlezform($pagename) {
  global $BFrmRdPar, $WorkDir, $BFrmSave; 
  if (@$_REQUEST['reset']) unlink ("$WorkDir/$pagename.val");
  else if (@$_REQUEST['wipe']) BFrmWipe();
  else if (!@$_REQUEST['cancel']) {
    $BFrmRdPar = BFrmReadPars("$WorkDir/$pagename.prm"); //read default and params
    $vals = BFrmReadPars("$WorkDir/$pagename.val", TRUE); // read previous value
//	dbf(var_export($vals, TRUE));	
    if ($vals) // set previous values
      foreach ($vals as $k=>$v) $BFrmRdPar[$k]['value']=$v;
    foreach ($BFrmRdPar as $k=>$v) {
      $text = @$_REQUEST[$k];
	  if ($text and isset($v['function']))
	    $bfunction = $v['function'];
      if (!$text) $text='';
      $valid = TRUE;
      if (isset($v['regex'])) { 
        $regex = $v['regex'];
        $valid = ereg ($regex, $text, $regs);
        $text = $regs[0];
      }  
      if ($valid) $BFrmRdPar[$k]['value']=$text;
	} 
	if (@$_REQUEST['runaction'] and @$_REQUEST['ok']) {
	  $act = $_REQUEST['runaction'];
      foreach (array('pagename','n','action','runaction','ok','setfont','setcolor') as $un)	
        unset($_REQUEST[$un]);
	  posttoh($act, $_REQUEST);
	}
	SDV ($BFrmSave, TRUE);
    if ($BFrmSave) BFrmSavePars();	  
	if (isset($bfunction))
      if (substr($bfunction, 0, 5)=='frmuf') 
        $bfunction(); // run button function beginning by frmuf
  }
  Redirect($pagename);
}

function BFrmWipe(){
  global $WorkDir;
  $files = BFrmListdir($WorkDir,'prm');
  foreach($files as $fl){
    $flroot = substr ($fl, 0, -4);
    if (!file_exists("$WorkDir/$flroot")) {
      unlink ("$WorkDir/$fl");
      unlink ("$WorkDir/$flroot.val");
	}
  }
}

function BFrmReadPars ($fparms, $simple=FALSE) {
  global $pagename;
  clearstatcache();
  if ($fpr = @fopen($fparms, "rb")) {	
    $contents = fread ($fpr, filesize($fparms));
    if (preg_match_all('/([A-Za-z0-9]+):(.*)/', $contents, $match)) {
	  foreach($match[1] as $ord=>$ln) {
        if ($simple) 
          $pars[$ln] = stripslashes($match[2][$ord]);
		else {
          $args = ParseArgs($match[2][$ord]);
		  if (isset($args['value']))
            $args['value'] = stripslashes($args['value']);
          $pars[$ln] = $args;
		  // unset ($pars[$ln]['#']);
		}  
	  }	
    }
    fclose($fpr);
    return $pars;
  }
}

function BFrmSavePars() {
  global $BFrmRdPar, $WorkDir, $pagename;
  if ($fp = fopen("$WorkDir/$pagename.val", "wb")){ //save again parameters  
    foreach ($BFrmRdPar as $key=>$dt) {
      $str = myaddslashes(str_replace ("\r", '', trim($dt['value'],'"'))); 
	  $str = str_replace ("\n", '`', $str);
      fwrite($fp,"$key:$str\n");
	}  	  
    fclose($fp); 
  }  
}

function BFrmListdir ($dir, $ext) { // list file of given extension in a directory
// return an array with key = value = filename - don't set the dot in extension
  if ($handle = @opendir($dir)) { 
	while (false!==($file=readdir($handle)))
  	  if (ereg("((.+)\.($ext))$", $file))
		$fl[$file] = $file;
	closedir($handle);
	natsort ($fl);
	return $fl;
  }
  else return array();
}

function BFrmRead($type, $MatchList) {
  static $FrmRead, $FrmRdPar;
  $args = ParseArgs($MatchList);
  $name = $args[''][0];
  if ($type == 'init') {
    $page = FrmPage($name);
    $FrmRead = BFrmReadPars ($page, TRUE);
    $FrmRdPar = BFrmReadPars (str_replace('.val', '.prm', $page));
//	dbf(var_export($FrmRdPar, TRUE));
  }	
  else {
    if (isset($args['page'])){
	  $page = FrmPage($args['page']);
      $read = BFrmReadPars($page, TRUE);
	  $readpar = BFrmReadPars(str_replace('.val', '.prm', $page));
	  $val = $read[$name];
	  $par = $readpar[$name];
    }
	else { 
	  $val = $FrmRead[$name];
	  $par = $FrmRdPar[$name];
	}   
	if (in_array ('disp', $args[''])) {
	  switch ($par['type']) {
	  case 'select': $s = $par['disp'].': ';
	  case 'radio': $dsp = str_replace('-', '', "disp_$val"); $val=$s.$par[$dsp]; break;
	  case 'check': if ($val) $val = $par["disp"]; break;
	  case 'text': $val = stripslashes(str_replace('`', "\n", $val)); break;
	  case 'field': $val = $par["disp"].": $val"; break;	
	  }
	}
	return $val;
  } 
} 

function FrmPage($page) {
  global $WorkDir, $pagename;
  $page = str_replace ('/', ".", $page); 
  if (is_file("$WorkDir/$page")) return "$WorkDir/$page.val";
  else {
    $pos = strpos($pagename,'.');
    $page = substr($pagename, 0, $pos).".$page";
	if (is_file("$WorkDir/$page")) return "$WorkDir/$page.val";
	else return FALSE;
  }
}

function posttoh($url, $data){
  global $BFrmRdPar; // to return error
 // Get parts of URL
  $url = parse_url($url);
  if (!$url) return FALSE;
  // Provide defaults for port and query string
  if (!isset($url['port'])) $url['port'] = '';
  if (!isset($url['query'])) $url['query'] = '';
  // Build POST string
  $encoded = '';
  foreach ($data as $k => $v) {
    if (get_magic_quotes_gpc()) $v = stripslashes($v);
    $encoded .= ($encoded ? '&' : '');
    $encoded .= rawurlencode($k).'='.rawurlencode($v);
  }
  // Open socket on host
  $fp = fsockopen($url['host'], $url['port'] ? $url['port'] : 80, $errno, $errstr, 30);
  if (!$fp) {
    $BFrmRdPar['msgerr']['value'] = "#{XL('Error')}:  $errno - $errstr";
	return FALSE;
  } else { //Send HTTP 1.0 POST request to host
  fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], 
    $url['query'] ? "?" : "", $url['query']));
  fputs($fp, "Host: {$url['host']}\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
  fputs($fp, "Content-length: ".strlen($encoded)."\n");
  fputs($fp, "Connection: close\n\n");
  fputs($fp, "$encoded\n");
/*  $line = "Received:\n";
  while(!feof($fp))
    $line .= fgets($fp, 1024);
  dbf($line); */
/*   
  // Read the first line of data, only accept if 200 OK is sent
  $line = fgets($fp, 1024);
  if (!eregi("^HTTP/1\\.. 200", $line)) return FALSE;
 
  // Put everything, except the headers to $results
  $results = '';
  $inheader = TRUE;
  while(!feof($fp)) {
    $line = fgets($fp, 1024);
    if ($inheader && ($line == "\n" || $line == "\r\n")) 
      $inheader = FALSE;
    elseif (!$inheader) 
      $results .= $line;
  } */
  fclose($fp);
  }
//  return $results;  // Return with data received
}

/*debug function
function dbf($par) {
	$fp = fopen('wiki.d/errorsform.txt', "a+b");
	fwrite($fp, "\n$par");
	fclose($fp);
}
*/