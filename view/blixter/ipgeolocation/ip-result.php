<?php
namespace Anax\View;

if (file_exists(ANAX_INSTALL_PATH . "/config/keys.php")) {
    $keys = require ANAX_INSTALL_PATH . "/config/keys.php";
} else {
    // Lägg till test apikey
    $keys = require ANAX_INSTALL_PATH . "/config/keys_sample.php";
}
$apiKey = $keys["mapBoxApiKey"];
$longitude = $apiRes["longitude"] ?? null;
$latitude = $apiRes["latitude"] ?? null;
?>
<?php
$ipText = $isIpValid ? "<span class='text-success'>Godkänd</span>" : "<span class='text-danger'>Inte godkänd</span>";
?>
<div class="container">
<ul class="list-group">
    <li class="list-group-item bg-info">
        <p class="h3">
            <strong>
                Resultat av <?=htmlentities($ipaddress)?>
            </strong>
        </p>
    </li>
    <li class="list-group-item">
            <p>
                <strong>Validering:</strong><?=" " . $ipText?>
            </p>
        </li>
    <li class="list-group-item">
        <p>
            <strong>Protokoll:</strong> <?=$protocol ?? "-"?>
        </p>
    </li>
    <li class="list-group-item">
        <p>
            <strong>Domän:</strong> <?=$domain ?? "-"?>
        </p>
    </li>
    <li class="list-group-item">
        <p>
            <strong>Land:</strong> <?=$apiRes["country_name"] ?? "-"?>
        </p>
    </li>
    <li class="list-group-item">
        <p>
            <strong>Stad:</strong> <?=$apiRes["city"] ?? "-"?>
        </p>
    </li>
    <li class="list-group-item">
        <p>
            <strong>Latitude:</strong> <?=$latitude ?? "-"?>
        </p>
    </li>
    <li class="list-group-item">
        <p>
            <strong>Longitude:</strong> <?=$longitude ?? "-"?>
        </p>
    </li>

</ul>

<?php if ($latitude) {
    ?>   <div id="mapid" style="height:300px; margin-top: 2rem"></div>
    <?php require 'map.php';?>

    <script type="text/javascript">
    var apiKey = "<?php echo "$apiKey" ?>";
    var longitude = "<?php echo "$longitude" ?>";
    var latitude = "<?php echo "$latitude" ?>";
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

<p><a href="">Geolokalisera en ny ip-adress</a></p>