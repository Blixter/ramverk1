<?php
namespace Anax\View;

/**
 * Template file to render a view for validateIp
 */

?>
<div class="container">
<p>Här kan du validera en ip-adress. Fyll i adressen och tryck på validera. 
    Du kommer även få fram information om protokoll och domän.</p>
    <form method="post" class="form-inline">
    <div class="form-group mx-sm-3 mb-2">
        <label for="ipaddress" class="sr-only">Ip Adress</label>
        <input type="text" name="ipaddress" class="form-control" placeholder="Ange en ip-adress..." required>
    </div>
        <button type="submit" class ="btn btn-primary mb-2">Validera</button>
    </form>

    <h1>JSON-API</h1>
    <p>Det är även möjligt att få svaret i JSON via ett API.</p>
    <p>GET-request till routen: <code>/iptojson?ip=[Ip-adress]</code></p>
    <p>Svaret blir då så här om man söker på ip-adressen <code>8.8.8.8</code></p></p>
<pre>
{
    "ipaddress": "8.8.8.8",
    "isIpValid": true,
    "protocol": "IPv4",
    "domain": "dns.google"
}
</pre>

<p>Klicka på knapparna för att testa validera via API:t.</p>
<form action=<?= url("iptojson") ?> method="get" class="form">
        <button type="submit" class="btn btn-success mb-2" name="ip" value="8.8.8.8">Validerar</button>
        <button type="submit" class="btn btn-danger mb-2" name="ip" value="201.923.1.123">Validerar inte</button>
</form>

<p>Här nedan är det möjligt att själv fylla i en ip-adress för valideringen och få svaret i JSON.</p>
<form method="get" action=<?= url("iptojson") ?> class="form-inline">
    <div class="form-group mx-sm-3 mb-2">
        <label for="ip" class="sr-only">Ip Adress</label>
        <input type="text" name="ip" class="form-control" placeholder="Ange en ip-adress..." required>
    </div>
        <button type="submit" class ="btn btn-primary mb-2">Validera</button>
    </form>
</div>
