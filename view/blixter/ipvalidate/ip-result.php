<?php
namespace Anax\View;

$ipText = $isIpValid ? "<span class='text-success'>Godkänd</span>" : "<span class='text-danger'>Inte godkänd</span>";
?>
<div class="container">
<ul class="list-group">
    <li class="list-group-item bg-info"><p class="h3"><strong>Resultat av <?= htmlentities($ipaddress)?></strong></p></li>
    <li class="list-group-item"><p><strong>Validering:</strong><?= " "  .  $ipText ?></p></li>
    <li class="list-group-item"><p><strong>Protokoll:</strong> <?= $protocol ?? "-" ?></p></li>
    <li class="list-group-item"><p><strong>Domän:</strong> <?= $domain ?? "-" ?></p></li>
</ul>

<p><a href="">Validera en ny ip-adress</a></p>
</div>