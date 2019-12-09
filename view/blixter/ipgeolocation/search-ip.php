<?php
namespace Anax\View;

/**
 * Template file to render a view for geolocate an ip address.
 */

?>
<div class="container">
<p>Här kan du geolokalisera en ip-adress. Fyll i adressen och tryck på Geolokalisera.
    Du kommer även få fram information om protokoll och domän.</p>
    <form method="post" class="form-inline">
    <div class="form-group mx-sm-3 mb-2">
        <label for="ipaddress" class="sr-only">Ip Adress</label>
    <input
        type="text"
        name="ipaddress"
        placeholder="Ange en ip-adress..."
        value=<?=$userIp?>
        class="form-control"
        required
    >
    </div>
        <button type="submit" class ="btn btn-primary mb-2">Geolokalisera</button>
    </form>

    <?php require 'json-api.php';?>

</div>