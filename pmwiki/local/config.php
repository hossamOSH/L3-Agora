<?php if (!defined('PmWiki')) exit();
$WikiLibDirs = array(&$WikiDir,new PageStore('$FarmD/xeslib.d/{$FullName}'),new PageStore('$FarmD/wikilib.d/{$FullName}'));
include_once("$FarmD/cookbook/fontsizer.php");
include_once('cookbook/recipecheck.php');
include_once("$FarmD/scripts/authuser.php");
include_once("cookbook/includeSite.php");
include_once("cookbook/AddDeleteLine3.php");
include_once("$FarmD/cookbook/fox/fox.php");
include_once("$FarmD/cookbook/httpvariables.php");
include_once("$FarmD/cookbook/pmform.php"); 
$WikiTitle = "My New Wiki";
$PageLogoUrl = "http://example.com/mylogo.gif";

# Uncomment and correct these if PmWiki fails to detect the browser-reachable URLs
#$ScriptUrl = 'http://example.com/pmwiki/pmwiki.php';
#$PubDirUrl = 'http://example.com/pmwiki/pub';
    # require valid login before viewing pages
    $PmForm['reference'] = 'subject="Email from '.$WikiTitle.'" mailto=yourname@example.com form=#yourform fmt=#yourformpost from=myname@myexample.com'; 
    $PmForm['savedata'] = 'saveto={$FullName} form=#dataform fmt=#datapost';  
$DefaultPasswords['admin'] = pmcrypt('pass'); 
$DefaultPasswords['edit'] = pmcrypt('edit'); 
$DefaultPasswords['read'] = pmcrypt('read');

foreach ($_GET as $k=>$v) 
$InputValues[$k] = htmlspecialchars($v);


$EnableLinkPlusTitlespaced=1;
$SpaceWikiWords = 1;
//$EnableUpload = 1;
$EnableGUIButtons = 1;
//$DefaultPasswords['upload'] = pmcrypt('secrettwo');

# Uncomment and change these if your server is not in your timezone
# date_default_timezone_set('France/Paris'); # if you run PHP 5.1 or newer
# putenv("TZ=EST5EDT"); # if you run PHP 5.0 or older

$TimeFmt = '%B %d, %Y, at %I:%M %p %Z';

$MarkupExpr['sum'] = 'array_sum($args)';


$HandleActions['myaction'] = 'HandleMyAction';  # if url contains action=myaction call HandleMyAction timely
$HandleAuth['myaction'] = 'admin';              # authorization level $auth for HandleMyAction

function HandleMyAction($pagename, $auth) {     # parameters (signature) of handler function required by PMWiki
  global $Author;                               # get hold of current author name, e.g. for page history
  $old = RetrieveAuthPage('Main.Accueil', $auth);   # get all information from page MyGroup.MyOtherPage
  $new = $old;                                  # copy the page information to stay (e.g. page history)
  $new['text'] = "x".$old['text'];              # ... some manipulation of the old wiki mark-up
  $Author='myactionbot';                        # author name to appear in the page history for this manipulation 
  $pn='Main.Accueil';                    # need to call UpdatePage with variables (by reference) only
  UpdatePage($pn,$old,$new);                    # alter the actual wiki page
  HandleBrowse($pagename);                      # display the page specified in the url (e.g. MyGroup.MyPage)
}
