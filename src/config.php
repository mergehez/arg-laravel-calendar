<?php

return [
  // Indicates whether booking function is enabled. 
  // TODO: implement the case when this is false
  'bookingEnabled' => true,

  // Indicates whether a time in the past can be booked
  'allowPast' => false,

  // Indicates whether if values in the 'options' array should act like translation keys
  'translateOptionKeys' => true,

  // Time range options for booking. 
  // Key constains start and end hours. 
  // Value is translation key if 'translateOptionKeys' is true, otherwise the value to be printed
  'options' => [
      "8-13"  => "forenoon",
      "8-18"  => "day",
      "8-24"  => "day_evening",
      "13-18" => "afternoon",
      "13-24" => "afternoon_evening",
      "18-24" => "evening"
    ],

  
  // If true, time spans for booking will get background colors. 
  'showOccupation' => true,
  'boxBackColorWhenNoOccupation' => null,

  // Background color for occupied time spans
  'occupiedBackColor' => 'var(--bs-danger)',
  // Background color for free time spans
  'freeBackColor' => 'var(--bs-success)',
  // Opacity for background colors
  'backColorOpacity' => 0.15,

  // Text color for today. Set to null, if you don't want to highlight
  'todayTextColor' => 'var(--bs-primary)',
  // Border radius for day boxes
  'boxBorderRadius' => '0.25rem',

  // Border color for the selected day
  'selectedBorderColor' => 'var(--bs-primary) !important',
  // Border width for the selected day
  'selectedBorderWidth' => '2px',
  // Border color for the hovered day. (css hover selector)
  'hoverBorderColor' => 'var(--bs-info)',
  // Border width for the hovered day. (css hover selector)
  'hoverBorderWidth' => '2px',

  // keys for laravel trans helper method (__('key') == trans('key'))
  'localizationKeys' => [
    'monthNames' => 'month_names',
    'monthNamesShort' => 'month_names_short',
    'dayNames' => 'day_names',
    'dayNamesShort' => 'day_names_short',
  ]
];
