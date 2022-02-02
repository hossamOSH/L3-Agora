<?php if (!defined('PmWiki')) exit();
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is distributed under the terms of the GNU General Public 
    License as published by the Free Software Foundation; either 
    version 2 of the License, or (at your option) any later version.  
/*---------------------------------------------------------------

  * Copyright *
  This PmWiki addon was written on March 20, 2004 by Steven Leite
  (steven_leite@kitimat.net).  The same terms and conditions that
  apply to PmWiki also apply to this script.
  
  Update: 
  I have modified the file on march 25, 2019 due to
  the needs of PHP_7.2 and HTML5.
  
  * Special Thanks *
  Thanks to Pm (Patrick Michaud, www.pmichaud.com), for creating
  PmWiki, and for sharing his knowledge and insightfulness which
  is what made this script possible.

  * Description *
  This add-on allows a PmWiki user to include the contents of any
  external webpage into their WikiPage.

  * Features *
  The script won't overwrite any existing configuration date in
  your PmWiki install.

  * Warning *
  Since there's no filtering of the imported content (yet), you
  should use caution if you use this script.  Users can include
  ANY external page in your Wiki.

  * Installation Instructions *
  1.  Save this file (includeSite.php) in the directory cookbook.
  3.  Add this one line to your config.php file:
      include_once("local/scripts/includeSite.php");

  * Usage Instructions *

  Example:  (:includeSite http://www.yahoo.com border=3 scroll="no":)
  or
  Example:  (:includeSite http://www.yahoo.com style="border: 2px dotted #447;" align=" scroll="yes":)


  Supported (optional) fields are:

    height = in pixels, just the number
    width = in pixels, just the number
    border = in pixels, just the number
    scrolling = "auto"/"yes"/"no"
    align = default/"left"/"right"/"middle"/"top"/"bottom"
    style = a string, that represents a valid CSS-Style as "border: 2px solid blue;"
    id = valid string
    
    strings may be enclosed in double quotes (") or single quotes ('),
    but should not enclose double quotes

  If the fields are not specified, the script defaults will be
  used.  You can set these defaults in the script or (better) in the file config.php.

  * History *
  March 08, 2005 - movement to pmwiki-2
  March 30, 2004 - Slight enhancement to the way the script
                   preserves the url in the <iframe> tag so that
  March 25, 2019   changes due to the needs of PHP_7.2,
                   aditional parameters 'style' and 'id',
                   'border' could be used for backward compatibility 
                   but should not in new installation, use 'style' instead.
                   
                   rearangement of the evaluation of the parameters
                   
  March 28, 2019   changed handling of the parameter 'id' depending of it's existence
*/
SDV($RecipeInfo['includeSite']['Version'], '2019-03-28');
$FmtPV['$includeSiteVersion'] = "'{$RecipeInfo["includeSite"]["Version"]}'";


SDV($DefaultWidth, '600');        // pixels
SDV($DefaultHeight,'400');        // pixels
SDV($DefaultAlign, 'left');       // left, right, middle, top, bottom
SDV($DefaultScroll,'auto');       // auto, yes, no
SDV($DefaultStyle, 'border:3px outset #aaa; ');

function includeSite($m) {    #  [modified for PHP5.5 and younger]
  global $DefaultWidth, $DefaultHeight, $DefaultAlign, $DefaultScroll;
  global $DefaultStyle, $UrlExcludeChars; // no longer a $DefaultBorder
  // $m -> an array with the matches
  // $m[0] -> the whole match /between '(:includeSite' and ':)'
  // $m[1] -> subgroup 1 : the url
  // $m[2] -> subgroup 2 : the parameters

  // valid values for scroling and align
  $scroll_vals = ['no','yes', 'auto'];
  $align_vals = ['left', 'right', 'middle', 'top' ,'bottom'];
  
  // parse the parameters
  $pattern = '/(id|align|width|height|scroll|style|border)=((\\d+)|(["\'])(.*?)\4)/'; 
  $results = preg_match_all($pattern,$m[2],$match,PREG_SET_ORDER);

  foreach ($match as $part) {
      switch (substr($part[0],0,2)) {
          case 'id':        # id
            $id     = $part[5];
          break;
          case 'wi':        # width
            $width  = $part[3];
          break;
          case 'he':        # height
            $height = $part[3];
          break;
          case 'sc':        # scroll
            $scroll = $part[5];
            if (!in_array($scroll,$scroll_vals)) {
                $scroll = 'auto';
            }
          break;
          case 'st':        # style
            $style = $part[5];
          break;
          case 'bo':        # border
            $border = $part[3];
            $replace_me = "border: ".$border."$2";
            $style = preg_replace("/.*?(\\d+)(px .*)/", $replace_me, $DefaultStyle);
          break;
          case 'al':
            $align = $part[5];
            if (!in_array($align,$align_vals)){
                $align = "left";
            }
          break;
      }
  }
  
  // Set defaults for parameters not specified
  SDV($width, $DefaultWidth);
  SDV($height, $DefaultHeight);
  SDV($align, $DefaultAlign);
  SDV($scroll, $DefaultScroll);
  SDV($style, $DefaultStyle);

  $Output .= "\n\n<!-- X-include -->\n\n";
  if ($id=="") {  
      $Output .= "</pre><iframe width=\"$width\" height=\"$height\" align=\"$align\" style=\"$style\"  scrolling=\"$scroll\" src=\"" . Keep($m[1])."\"></iframe><pre>";   #  [modified for PHP5.5 and younger]
  }else{
      $Output .= "</pre><iframe id=\"$id\" width=\"$width\" height=\"$height\" align=\"$align\" style=\"$style\"  scrolling=\"$scroll\" src=\"" . Keep($m[1])."\"></iframe><pre>";   #  [modified for PHP5.5 and younger]
}
  $Output .= "\n\n<!-- /X-include -->\n\n";
  return $Output;
} // end of function includeSite($m)  

#### fit for PHP5.5 and higher (even PHP7.x)
$iSpattern = "/\\(:includeSite\\s+(https?:[^$UrlExcludeChars]*?)\\s+(.*):\\)/";
Markup('includeSite', 'directives', $iSpattern, "includeSite");



