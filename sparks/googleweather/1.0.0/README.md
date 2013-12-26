# Google Weather API library for Codeigniter

With Google Weather library you can get current weather values and weather forecast of cities.
Good to know that this API is **undocumented**, but works and compared to other forecast services the returned values are correct.

## Installation

If you use this package in conventional way, then copy the files to their appropriate folders, and set up the config file.

    $gw_lang = 'en' // language
    $gw_temp = 'F'  // temperature: (C)elsius or (F)ahrenheit

Installing this package as spark:

    php tools/spark install -v1.0.0 googleweather

## Usage

Load the spark:

    $this->load->spark('googleweather/1.0.0');

Define the input parameters:

    $params = array('Hungary' => array('Budapest'));  

Adding multiple cities:

    $params = array('Hungary' => array('Budapest', 'Győr'));

Get the weather values:
    
    $result = $this->gweather->get_weather($params);

## Returned array

You'll have an array, with 
- information (city, date, unit system), 
- current weather values (condition, temperature, humidity, icon link, wind condition),
- weather forecast for next 4 days (day of week, lowest temp., highest temp., condition, icon link)

for all the cities (or city if you set one)

## Requirements

[cURL](http://getsparks.org/packages/curl) spark/library by Phil Sturgeon

## Notes

It's recommended to cache the return values not to overload google's server

## License

[MIT License](http://www.opensource.org/licenses/MIT)

C. 2012 Barna Szalai (sz.b@devartpro.com)