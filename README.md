# Google Geocode Wrapper
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

## Installation
This package has been tested on Laravel 5.4 and up.

You can install the package via composer:

```
composer require rentloop/google-geo-code
```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider and facade in config/app.php file:

```php
'providers' => [
    // ...
    Rentloop\GoogleGeoCode\GoogleGeoCodeServiceProvider::class,
];

'aliases' => [
    // ...
    'Lookup' => Rentloop\GoogleGeoCode\Facades\Lookup::class,
];
```

## Usage
Using the lookup is very simple. All you need to provide is the address, city and state (for better accuracy). You will then be returned an array of data about that location from google.

Include the Lookup class in your file.
```php
use Rentloop\GoogleGeoCode\Lookup;
```

Initiate the class and then call the locate method.
```php
$lookup = new Lookup;
$lookup->locate('1901 W Madison St', 'Chicago', 'IL');
```

Your response should look similar to this
```
[
  "formatted_address" => "1901 W Madison St, Chicago, IL 60612, USA"
  "place_id" => "ChIJTeP2tz4tDogRADDUGhbXDB8"
  "neighborhood" => "Near West Side"
  "address" => "1901 West Madison Street"
  "city" => "Chicago"
  "state" => "Illinois"
  "postal_code" => "60612"
  "county" => "Cook County"
  "country" => "United States"
  "lat" => 41.8806285
  "lng" => -87.6740482
]
```

### Methods
There is just 1 method that you can use, which is `locate`. It accepts 3 parameters, the first being the only required parameter.

| Parameter | Required | Description |
| --------- |:--------:| ----------- |
| address   | true     | The address of the location you want to gather data on. It can be anything and Google will attempt to find it. |
| city      | false    | For better accuracy, you can add a city to the address by adding it here. |
| state     | false    | For better accuracy, you can add a state to the address by adding it here. |
