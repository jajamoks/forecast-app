# Forecast
This is a SPA used to display the DarkSky forecast.

## Lang
- PHP 7.2
- Npm 6.1
- Node 10.5

## Frameworks
- Laravel Mix 5.6
- Vue Js

## Components
- Vuex
- Vue Router
- Vue Carousel
- Vue Google Autocomplete (for geo location)
- Axios
- Bootstrap
- DarkSky API (Laravel vendor)

## How It Works
The front end of the site is using Vue Js to display 
the forecast with different Js components. 
To fetch the information, it will request using 
axios to a local API (same code) that will wrap the 
DarkSky vendor API adding a cache layer. This 
cache is based on Redis key/value caching by key = day 
and value = forecast of that day.
At the same time, for history or future forecast, we 
extended the DarkSky API to make concurrent requests 
for multiple dates forecasts.

We are not using models because it does not make 
sense to save all the information that it's 
already provided by DarkSky API. We are only caching the
locations requested (for current/future dates a few 
minutes and for history data 1 day)

## Set Up
1. Clone the code
2. Run `npm install`
3. Run `npm run production`
4. Install Redis `https://laravel.com/docs/5.6/redis`

  