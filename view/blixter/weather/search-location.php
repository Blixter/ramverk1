<?php
namespace Anax\View;

/**
 * Template file to render a view for geolocate an ip address.
 */

?>
<div class="container">
<p>Här kan du söka på stad, land, address eller ip-adress och få en väderrapport.</p>
    <form method="post" class="form-row">
    <div class="form-group mx-sm-3 mb-2">
        <label for="location" class="sr-only">Plats</label>
    <input
        type="text"
        name="location"
        placeholder="Ange en plats eller ip-adress..."
        class="form-control"
        required
    >
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <div class="form-check">
            <label class="form-check-label">
                <input
                    type="radio"
                    class="form-check-input"
                    value="past"
                    name="radiochoice"
                    required
                >Månaden som varit
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input
                    type="radio"
                    class="form-check-input"
                    value="upcoming"
                    name="radiochoice"
                    required
                >Kommande vecka
            </label>
        </div>
    </div>
        <button type="submit" class ="btn btn-primary mb-2">Få väderprognos</button>
    </form>
</div>

<?php require 'json-api.php';?>
