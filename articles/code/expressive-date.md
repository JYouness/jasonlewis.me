@title Expressive Date

Expressive Date is a fluent extension to PHPs `DateTime` class.

### Installation

#### Composer

Add Expressive Date to your `composer.json` file.

~~~~
"jasonlewis/expressive-date": "1.*"
~~~~

Run `composer update` or `composer install` to get the latest version of the package.

#### Manually

It's recommended that you use Composer, however you can download and install from the [GitHub repository](http://github.com/jasonlewis/expressive-date).

#### Laravel 4

Expressive Date is dead simple to drop into a Laravel 4 application as a service provider is shipped. Follow the Composer installation steps above by adding Expressive Date to your Laravel 4 application's `composer.json`. Once you've run `composer update` you'll need to register the service provider.

Open `app/config/app.php` and find the `providers` key. Add `ExpressiveDateServiceProvider` to the array.

You can get an instance of Expressive Date through the applications container.

~~~~
$date = App::make('date');

// Or if you have access to an instance of the application.
$date = $app['date'];
~~~~

You can also use the other instance methods described below.

### Usage

Expressive Date is an extension to PHPs [DateTime](http://www.php.net/manual/en/class.datetime.php) class. This means that if you can't do something with Expressive Date you still have the flexibility of `DateTime` at your disposal.

#### Getting Instances

Before you can begin working with dates you'll need to get an instance of `ExpressiveDate`. You have two options available to you.

~~~~
// Instantiate a new instance of ExpressiveDate.
$date = new ExpressiveDate;

// Use the static make method to get an instance of ExpressiveDate.
$date = ExpressiveDate::make();
~~~~

Both of these methods accepts two parameters, a time string and a timezone. This is identical to the `DateTime` constructor except the second parameters timezone does not need to be an intance of `DateTimeZone`.

~~~~
// Pass a valid timezone as the second parameter.
$date = new ExpressiveDate(null, 'Australia/Melbourne');

// You can still use a DateTimeZone instance.
$timezone = new DateTimeZone('Australia/Melbourne');

$date = new ExpressiveDate(null, $timezone);
~~~~

#### Quick Helpers

There are a couple of quick helper methods available to you when using Expressive Date.

~~~~
$date = new ExpressiveDate;

$date->today(); // Sets to todays date, e.g., 1991-01-31 00:00:00

$date->tomorrow(); // Sets to tomorrows date, e.g., 1991-02-01 00:00:00

$date->yesterday(); // Sets to yesterdays date, e.g., 1991-01-30 00:00:00
~~~

As you can see these helpers will also set the time to midnight.

#### Manipulating the Date and Time

When working with dates you'll often want to manipulate it in a number of ways. Expressive Date eases this process with a dead simple syntax.

~~~~
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

$date->addOneDay(); // December 2, 2012 12:00:00 PM
$date->addDays(10); // December 12, 2012 12:00:00 PM
$date->minusOneDay(); // December 11, 2012 12:00:00 PM
$date->minusDays(10); // December 1, 2012 12:00:00 PM

$date->addOneWeek(); // December 8, 2012 12:00:00 PM
$date->addWeeks(10); // February 16, 2013, at 12:00:00 PM
$date->minusOneWeek(); // February 9, 2013 12:00:00 PM
$date->minusWeeks(10); // December 1, 2012 12:00:00 PM

$date->addOneMonth(); // January 1, 2013 12:00:00 PM
$date->addMonths(10); // November 1, 2013 12:00:00 PM
$date->minusOneMonth(); // October 1, 2013 12:00:00 PM
$date->minusMonths(10); // December 1, 2012 12:00:00 PM

$date->addOneYear(); // December 1, 2013 12:00:00 PM
$date->addYears(10); // December 1, 2023 12:00:00 PM
$date->minusOneYear(); // December 1, 2022 12:00:00 PM
$date->minusYears(10); // December 1, 2012 12:00:00 PM

$date->addOneHour(); // December 1, 2012 1:00:00 PM
$date->addHours(10); // December 1, 2012 11:00:00 PM
$date->minusOneHour(); // December 1, 2012 10:00:00 PM
$date->minusHours(10); // December 1, 2012 12:00:00 PM

$date->addOneMinute(); // December 1, 2012 12:01:00 PM
$date->addMinutes(10); // December 1, 2012 12:11:00 PM
$date->minusOneMinute(); // December 1, 2012 12:10:00 PM
$date->minusMinutes(10); // December 1, 2012 12:00:00 PM

$date->addOneSecond(); // December 1, 2012 12:00:01 PM
$date->addSeconds(10); // December 1, 2012 12:00:11 PM
$date->minusOneSecond(); // December 1, 2012 12:00:10 PM
$date->minusSeconds(10); // December 1, 2012 12:00:00 PM
~~~~

You can also set the unit manually using one of the setters.

~~~~
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

$date->setDay(31); // December 31, 2012 12:00:00 PM
$date->setMonth(1); // January 31, 2012 12:00:00 PM
$date->setYear(1991); // January 31, 1991 12:00:00 PM
$date->setHour(6); // January 31, 1991 6:00:00 AM
$date->setMinute(30); // January 31, 1991 6:30:00 AM
$date->setSecond(53); // January 31, 1991 6:30:53 AM
~~~~

There are also several methods to quick jump to the start or end of a day or month.

~~~~
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

$date->startOfDay(); // December 1, 2012 12:00:00 AM
$date->endOfDay(); // December 1, 2012 11:59:59 PM

$date->startOfMonth(); // December 1, 2012 12:00:00 AM
$date->endOfMonth(); // December 31, 2012 11:59:59 PM
~~~~

Lastly you can set the timestamp directly or set it from a string.

~~~~
$date = new ExpressiveDate;

$date->setTimestamp(time()); // Set the timestamp to the current time.
$date->setTimestampFromString('31 January 1991'); // Set timestamp from a string.
~~~~

#### Differences in Dates and Times

Getting the difference between two dates is very easy with Expressive Date. Let's see how long it's been since my birthday which was on the January 31st, 1991.

~~~~
$date = new ExpressiveDate('January 31, 1991');
$now = new ExpressiveDate('December 1, 2012');

$date->getDifferenceInYears($now); // 21
$date->getDifferenceInMonths($now); // 262
$date->getDifferenceInDays($now); // 7975
$date->getDifferenceInHours($now); // 191400
$date->getDifferenceInMinutes($now); // 11484000
$date->getDifferenceInSeconds($now); // 689040000
~~~~

Wow, I'm over 689040000 seconds old!

In the above example I'm explicitly passing in another instance to compare against. You don't have to, by default it'll use the current date and time.

~~~~
$date = new ExpressiveDate('January 31, 1991');

$date->getDifferenceInYears(); // Will use the current date and time to get the difference.
~~~~

#### Working with Timezones

It's always important to factor in timezones when working with dates and times. Because Expressive Date uses PHPs `DateTime` class it'll default to using the date defined with `date_default_timezone_set()`.

If you need to you can manipulate the timezone on the fly.

~~~~
$date = new ExpressiveDate;

$date->setTimezone('Australia/Darwin');

// Or use an instance of DateTimeZone.
$timezone = new DateTimeZone('Australia/Darwin');

$date->setTimezone($timezone);
~~~~

You can also get an instance of PHPs `DateTimeZone` if you need it for other manipulations.

~~~~
$date = new ExpressiveDate;

$timezone = $date->getTimezone();
~~~~

Or you can just get the name of the timezone.

~~~~
$date = new ExpressiveDate;

$timezone = $date->getTimezoneName(); // Australia/Melbourne
~~~~

#### Working with Dates and Times

Now that you have manipulated your date and time it's time for you to actually work with it.

~~~~
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM', 'Australia/Melbourne');

$date->getDay(); // 1
$date->getMonth(); // 12
$date->getYear(); // 2012
$date->getHour(); // 14
$date->getMinute(); // 30
$date->getSecond(); // 50
$date->getDayOfWeek(); // Saturday
$date->getDayOfWeekAsNumeric(); // 6
$date->getDaysInMonth(); // 31
$date->getDayOfYear(); // 335
$date->getDaySuffix(); // st
$date->getGmtDifference(); // +1100
$date->getSecondsSinceEpoch(); // 1354320000
$date->isLeapYear(); // true
$date->isAmOrPm(); // PM
$date->isDaylightSavings(); // true
$date->isWeekday(); // false
$date->isWeekend(); // true
~~~~

#### Formatting Dates and Times

It's now time to display your date and time to everyone. Expressive Date comes with a couple of predefined formatting methods for your convenience.

~~~~
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM', 'Australia/Melbourne');

$date->getDateString(); // 2012-12-01
$date->getDateTimeString(); // 2012-12-01 14:30:50
$date->getShortDateString(); // Dec 1, 2012
$date->getLongDateString(); // December 1st, 2012 at 2:30pm
$date->getTimeString(); // 14:30:50

// You can still define your own formats.
$date->format('jS F, Y'); // 31st January, 2012
~~~~

Expressive Date also comes with a human readable or relative date method.

~~~~
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM', 'Australia/Melbourne');

$date->getRelativeDate(); // Would show something similar to: 4 days ago
~~~~

You can also pass in an instance of Expressive Date to compare against.

~~~~
$now = new ExpressiveDate('December 1, 2012 2:30:50 PM', 'Australia/Melbourne');
$future = new ExpressiveDate('December 9, 2012 7:45:32 AM', 'Australia/Melbourne');

$now->getRelativeDate($future); // 1 week from now
~~~~

### License

Expressive Date is licensed under the 2-clause BSD, see the `LICENSE` file for more details.

### Changelog

#### 1.0.0

- Initial release