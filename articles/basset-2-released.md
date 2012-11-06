@title  Basset 2 Released
@author Jason Lewis
@date   Thu Jun 28 2012 14:53:57 +1100
@intro	No

It's been a while since I've rolled out a somewhat decent release of Basset. Once again I've got some new and exciting changes for everyone. There have been numerous bug fixes and a lot of refactoring. I think this is the greatest version of Basset yet. Let's have a quick look at what's new.

### New in Basset 2

- **Changing Routes:** Yes! You can finally change your routes throughout your application. Need an asset added or removed at a specific point, easy! Let's take a look.
    
    ~~~~
    // File: application/start.php
    Bundle::start('basset');
    
    Basset::scripts('website', function($basset)
    {
        $basset->add('jquery', 'jquery.js')
               ->add('random', 'random.js');
    });
    ~~~~
    
    Then in a view composer or controller you can modify the route by defining it again.
    
    ~~~~
    Basset::scripts('website', function($basset)
    {
        $basset->add('register', 'register.js')
               ->delete('random');
    });
    ~~~~
- **Shared Assets:** You can now share assets that are used commonly throughout your different Basset routes.
    
    ~~~~
    Basset::share('jquery', 'jquery.js');
    
    Basset::scripts('website', function($basset)
    {
        $basset->add('jquery')
               ->add('random', 'random.js');
    });
    ~~~~
- **Events:** Basset now fires an event for each asset that is compiled in the form of: `basset.<route>: <file>`
    
    ~~~~
    Event::listen('basset.website: random.js', function($contents)
    {
        return 'This will replace the contents.';
    });
    ~~~~
- **Basset::show() method:** A helper for generating the URIs to your assets without you having to worry about what Basset handles.
    
    ~~~~
    {{ Basset::show('website.js') }}
    ~~~~

Once again I hope everyone will upgrade to the latest version. Remember to backup your configuration files and route files first!

If you come across any bugs please report them to the [GitHub issue tracker](http://github.com/jasonlewis/basset/issues) so I can deal with them as soon as possible.

Thanks to all those that have been contributing and offering great ideas.