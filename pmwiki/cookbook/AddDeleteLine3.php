<?php

$AdlVersion = '3.2017-06-07';
$RecipeInfo['AddDeleteLine3']['Version'] = '3.2017-06-07'; 

/*
   Adds markup to add lines using a form and delete lines from a wiki page.

   Copyright 2005-2008 Nils Knappmeier (nk@knappi.org)
             2017      Peter Kay (pkay42@gmail.com)

   Permission is hereby granted, free of charge, to any person obtaining 
   a copy of this software and associated documentation files (the 
   "Software"), to deal in the Software without restriction, including 
   without limitation the rights to use, copy, modify, merge, publish, 
   distribute, sublicense, and/or sell copies of the Software, and to 
   permit persons to whom the Software is furnished to do so, subject to 
   the following conditions:

   The above copyright notice and this permission notice shall be 
   included in all copies or substantial portions of the Software.

   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
   NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS 
   BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN 
   ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
   CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE 
   SOFTWARE.

   
   Contributors:
   
   * Original code, versions 1 and 2: Nils Knappmeier
   * Code review (using htmlentities instead of urlencode) and some of the code
     for processing {name[]} markup in the template by Martin Fick (2006)
   * Version 3: Peter Kay (2017)


   Version 2.0unstable5: Support for (:adl deletelink:) directive by Petko Yotov (2006)
   Version 2.0.3: Declared stable after a year of no changes.
   Version 3 20170607: Updated to newest pmwiki
   
 */



# Utility function to facilitate debugging
function AdlInspect($variable="") {
    Header('Content-type: text/plain');
    if ($variable=="") {
        print_r($GLOBALS);
    } else {
        print_r($variable);
    }
    exit;
}

Markup('AddDeleteLine', 'directives', '/\(:adl (\w+)\s*(.*?):\)/', 'AdlMarkup');

function AdlMarkup($M) {
    extract($GLOBALS["MarkupToHTML"]); // to get $pagename
    
    static $InForm=false;  # (to avoid delete forms inside adl forms)
    if ($M[1]==="form") { // (:adl form     (target=...)?:)
        $InForm=true;
        if (preg_match('/(.*?) target=(.*)/', $M[2], $m)) {
            return Keep(AdlFormMarkup($m[2], $m[1]));
        } else {
            return Keep(AdlFormMarkup($pagename, $M[2]));
        }
    }
    if ($M[1]==="delete" || $M[1]==="delrange") {
        // Can't nest forms.  We PRR() so error messages get translated
        if ($InForm) return PRR("\$[ERROR]: \$[AddDeleteLine prepend or append is inside form.  Automatic Deletion disabled.]");
        if (preg_match('/(\w+) (.*)/', $M[2], $m)) {
            return Keep(AdlDeleteMarkup($m[1], $m[2]));
        }
        return Keep($M[0]); # fail
    }
    if ($M[1]==="deletelink") {
        if (preg_match('/(\w+) (.*)/', $M[2], $m)) {
            return Keep(AdlDeleteMarkup($m[1], $m[2], true));
        }
        return Keep($M[0]); # fail
    }
    if ($M[1]==="end" && $M[2]==="") {
        $InForm=false;
        return Keep('</form>');
    }
    if ($M[1]==="version") return Keep($GLOBALS['AdlVersion']);
    // otherwise fail
    return Keep($M[0]);
}

// Templates must run early
# The pattern matches (:adl template "stuff":) or 'stuff' or stuff
#   if quotes are used, they may be included if escaped by backslashes "st\"ff".
#   Backslashes may be escaped too, if a template needs to end in \" for whatever reason.
Markup('AdlTemplate','<[=','/\(:adl template (?J:"(?P<tem>(?>[^"\\\\]|\\\\\\\\|\\\\"|\\\\)*?)"|\'(?P<tem>(?>[^\'\\\\]|\\\\\\\\|\\\\\'|\\\\)*?)\'|(?P<tem>.*?)):\)/',#<? #so my old vim does syntax highlighting correctly ><
       function ($m) {return AdlTemplateMarkup(preg_replace('/\\\\([\'"\\\\])/', '$1', $m['tem']));}
       );
Markup('AdlTemplatePage', '<[=','/\(:adl templatepage\s+(\S.*?):\)/', 'AdlTemplatePageMarkup');
// So should prepend and append; they just vanish as markup.  They are needed for editing 
//    later in the handler function AdlHandleAddLine
// If it's the only thing on a line (and it should be), remove the entire line:
Markup('AdlEntryLocation', '>[=', '/(\n)?\(:adl (?:pre|ap)pend .*?:\)(\n)?/s', 
       function ($m) {if ($m[1]!="" && $m[2]!="") return "\n"; return '';}
       );

# Markup for the #adl begin# and #adl end# marks. These marks should vansih as early as possible in the markup processing
# in order to allow markup like "! Header" to be processed (which needs the stand at the beginning of the line.
#   These are used for adl deleterange
Markup('adlentrybegin','_begin','/#adl (begin|end)( \w+)?#/','');


# Creates the HTML code for the (:adl form:) directive
function AdlFormMarkup($targetname,$adlname) {
    extract($GLOBALS["MarkupToHTML"]); // for $pagename

    $targetname = MakeLink($pagename,$targetname,NULL,'','$FullName');

    return FmtPageName("<form action='{\$PageUrl}' method='post'>
                        <input type='hidden' value='$targetname' name='n'/>
                        <input type='hidden' value='$adlname' name='adlname'/>
                        <input type='hidden' value='addline' name='action'/>",$targetname);
}





SDV($HTMLStylesFmt['AddDeleteLine3'],'
.adldeletebutton {
   display: inline;
}
.adldeletebutton input {
   font-size: 80%;
}
');


# Creates the HTML code for delete buttons (:adl delete:) and (:adl delrange:)
function AdlDeleteMarkup($key='dummy',$targetpagename="",$deletelink=false) {
    if ($targetpagename=="") {
        $targetpagename = $GLOBALS['MarkupToHTML']['pagename'];
    }
    if(!$deletelink) {
        return FmtPageName("<form class='adldeletebutton' action='{\$PageUrl}' method='post'>
            <input type='hidden' name='n' value='$targetpagename'>
            <input type='hidden' name='action' value='deleteline'>
            <input type='hidden' name='adllinekey' value='$key'>
            <input type='submit' name='doit' value='$[Delete]'>
            </form>",$targetpagename);
    } else {
        return FmtPageName("<a onclick='if(confirm(\"$[Really delete this line?]\")) self.open(\"{\$PageUrl}?n=$targetpagename&amp;action=deleteline&amp;adllinekey=$key\", \"_self\")' href='javascript:void(0);' rel='nofollow'>$[Delete]</a>",$targetpagename);
    }
}


# Creates the HTML code for (:adl template:)
#   the hidden form field name is adltemplate
# $template is the page template
function AdlTemplateMarkup($template) {
    return Keep('<input type="hidden" name="adltemplate" value="'.PHSC($template, ENT_QUOTES).'"/>');
}

# Creates the HTML code for (:adl templatepage <$m[1]=pagename>:)
function AdlTemplatePageMarkup($m) {
    $pagename=$GLOBALS['MarkupToHTML']['pagename'];
    $templatepage=MakePageName($pagename, $m[1]);
    return Keep('<input type="hidden" name="adltemplatepage" value="'.$templatepage.'"/>');
}



# Posts the text to the current page (calls the edit handler)
function AdlPost($text) {
    global $HandleActions, $pagename;

    $_POST['text']=get_magic_quotes_gpc()?addslashes($text):$text;
    $handle = $HandleActions['edit'];
    $_POST['post']='Save ';
    return $handle($pagename);
}


# Delete one line from the wiki page
$HandleActions['deleteline']='AdlHandleDeleteLine';
function AdlHandleDeleteLine($pagename) {
    $page = RetrieveAuthPage($pagename,"edit", true);
    if (!$page) Abort("?cannot read $pagename");

    if(isset($_POST['adllinekey'])) $key = stripmagic($_POST['adllinekey']);  # Retrieve the line-key
    else $key = stripmagic($_GET['adllinekey']);

    $newtext = $page['text']."\n"; # Add a newline so the the following regexes also work for the last line.

    # Remove the line containing the delete statement with the provided line-key (if it exists)
    $newtext = preg_replace("/^.*\(:adl delete(link)? $key $pagename:\).*\\n/m","",$newtext);

    # Remove the range containing the delrange statement with the provided line-key (if it exists)
    $newtext = preg_replace('/#adl begin '.$key.'#.*?\(:adl delrange '.$key.' '.$pagename.':\).*?#adl end '.$key.'#\n/s',"",$newtext);

    # Remove the added newline character: This is either the newline we inserted, or the newline in front of the
    # line we removed. Or, if the text was only one line with no newline at all, it is now empty, which should not be a problem.
    chop($newtext);

    return AdlPost($newtext);
}


# Processes the $template and inserts the values of $fields[].
# $fields is an array that is filled into the template.  For example, if 
#     there is {pet} in the template, it will be filled with $fields['pet']
# $template is the template
# $linekeyseed is an optional parameter that allows the caller to specify a seed for the linekey
#     that is used to identify the range in the delete-action.
# $targetpagename an optional parameter that is name of the page, where the data is to be stored. This 
#     is mainly used in order to fill in the pagename into the (:adl del[ete|range]:) directives.
#
# The engine returns an array of filled templates each of which contains a string. If no markup of the 
# form {name[]} is present in the template, the array will contain exactly one entry, where the usual 
# text substitutions have been performed.
# If a {name[]} markup is present, $fields['name'] has to be an array. For each element of $fields['name'],
# one entry is found in the array, where all the other fields are replicated, but {name[]} is subsituted 
# by each element of $fields['name'].
# Typically, this will be by way of defining multile (:input text multiple[]:) markup in the form.
# More than one {name[]} may be defined
#
function AdlTemplateEngine($fields, $template,$linekeyseed=NULL,$targetpagename=NULL) {
    global $pagename;

    if ($targetpagename == NULL) { $targetpagename = $pagename; }
    
    $string = $template;
    # create the data to be added, from template and variables
    $string = preg_replace('/\\\\n/',"\n",$string);  # replace \n by newlines
    $string = preg_replace_callback('/\{([^[]*?)\}/',  # replace {name} fields
                                    function ($m) use ($fields) {return stripmagic($fields[$m[1]]);},
                                    $string);
    $string = preg_replace_callback('/\{date\:(.*?)\}/',  # replace {date:fmt}
                                    function ($m) {return date($m[1]);},
                                    $string);
    $string = preg_replace_callback('/\{strftime\:(.*?)\}/',  # replace {strftime:fmt}
                                     function ($m) {return strftime($m[1]);},
                                     $string);
    $string=PHSC($string); // replace HTML Special Characters with equivalents (in case
                           // someone passed in weird strings to date() etc)

    // Handle {name[]} fields.
    $result=[]; # will have one element if $string contains no {name[]} fields
    $input=[$string];
    // Go through each input template.
    while (count($input) > 0) {
        $s=array_shift($input);
        //  If it has a {name[]} element, 
        if(preg_match('/\{(.+?)\[\]\}/', $s, $m)) {
            $name=$m[1];
            // find each possible value to plug into it from the $fields array (typically $_POST)
            //   Because we unshift them back into $new after processing, we go thru in reverse:
            foreach(array_reverse((array)$fields[$name]) as $val) {
                if ($val != "") {
                    $new=preg_replace("/\{$name\[\]\}/", stripmagic($val), $s);
                    // Then put it back in the queue in case there are multiple {othername[]} elements
                    array_unshift($input, $new);
                }
            }
        } else { // no {namefields[]} so we're done here
            $result[]=$s;
        }
    }
    
    // Delete links:
    # Create a unique linekeyseed, if necessary
    if ($linekeyseed==NULL) {
        $linekeyseed=time().'a'.rand(0,100000);
    }
    foreach ($result as $index => $entry) {
        $linekey = $linekeyseed.'b'.$index;
        $entry = str_replace('(:adl delete:)',"(:adl delete $linekey $targetpagename:)",$entry);  # Add linekey to delete statements
        $entry = str_replace('(:adl deletelink:)',"(:adl deletelink $linekey $targetpagename:)",$entry);  # for link-delete
        $entry = str_replace('(:adl delrange:)',"(:adl delrange $linekey $targetpagename:)",$entry);  # Add linekey to delete statements
        $entry = str_replace('#adl begin#',"#adl begin $linekey#",$entry);  # Add line-key to delete statements
        $entry = str_replace('#adl end#',"#adl end $linekey#",$entry);  # Add line-key to delete statements
        $result[$index] = $entry;
    }
    return $result;
}



# Insert text into the wiki page
$HandleActions['addline']='AdlHandleAddLine';
function AdlHandleAddLine($pagename) {
    global $HandleActions,$action,$ScriptUrl;

    $page = RetrieveAuthPage($pagename,"edit", true);
    if (!$page) { Abort("?cannot edit $pagename"); }

    if ($_POST['adltemplate']!="") {
        $newentries = AdlTemplateEngine($_POST,html_entity_decode(stripmagic($_POST['adltemplate'])));  # Decode the template
    } elseif ($_POST['adltemplatepage']!="") {
        $templatePageName=MakePageName($pagename, stripmagic($_POST['adltemplatepage']));
        $templatePage=RetrieveAuthPage($templatePageName, "read", true);
        if (PageExists($templatePageName)) {
            $newentries = AdlTemplateEngine($_POST, $templatePage['text']);
        } else { #fail ;_;
            Abort("AddDeleteLine: $[Template page does not exist]: $templatePageName");
        }
    } else { #fail ;_;
        Abort("AddDeleteLine: $[No template.]");
    }

    $addstring = join("\n",$newentries);
   

    # Handle the special names #top and #bottom
    if ($_POST['adlname'] == '#top') {
         return AdlPost($addstring."\n".$page['text']);
    }
    if ($_POST['adlname'] == '#bottom') {
        return AdlPost($page['text']."\n".$addstring);
    }

    # Handle locations specified by 'adl prepend' and 'adl append'
    $text = explode("\n",$page['text']);

    # Look for (:adl append:) statements and append the $
    $appendcmd='(:adl append '.stripmagic($_POST['adlname']).':)';
    foreach ($text as $nr => $line) {
        if ($line==$appendcmd) {
            $text[$nr]="$addstring\n$line";
        }
    }

    $prependcmd='(:adl prepend '.stripmagic($_POST['adlname']).':)';
    foreach ($text as $nr => $line) {
        if ($line==$prependcmd) {
            $text[$nr] = "$line\n$addstring";
        }
    }
    return AdlPost(implode("\n",$text));
}




# vi:shiftwidth=4:autoindent:softtabstop=4:expandtab:
?>
