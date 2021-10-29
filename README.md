# ArgCalendar for Laravel
... with Alpine Js and Bootstrap 5

## Installation & Configuration

1. Install the package via composer. (The package will automatically register its service provider.)
```
composer require mergesoft/arg-calendar
```

2. Publish config file and configure your calendar. (output: config/arg-calendar.php)
```
php artisan vendor:publish --provider="MergeSoft\CalendarServiceProvider" --tag="config"
```
3. Publish translation file. (output: resources/lang/**\<lang-code\>**/arg-calendar.php) <br>
   The command below publishes english translations. You can replace '**en**' with another language code. But first check [translation files](https://github.com/mergehez/arg-laravel-calendar/tree/master/src/translations) folder for other available languages. If the language you are looking for does not exist there, then you can simply copy a random file to requested language's folder and modify translations. (It'd make me really happy, if you make a pull request with the new translation or send it to me via email)
```
php artisan vendor:publish --provider="MergeSoft\CalendarServiceProvider" --tag="lang.en"
```

## Usage
Add bootstrap 5 and alpine js to the head tag:
```html
<head>
    <!-- other -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- other -->
</head>
```

... and with the following definition, you get a wonderful calendar ui :)

```html
<x-arg-calendar form-action="book.php" 
                :bookings="$bookings" />
```
## Booking Model
| Property | Type |
|----------|------|
| year     | int  |
| month     | int  |
| day     | int  |
| ranges     | array of bools  |

**Important:** The length of **ranges** array depends on the "options" in the configuration. If there are 4 *distinct* hours in there, then the length must be 3. Assume 'options' is set like this: 

```php
// ...
'options' => [
    "8-13"  => "forenoon",
    "8-18"  => "day",
    "8-24"  => "day_evening",
    "13-18" => "afternoon",
    "13-24" => "afternoon_evening",
    "18-24" => "evening"
  ],
  // ...
```

There are 4 different hours here : 8-13-18-24 <br>
This means that there are 3 ranges: 8-13, 13-18 and 18-24 <br>
The **ranges** array has to be like \[true, false, true\] (you can use 0 and 1 as well)

## Screenshot

![image](https://user-images.githubusercontent.com/16548877/139498437-3f8bf6f0-d687-4984-b2b7-f9dab194d1c6.png)


### ---
```
The rest of readme is coming soon...
```
