@title  Basset 1.3 Released
@author Jason Lewis
@date   Thu Apr 12 2012 11:58:02 +1100

I'm proud to announce the latest release of my Laravel bundle, Basset! Basset 1.3 brings a whole new range of features and makes Basset a pleasure to work with. Basset is a Better Asset manager for the Laravel PHP framework. Basset allows you to generate asset routes which can be compressed and cached to maximize website performance.

### New in Basset 1.3

- **Directories:** Define a directory for a collection of assets to make updating asset locations a breeze, and saving yourself some typing.

    ~~~~
    Basset::styles('website', function($basset)
    {
        $basset->directory('public/assets/styles', function($basset)
        {
            $basset->add('website', 'website.css')
                   ->add('forms', 'forms.css')
                   ->add('links', 'links.css')
                   ->add('misc', 'misc.css');
        });
    });
    ~~~~

- **Compiling:** You can now tell Basset to only recompile assets when there have been changes. That way your server isn't working overtime recompiling your assets every page load. This is great for development environments.
- **LESS:** Prefer writing Less? Basset now supports LESS stylesheets once more. Simply enable the LESS PHP compiler in the configuration and begin using your LESS stylesheets.

As well as new features Basset also packs a couple of bug fixes and code enhancements. I'd strongly recommend anyone that is using it to upgrade to the latest.

Check out the [Basset homepage](http://jasonlewis.me/code/basset) for a detailed guide on using the features.