@title Basset

Basset is a Better Asset Management package for Laravel. It easily allows you to manage all of your styles and scripts within your application.

### Features

- Group your assets into neat collections.
- Compile and serve static assets within your production environment.
- Maintain code debugging with tools like Firebug within your development environment.
- Apply filters using the powerful Assetic package.

### Requirements

- Laravel 4
- Depends on Assetic
- PHP 5.3+

### Installation

In your Laravel 4 application add `jasonlewis/basset` as a requirement.

~~~~
"basset/basset": "1.*"
~~~~

Update your packages with `composer update`.

You can now use Basset to manage your assets.

### Configuration

Basset's configuration file can be extended by creating `app/config/basset.php`. The default configuration file can be found at `vendor/jasonlewis/basset/src/defaults.php`. Any keys that you use in your own configuration file will be used instead of the default.

Remember to change any directories or set the name of your production environment so Basset will know when to serve your static assets.

### Asset Collections

Collections can be defined within Basset itself at `vendor/jasonlewis/basset/src/collections.php` or within your `app/config/basset.php` configuration file under the `collections` key.

*Currently there is no `app/start.php` available, however you can use `app/routes.php` to register collections.*

There are a number of methods available to you when defining a collection. The easiest way is with `Basset\Collection::add()`, which will look for the file within the directories given in the configuration.

~~~~
Basset::collection('website', function($collection)
{
    $collection->add('main.css');
});
~~~~

With the default configuration Basset would first look in `app/assets/css` for `main.css` and then in `app/assets/js`.

#### Requiring a Directory

Basset is able to require every valid asset within a given directory. `Basset\Collection::requireDirectory()` takes an optional parameter, which can be the name of a directory defined in the configuration or an absolute path prefixed with `path: `.

~~~~
Basset::collection('website', function($collection)
{
    // Use the name of a directory defined in the configuration file.
    $collection->requireDirectory('css');

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
    // Use the name of a directory defined in the configuration file.
    $collection->requireTree('css');

    // Use the absolute path to a directory.
    $collection->requireTree('path: /path/to/directory');
    
});
~~~~

#### Working Within a Directory

You can change the directory you are working in with Basset by using the `Basset\Collection::directory()` method.

~~~~
Basset::collection('website', function($collection)
{
    $collection->directory('css', function($collection)
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

#### Except and Only

There may be times when you want to require a directory or tree except for a couple of assets.

~~~~
Basset::collection('website', function($collection)
{
    // Exclude the admin.css file.
    $collection->requireDirectory('css')->except('admin.css');

    // Exclude a number of admin related files.
    $collection->requireDirectory('css')->except(array('admin.css', 'admin-tables.css'));
    
});
~~~~

The same can be applied to only use a couple of assets.

~~~~
Basset::collection('website', function($collection)
{
    // Include only the admin.css file.
    $collection->requireDirectory('css')->only('admin.css');

    // Include only a number of admin related files.
    $collection->requireDirectory('css')->only(array('admin.css', 'admin-tables.css'));
    
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
    $collection->requireDirectory('css')->apply('CssMinFilter');

    // Apply a filter to the example.css and pass an array of options.
    $collection->add('example.css')->apply('LessFilter', array('/path/to/node');
});
~~~~

*For a complete rundown on the available filters see the [Assetic documentation](https://github.com/kriswallsmith/assetic#filters).*

#### Named Filters

Filters can also be named to quickly apply them on multiple collections. Named filters are defined under the `filters` key in the configuration. Here's an example of a named filter.

~~~~
'filters' => array(
    'Less' => 'LessFilter'
)
~~~~

If you need to adjust some options for the filter you can define it as an array, the key becomes the filters class name and the value is an array of options.

~~~~
'filters' => array(
    'Less' => array(
        'LessFilter' => array('/path/to/node')
    )
)
~~~~

Filters can then be applied by using its name.

~~~~
Basset::collection('website', function($collection)
{
    // Apply a named filter to the example.css file.
    $collection->add('example.css')->apply('Less');
});
~~~~

### Compiling Collections

Collections can be compiled and stored as static assets to leverage browser caching. Static assets are fingerprinted with an MD5 of the last modified time of each asset. This allows the browsers cache to be *busted* when you re-compile a collection.

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

Basset uses environments to detect what kind of assets to serve. When in development Basset will serve assets as individual files. This allows you to continue to use tools like Firebug to browse styles and scripts and correctly debug errors.

*Filters are not applied to assets when serving them individually.*

When Basset detects that is within the production environment it will attempt to serve static assets generated via the command line. If it cannot find the static assets it will gracefully degrade to serving individual assets.

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