<?php
namespace Anax\View;

/**
 * Template file to render a view for geolocate an ip address.
 */
?>
    <h1>JSON-API</h1>
    <p>Det är även möjligt att få svaret i JSON via ett REST-API på följande vis:</p>
    <div class="container border-left border-primary bg-light">
        <p class="text-monospace">GET /api/iptogeo?ip=[Ip-adress]</p>
</div>

<p>Klicka på knappen för att testa geolokalisera ip-adressen
<span class="text-monospace bg-light">8.8.8.8</span> via API:t.</p>
<form action=<?=url("api/iptogeo")?> method="get" class="form">
        <button type="submit" class="btn btn-success mb-2" name="ip" value="8.8.8.8">Testa</button>
</form>

<p>Här nedan är det möjligt att själv fylla i en ip-adress för geolokalisering och få svaret i JSON.</p>
<form method="get" action=<?=url("api/iptogeo")?> class="form-inline">
    <div class="form-group mx-sm-3 mb-2">
        <label for="ip" class="sr-only">Ip Adress</label>
        <input
            type="text"
            name="ip"
            class="form-control"
            value=<?=$userIp?>
            placeholder="Ange en ip-adress..."
            required
        >
    </div>
        <button type="submit" class ="btn btn-primary mb-2">Geolokalisera</button>
    </form>