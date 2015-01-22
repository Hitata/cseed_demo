<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';

function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}









$apikey    = isset($_POST["apikey"]) ? $_POST["apikey"] : "";
$location  = isset($_POST["location"]) && $_POST["location"] != "" ? $_POST["location"] : "51.5063,-0.1271";
$location  = trim(str_replace(" ",  "",  $location));
$cacheName = str_replace(array(".","/","\\",","),"",$location);
$cacheName = "cache" . DIRECTORY_SEPARATOR . $cacheName;
$cacheTime = 3600;







/*
 * Check API Key exists
 */
if (!$apikey || $apikey == "") {
    echo "<error><![CDATA[Weather Widget Error: No API Key provided! Obtain API Key from https://developers.forecast.io/]]></error>";
    die();
}











/*
 * If no cache directory, creatge one && return error on failure
 */
if (!is_dir("cache")) {
    if (!mkdir("cache", 0700)) {
        echo "<error>Weather Widget Error: Unable to create cache folder! Make sure PHP has write permissions!</error>";
        die();
    }
}











/*
 * If cache file is older than 1hr, store new file && return error on failure
 */
if (!file_exists($cacheName) || filemtime($cacheName) <= time() - $cacheTime) {
    $contents = file_get_contents_curl("https://api.forecast.io/forecast/$apikey/$location");
    
    if (!$contents) {
        $contents = "nodata";
    }
    
    if (!file_put_contents($cacheName, $contents)) {
        echo "<error>Weather Widget Error: Unable to store new data! Delete the cache folder and try again.</error>";
        die();
    }
}
$json = file_get_contents($cacheName);
$json = json_decode($json);











/*
 * Return error on no data
 */
if (!is_object($json) || !$json->currently || !$json->daily->data) {
    echo "<response>";
        echo "<error>nodata</error>";
        echo "<dump><![CDATA[";
            print_r($json);
        echo "]]></dump>";
    echo "</response>";
    die();
};

$current  = $json->currently;
$forecast = $json->daily->data;











ob_start(); ?>
<response>
    <location><![CDATA[<?php echo $json->latitude . ", " . $json->longitude; ?>]]></location>
    <current>
        <date><![CDATA[<?php echo date('l d m Y'); ?>]]></date>
        <time><![CDATA[<?php echo $current->time; ?>]]></time>
        <temperature>
            <f><![CDATA[<?php echo round($current->temperature); ?>]]></f>
            <c><![CDATA[<?php echo round((5/9)*($current->temperature-32)); ?>]]></c>
        </temperature>
        <icon><![CDATA[<?php echo $current->icon; ?>]]></icon>
    </current>

    <?php foreach ($forecast as $day) : ?>
            <day>
                <date><![CDATA[<?php echo date('d l', $day->time); ?>]]></date>
                <temperature>
                    <max>
                        <f><![CDATA[<?php echo round($day->temperatureMax); ?>]]></f>
                        <c><![CDATA[<?php echo round((5/9)*($day->temperatureMax-32)); ?>]]></c>
                    </max>
                    <min>
                        <f><![CDATA[<?php echo round($day->temperatureMin); ?>]]></f>
                        <c><![CDATA[<?php echo round((5/9)*($day->temperatureMin-32)); ?>]]></c>
                    </min>
                </temperature>
                <icon><![CDATA[<?php echo $day->icon; ?>]]></icon>
            </day>
    <?php endforeach; ?>
</response>
<?php ob_get_flush(); ?>