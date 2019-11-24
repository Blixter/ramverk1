<?php
namespace Anax\View;

$keys = require ANAX_INSTALL_PATH . "/config/keys.php";
$apiKey = $keys["mapBoxApiKey"];

if ($coords) {
    $longitude = $coords["lon"] ?? null;
    $latitude = $coords["lat"] ?? null;
    ?>

<script src="js/skycons.js"></script>
<script>var icons = new Skycons({"monochrome": false});</script>

<?php
/**
     * Template file to render a view for geolocate an ip address.
     */

    ?>

<div style="margin-bottom: 2rem;">
<?php if ($coords) {
        ?>   <div id="mapid" style="height:300px; margin-top: 2rem"></div>
    <?php require 'map.php';?>

    <script>
    var apiKey = "<?="$apiKey"?>";
    var longitude = "<?="$longitude"?>";
    var latitude = "<?="$latitude"?>";
    var mymap = L.map('mapid').setView([latitude, longitude], 13);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: apiKey
    }).addTo(mymap);
    var marker = L.marker([latitude, longitude]).addTo(mymap);
    </script>
<?php
}
    ?>
</div>

<?php $i = 0;?>
    <?php foreach ((array) $weatherData as $rows): ?>
    <script>var i = <?=$i;?>;</script>
    <div class="column col3">
        <div class="card text-center" style="height: 360px; margin-bottom: 1rem;">
            <div class="card-body">
                <h4 class="card-title"><?=$rows['date'];?></h5>
                <script>
                var iconName = "<?=$rows['icon'];?>";
                </script>
                <canvas id="<?=$rows['icon'] . $i;?>" width="100" height="100"></canvas>
                <div style="height: 100px;">
                <p class="card-text"><?=$rows['summary'];?></p>
                </div>
                <div class="container">
                    <div class="d-flex justify-content-between">
                        <div style="font-size: large"><?=$rows['temperatureMax'];?>°C</div>
                        <div></div>
                        <div style="font-size: large"><?=$rows['temperatureMin'];?>°C</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    icons.set(iconName+i, iconName);
    icons.play();
</script>
<?php $i++;?>
<?php endforeach;?>
<?php
} else {
    ?><p>Ip-adressen eller platsen är inte giltlig, <a href="">försök igen!</a></p>
    <?php
}