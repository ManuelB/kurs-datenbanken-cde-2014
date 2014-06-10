<h1>tagesschau article scraper v0.1beta</h1>
<br>
Zählt auch, wie oft Merkel im Nachrichtentext vorkommt.
<br>
<?php
set_time_limit(180);
include('nils-glueck-simple_html_dom.php');


function checkURLexistence($url_string,$con) {
    $query = 'SELECT 1 FROM tagesschau_artikel WHERE url = ?';
    if(!$stmt = $con->prepare($query))
        return true;

    $stmt2 = $stmt->bind_param('s',$url_string);
    if(!$stmt3 = $stmt->execute())
        return true;
    $result = $stmt->get_result();

  #  var_dump($result);

  #  echo gettype($result->num_rows);

    if($result->num_rows > 0){
    echo "URL ist bereits vorhanden";
    return true;
    }
        

    return false;
}









$connection = new mysqli('localhost', 'root', '', 'nils-glueck');

echo '<br><br>STEP0001';



$html = file_get_html('http://www.tagesschau.de/xml/rss2');
$find_guids = $html->find('guid');

echo '<br><br>STEP0002';


#var_dump($find_guids);

#echo gettype($find_guids);

if (!is_array($find_guids)) {
    echo '<br><br>ERROR 0001';
    exit;
}
echo '<br><br>STEP0003';




foreach ($find_guids as $k => $v) {
    $v=$v->plaintext;

    if(!preg_match('/^http:\/\/www\.tagesschau\.de\//', $v) OR checkURLexistence($v,$connection) === true){
        echo '<br><br>CONTINUED;';
        var_dump($v);
        echo 'Helge';
        continue;
    }

    $cur_guid_html = file_get_html($v);
    $cur_guid_headline = $cur_guid_html->find('p[class^="dachzeile"]')[0]->plaintext . ' - '
        . $cur_guid_html->find('h3[class^="headline"]')[0]->plaintext;
    $cur_guid_maintext = $cur_guid_html->find('div.box')[0]->plaintext;
    if (!is_string($cur_guid_headline) OR !is_string($cur_guid_maintext)) {
        echo '<br><br>ERROR 0002';
        var_dump($v);
        continue;
    }
    $cur_guid_merkel_anzahl = substr_count( $cur_guid_maintext , 'Merkel');
    $cur_guid_jetzt = time();
    $cur_guid_query = 'INSERT INTO tagesschau_artikel (scrape_time,url,headline,maintext,merkel_anzahl) VALUES (?,?,?,?,?)';
    $stmt = $connection->prepare($cur_guid_query);
    if (!$stmt) {
        echo '<br><br>ERROR 0003';
        exit;
    }
    $stmt2 = $stmt->bind_param('isssi', $cur_guid_jetzt, $v, $cur_guid_headline, $cur_guid_maintext, $cur_guid_merkel_anzahl);
    if (!$stmt2) {
        echo '<br><br>ERROR 0004';
        exit;
    }
    $stmt3 = $stmt->execute();
    if (!$stmt3) {
        echo '<br><br>ERROR 0005';
        exit;
    }
}
$connection->close();







#-----------------------------------------------------------------------
#$fopen_con = fopen( "http://www.spiegel.de/", "r" );


# http://www.php.net/manual/de/function.file-get-contents.php


#file_get_contents("http://www.tagesschau.de/");


# http://stackoverflow.com/questions/5140258/increase-php-script-execution-time
# http://simplehtmldom.sourceforge.net/manual.htm
# http://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php

# include_simple_htmlparser
# XML-Feed holen
# URL auslesen
# Überschrift,Artikeltext auslesen
# Kommt da Merkel drin vor?


/*
 * Tabelle:
 * id (primary,auto_increment)
 * scrape_date
 * url(unique)
 * Uueberschrift
 * artikeltext
 * merkel_vorkommnis
 * wordcount_artikeltext
 */


?>