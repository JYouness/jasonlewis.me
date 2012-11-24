@title Basset Filters

Bundles with Basset are some filters that can be used on your assets.

### UriRewriteFilter
The `Basset\Filter\UriRewriteFilter` is similar in nature to Assetic's `Assetic\Filter\CssRewriteFilter`. Basset's `UriRewriteFilter` is based on the [Minify UriRewriter](https://github.com/mrclay/minify/blob/master/min/lib/Minify/CSS/UriRewriter.php) class. As such I strongly recommend using this over Assetic's `CssRewriteFilter`.

#### Usage
This filter accepts one parameter which should be the path to your public directory or document root.

~~~~
$collection->add('example.css')->apply('UriRewriteFilter', array('/path/to/public'));
~~~~

If using this filter numerous times it may be easier to name this filter in `app/config/packages/jasonlewis/basset.php`.

~~~~
'filters' => array(
    'UriRewrite' => array(
        'UriRewriteFilter' => array('/path/to/public')
    )
)
~~~~