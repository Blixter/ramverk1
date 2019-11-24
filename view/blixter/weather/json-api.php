<?php
namespace Anax\View;

/**
 * Template file to render a view for geolocate an ip address.
 */
?>
    <h1>JSON-API</h1>
    <p>Det är även möjligt att få svaret i JSON via ett REST-API på följande vis:</p>
    <div class="p-2 mb-3 text-light border-left border-primary bg-darkish border-4">
        <p class="text-monospace" style="margin-top: 0; margin-bottom: 0;"><b>GET</b> /api/weather?location=[Plats/Ip-adress]</p>
    </div>
    <p>Resulterar:</p>
    <div class="p-2 mb-3 text-light border-left border-primary bg-darkish border-4">
       <pre class="text-light" style="overflow: hidden;">
{
  "weatherData": [
    {
      "date": "19-11-23",
      "summary": "Mulet under dagen.",
      "icon": "cloudy",
      "temperatureMin": 1.5,
      "temperatureMax": 4.31,
      "windSpeed": 1.95,
      "windGust": 4.57,
      "sunriseTime": 1574579040,
      "sunsetTime": 1574604480
    },
    {
      "date": "19-11-24",
      "summary": "Mulet under dagen.",
      "icon": "cloudy",
      "temperatureMin": 1.5,
      "temperatureMax": 4.24,
      "windSpeed": 1.58,
      "windGust": 4.65,
      "sunriseTime": 1574665560,
      "sunsetTime": 1574690760
    },
    {
      "date": "19-11-25",
      "summary": "Möjligtvis lite duggregn över natten.",
      "icon": "cloudy",
      "temperatureMin": 2.46,
      "temperatureMax": 5.25,
      "windSpeed": 1.95,
      "windGust": 7.19,
      "sunriseTime": 1574752080,
      "sunsetTime": 1574777100
    },
    {
      "date": "19-11-26",
      "summary": "Duggregn under dagen.",
      "icon": "rain",
      "temperatureMin": 3.31,
      "temperatureMax": 5.29,
      "windSpeed": 1.97,
      "windGust": 7.35,
      "sunriseTime": 1574838600,
      "sunsetTime": 1574863380
    },
    {
      "date": "19-11-27",
      "summary": "Regnskurar fram till kvällen.",
      "icon": "rain",
      "temperatureMin": -0.83,
      "temperatureMax": 4.38,
      "windSpeed": 4,
      "windGust": 12.11,
      "sunriseTime": 1574925120,
      "sunsetTime": 1574949720
    },
    {
      "date": "19-11-28",
      "summary": "Mulet under dagen.",
      "icon": "cloudy",
      "temperatureMin": -4.06,
      "temperatureMax": 0.69,
      "windSpeed": 4,
      "windGust": 11.83,
      "sunriseTime": 1575011640,
      "sunsetTime": 1575036060
    },
    {
      "date": "19-11-29",
      "summary": "Klart under dagen.",
      "icon": "clear-day",
      "temperatureMin": -5.11,
      "temperatureMax": -0.32,
      "windSpeed": 2.79,
      "windGust": 8.32,
      "sunriseTime": 1575098160,
      "sunsetTime": 1575122340
    }
  ]
}
</pre>
    </div>

    <p>Du kan ange en optionell parameter för att välja om du vill ha väderprognos för kommande vecka eller föregående månad.
    <div class="p-2 mb-2 text-light border-left border-primary bg-darkish border-4">
        <p class="text-monospace" style="margin-top: 0; margin-bottom: 0;"><b>GET</b> /api/weather?location=[Plats/Ip-adress]&period=[upcoming/past]</p>
    </div>

    <ul>
        <li><p>Välj <span class="text-light p-1 bg-darkish">period=upcoming</span> för att få prognos för kommande vecka. <b>Detta är default-värdet.</b><p></li>
        <li><p>Välj <span class="text-light p-1 bg-darkish">period=past</span> för att få prognos för föregående månad.<p></li>
    </ul>

<p>Här nedan är det möjligt att själv fylla i en plats eller ip-adress och få svaret i JSON.</p>
<form method="get" action=<?=url("api/weather")?> class="form-row">
    <div class="form-group mx-sm-3 mb-2">
        <label for="location" class="sr-only">Plats eller Ip-adress</label>
        <input
            type="text"
            name="location"
            class="form-control"
            placeholder="Ange en plats eller ip-adress..."
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
                    name="period"
                >Månaden som varit
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input
                    type="radio"
                    class="form-check-input"
                    value="upcoming"
                    name="period"
                >Kommande vecka
            </label>
        </div>
    </div>
        <button type="submit" class ="btn btn-primary mb-2">Få väderprognos</button>
    </form>