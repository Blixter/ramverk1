<?php
namespace Anax\View;
?>

<script src="js/skycons.js"></script>
<script>var icons = new Skycons({"monochrome": false});</script>

<?php
/**
 * Template file to render a view for geolocate an ip address.
 */




// array_shift($weatherData);
?>

<h1>Väderprognos</h1>   

<?php 
$i = 0;
foreach ($weatherData as $rows) {
    ?>
    <script>var i = <?php echo $i; ?>;</script>
    <div class="column col3">
        <div class="card text-center" style="height: 360px; margin-bottom: 1rem;">
            <div class="card-body">
                <h4 class="card-title"><?php echo $rows['date']; ?></h5>
                <script>
                var iconName = "<?php echo $rows['icon']; ?>";
                </script>
                <canvas id="<?php echo $rows['icon'] . $i; ?>" width="100" height="100"></canvas>
                <div style="height: 100px;">
                <p class="card-text"><?php echo $rows['summary']; ?></p>
                </div>
                <div class="container">
                    <div class="d-flex justify-content-between">
                        <div><?php echo $rows['temperatureMax']; ?>°C</div>
                        <div></div>
                        <div><?php echo $rows['temperatureMin']; ?>°C</div>
                    </div>
                </div>
        </div>
    </div>
    </div>
<script>
    icons.set(iconName+i, iconName);
    icons.play();
</script>
<?php $i++; ?>
<? }?>
