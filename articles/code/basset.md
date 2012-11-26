@title Basset

Basset is a Better Asset Management package for Laravel. It easily allows you to manage all of your styles and scripts within your application.

*Please note that the following guide is intended for the Laravel 4 version of Basset. The bundle for Laravel 3 is going to undergo some drastic changes to be brought in line with the Laravel 4 version.*

### Features

- Group your assets into neat collections.
- Compile and serve static assets within your production environment.
- Maintain code debugging with tools like Firebug within your development environment.
- Apply filters using the powerful Assetic package.

### Requirements

- Laravel 4
- Assetic
- PHP 5.3+

### Installation

In your Laravel 4 application add `jasonlewis/basset` as a requirement.

~~~~
"jasonlewis/basset": "3.*"
~~~~

Update your packages with `composer update` or install with `composer install`.

Once Composer has installed or updated your packages you need to register Basset with Laravel itself. Open up `app/config/app.php` and find the `providers` key towards the bottom.

~~~~
'Basset\BassetServiceProvider'
~~~~

Next you need to alias Basset's facade. Find the `aliases` key which should be below the `providers` key.

~~~~
'Basset' => 'Basset\Facades\Basset'
~~~~

To confirm that Basset is indeed working correctly you can use your terminal.

~~~~
$ php artisan basset
~~~~

You should get the Basset version displayed within your terminal. You're now ready to begin using Basset!

### Configuration

Basset's configuration file can be extended by creating `app/config/packages/jasonlewis/basset.php`. You can find the default configuration file at `vendor/jasonlewis/basset/src/basset.php`. Any keys that you use within your own configuration file will overwrite the defaults. This means you don't have to copy the entire file, but only replace the keys you want to change.

Remember to update your directories or set your production environment.

You can quickly publish a configuration file by running the following Artisan command.

~~~~
$ php artisan config:publish jasonlewis/basset
~~~~

This will copy the configuration file to `app/config/packages/jasonlewis/basset.php`.

### Asset Collections

Collections can be defined just about anywhere. The best place to put your collections is somewhere that's included from both the web and the command line.

Collections can be defined in your `app/config/packages/jasonlewis/basset.php` configuration file under the `collections` key. See the default configuration file for more information.

You can also define collections in the `app/start/global.php` file or include another file within that global start file. This start file is included during the startup process by both the web and command line.

There are a number of methods available to you when defining a collection. The easiest way is with `Basset\Collection::add()`.

~~~~
Basset::collection('website', function($collection)
{
    $collection->add('main.css');

    $collection->add('path: path/to/main.css');
});
~~~~

This method will add a file in a variety of ways. First it checks to see if you've prefixed the file with `path: `. This allows you to provide a full path to the file, wherever it may be.

Next it will look for the file within the public directory. So it would look for `/example/application/public/main.css`. Finally it will spin through each of the directories defined within your configuration file and search for the `main.css` file.

#### Requiring a Directory

Basset is able to require every valid asset within a given directory. `Basset\Collection::requireDirectory()` takes an optional parameter, which can be the name of a directory defined in the configuration or an absolute path prefixed with `path: `.

~~~~
Basset::collection('website', function($collection)
{
    // Use a directory within the public directory.
    $collection->requireTree('assets/css');

    // Use the name of a directory defined in the configuration file.
    $collection->requireDirectory('name: css');

    // Use the absolute path to a directory.
    $collection->requireDirectory('path: /path/to/directory');
    
});
~~~~

*If the directory contains both styles and scripts then both will be added to the collection.*

#### Requiring a Tree

Basset is also able to recursively iterate through an entire directory tree to add valid assets. As with requiring a directory the `Basset\Collection::requireTree()` takes an optional parameter for the directory to require.

~~~~
Basset::collection('website', function($collection)
{
    // Use a directory within the public directory.
    $collection->requireTree('assets/css');

    // Use the name of a directory defined in the configuration file.
    $collection->requireTree('name: css');

    // Use the absolute path to a directory.
    $collection->requireTree('path: /path/to/directory');
    
});
~~~~

#### Working Within a Directory

You can change the directory you are working in with Basset by using the `Basset\Collection::directory()` method.

~~~~
Basset::collection('website', function($collection)
{
    $collection->directory('assets/css', function($collection)
    {
        // Add the example.css file within the directory named css.
        $collection->add('example.css');

        // Require the current working directory.
        $collection->requireDirectory();

        // Require the current working tree.
        $collection->requireTree();
    });    
});
~~~~

You can also use the `name: ` and `path: ` prefixes here as previously shown.

#### Except and Only

There may be times when you want to require a directory or tree except for a couple of assets.

~~~~
Basset::collection('website', function($collection)
{
    // Exclude the admin.css file.
    $collection->requireDirectory('assets/css')->except('admin.css');

    // Exclude a number of admin related files.
    $collection->requireDirectory('assets/css')->except(array('admin.css', 'admin-tables.css'));
    
});
~~~~

The same can be applied to only use a couple of assets.

~~~~
Basset::collection('website', function($collection)
{
    // Include only the admin.css file.
    $collection->requireDirectory('assets/css')->only('admin.css');

    // Include only a number of admin related files.
    $collection->requireDirectory('assets/css')->only(array('admin.css', 'admin-tables.css'));
    
});
~~~~

### Asset Filters

Filters are used to alter your assets in a number of different ways. To give you a huge amount of flexibility, Basset uses [Assetic's](http://github.com/kriswallsmith/assetic) filter classes. Filters can be applied to an individual asset or a directory of assets.

~~~~
Basset::collection('website', function($collection)
{
    // Apply a filter to the example.css file.
    $collection->add('example.css')->apply('CssMinFilter');

    // Apply a filter to a directory.
    $collection->requireDirectory('assets/css')->apply('CssMinFilter');

    // Apply a filter to the example.css and pass an array of options.
    $collection->add('example.css')->apply('LessFilter', array('/path/to/node');
});
~~~~

Filters can also be applied to the entire collection. Just remember what assets are in your collection, as some filters are style or script specific and you may run into problems using a filter on an unsupported asset.

~~~~
// Apply a filter to an entire collection.
Basset::collection('website', function($collection)
{
    $collection->requireDirectory('assets/css')
})->apply('CssMinFilter');
~~~~

*For a complete rundown on the available filters see the [Assetic documentation](https://github.com/kriswallsmith/assetic#filters).*

Basset does come bundled with a few extra filters found at `vendor/jasonlewis/basset/src/Basset/Filter`. Read more about [Basset's Filters](http://jasonlewis.me/code/basset/filters)

#### Named Filters

Filters can also be named to quickly apply them on multiple collections. Named filters are defined under the `filters` key in the configuration. Here's an example of a named filter.

~~~~
'filters' => array(
    'UriRewrite' => 'UriRewriteFilter'
)
~~~~

If you need to adjust some options for the filter you can define it as an array, the key becomes the filters class name and the value is an array of options.

~~~~
'filters' => array(
    'UriRewrite' => array(
        'UriRewriteFilter' => array('/path/to/document/root')
    )
)
~~~~

Filters can then be applied by using its name.

~~~~
Basset::collection('website', function($collection)
{
    // Apply a named filter to the example.css file.
    $collection->add('example.css')->apply('UriRewrite');
});
~~~~

### Compiling Collections

Collections can be compiled and stored as static assets to leverage browser caching. Static assets are fingerprinted with an MD5 of the last modified time of each asset. This allows the browsers cache to be *busted* when you re-compile a collection after making changes.

To compile a collection you need access to the command line. In your terminal you can view the help for compiling a collection.

~~~~
$ php artisan basset:compile --help
Usage:
 basset:compile [-f|--force] [collection]

Arguments:
 collection   The asset collection to compile

Options:
 --force (-f) Forces a re-compile of the collection
~~~~

If you don't give Basset a collection to compile then all collections that can be found will be compiled. The result of compiling a collection will be similar to the following.

~~~~
$ php artisan basset:compile website

Gathering assets for collection...
Successfully compiled website-2fc9c5d37f9b809d1732cebb791bb351.css

Done!
~~~~

Compiling all collections might give a result similar to the following.

~~~~
$ php artisan basset:compile

Gathering collections to compile...
Successfully compiled foo-89949e2c102d16026687a8ffca8e3241.css
The styles for the collection 'website' do not need to be compiled.
The styles for the collection 'admin' do not need to be compiled.

Done!
~~~~

If Basset detects that no changes have been made to the assets of a collection then it won't re-compile them. If, for whatever reason, you need to re-compile a collection use the `-f` or `--force` switch.

~~~~
$ php artisan basset:compile website --force

Gathering assets for collection...
Successfully compiled website-2fc9c5d37f9b809d1732cebb791bb351.css

Done!
~~~~

### Environment Detection

Basset uses environments to detect what kind of assets to serve. When in development Basset will serve assets as individual files. These assets should be within your public directory so that Basset can serve them correctly. This allows you to continue to use tools like Firebug to browse styles and scripts and correctly debug errors.

*Filters are not applied to assets when serving them individually.*

When Basset detects that it is within the production environment it will attempt to serve static assets generated via the command line. If it cannot find the static assets it will gracefully degrade to serving individual assets.

The `production_environment` configuration key is used to help Basset determine if it’s within the production environment.

| **Setting** | **Description**                                                                   |
|-------------|-----------------------------------------------------------------------------------|
| actual      | Use name of your production environment so Basset doesn't have to guess.          |
| `true`      | Basset will always serve static assets (if available), regardless of environment. |
| `false`     | Basset will always serve assets individually, regardless of environment.          |
| `null`      | Allow Basset to automatically determine if within production environment.         |

If set to `null` Basset will check if your environment is either `production` or `prod`. If you'd prefer to define the environment yourself you're free to do so.

### Using Assets in Views

To use your asset collections in a view you use the `Basset::show()` method. This method accepts a single parameter which is the name of the collection. It's also important to give the collection an extension of either `css` or `js`. This allows Basset to link to either the scripts or the styles for that particular collection.

~~~~
{{ Basset::show('website.css') }}
~~~~

The assets shown will depend on the environment that Basset detects along with the availability of any static assets.

### Command Line

Basset makes use of the command line to publish assets as well as provide information about collections. To get a list of available collections you can use the `basset:list` command.

~~~~
$ php artisan basset:list
~~~~

You should receive a list of all your available collections and the status of the scripts and styles of that collection.

~~~~
basic:
   Styles:  Uncompiled or needs re-compiling
   Scripts: None available
~~~~

You can get the version of Basset by running `php artisan basset`. The current version will be displayed.