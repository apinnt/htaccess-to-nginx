<?php

/* 
 * Author: Alan Pinnt
 * Creation: Initially created November 2018
 * Name: Apache htaccess to nginx rules. 
 * License: MIT License
 * 
 * What you need to know:
 * Pretty simple to edit and work with. The $block part is all your rules. Must have only one space between each argument.
 * Please note, this code is probably my worst. I needed it to solve a problem quick. Didn't have time to clean it up. If you're bored and want to, be my guest. 
 * This works for me as its only used on a dev server and never reaches the web.
 */

$block = 'RewriteRule ^stuff/$ /someotherplaces.php [L,R=301,NE]
RewriteRule ^blag/blag/glddds$ https://mysite.com/stufstufff.com [L,R=301,NE]';

print addcslashes($block);
//print $block;

///clean block
$block = preg_replace( "/\r|\n/", "", $block);

$block = str_replace("RewriteRule","",$block);
$block = str_replace("^","",$block);
$block = str_replace("$","",$block);
$block = str_replace("[L,R=301,NE]","",$block);
$block = str_replace("(.*)","",$block);
$block = str_replace(" [L]","",$block);

////rewrite rules
$exploded = explode(" ",$block);
//print_r ($exploded);

$buildArray=array();
$count=0;
$counter=0;
foreach ($exploded as $key => $value) {
    //if not blank - print
    if ($value!='' && $value!=' ') {
    //count 2 so it makes the right stuff
    ++$count;
    if ($count=='1') {
        $buildArray[$counter]=$value;
        $final=$final.'rewrite ^/'.$value.'$ ';
    } elseif($count=='2') {
            ///if they have http in value, make a 301 redirect
//            if (strpos($value, 'http') !== FALSE) {
//                $buildArray[$counter.'-2']='return 301 '.$value;
//                $final=$final.'return 301 '.$value.';}';
//                $final=$final.' <br />';
//            } else {
                $buildArray[$counter.'-2']=$value;
                $final=$final.'/'.$value.'/ permanent;';
                $final=$final.' <br />';
//            }
        $count=0;
        ++$counter;
    }

    }
}

print $final;
print '<br /><br /><br /><br />';

////location rules
$exploded2 = explode(" ",$block);
//print_r ($exploded);

$buildArray2=array();
$count2=0;
$counter2=0;
foreach ($exploded2 as $key2 => $value2) {
    //if not blank - print
    if ($value2!='' && $value2!=' ') {
    //count 2 so it makes the right stuff
    ++$count2;
    if ($count2=='1') {
        $buildArray2[$counter2]=$value2;
        $final2=$final2.'location /'.$value2.' ';
    } elseif($count2=='2') {
            ///if they have http in value, make a 301 redirect
//            if (strpos($value, 'http') !== FALSE) {
//                $buildArray[$counter.'-2']='return 301 '.$value;
//                $final=$final.'return 301 '.$value.';}';
//                $final=$final.' <br />';
//            } else {
                $buildArray2[$counter2.'-2']=$value2;
                $final2=$final2.' {try_files $uri $uri/ /'.$value2.';}';
                $final2=$final2.' <br />';
//            }
        $count2=0;
        ++$counter2;
    }

    }
}

print $final2;

