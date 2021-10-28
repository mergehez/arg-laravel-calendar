# ArgCalendar for Laravel
... with Alpine Js and Bootstrap 5

## Installation & setup

You can install the package via composer:

    composer require mergesoft/arg-calendar
    
The package will automatically register its service provider.

## Config Files

In order to edit the default configuration you may execute:

```
php artisan vendor:publish --provider="MergeSoft\CalendarServiceProvider" --tag="config" --force
```

After that, `config/arg-calendar.php` will be created.

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


... and with the following definition, you get a wonderful calendar ui..

```html
<x-arg-calendar form-action="book.php" 
                :bookings="$bookedDates" />
```




### ---
```
The rest of readme is coming soon...
```
