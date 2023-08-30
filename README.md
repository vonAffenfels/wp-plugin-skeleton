# wp-plugin-skeleton
Skeleton for development of Wordpress plugins using the vAF Wordpress Framework

## Create a new plugin

To create a new plugin simply run `composer create-project vonaffenfels/wp-plugin-skeleton <new-plugin-slug>`.

Composer will install all required dependencies for you, ask you some questions about
your new plugin and will modifiy/create all necessary files for you.

## Vendor prefixing

To counter the dependancy conflict problem when using Wordpress plugins that have composer
dependencies, we decided to use a technic called "Vendor Prefixing".

Here we create a new namespace where all dependencies can live in.

Take a look at the file `src/Plugin.php` so see how it works.

While developing, you MUST NOT use the dependency inside the `vendor` directory but instead
use the dependency inside the `vendor_prefixed` directory. IDEs will normally show you
the namespace the required class is in. Make sure, that it is prefixed with the namespace
you selected when creating the new plugin.

Best way to make sure you only used the dependencies inside the `vendor_prefixed` directory,
is to run the command `composer install --no-dev` after every install. That way all packages
will get removed and will not be found by any IDE.

When you install a new package you MUST require it as a development dependency by
running `composer require --dev <package>`.

If you need a development dependency that should not be included in the final plugin package,
simply add a new line to the file `scoper.inc.php` where you mark that packages as ignored.
It will then not be prefixed.

## Packaging/Deployment

You MUST always commit the cached dependency injection container (which can be found
in directory `container`).

To build the container before committing/packaging, simply run `composer build-container`.
The container will then be updated to the current state.

If you want to deploy your plugin using `composer` (like in a Bedrock Wordpress environment)
you don't have to do anything special.

If you want to deploy your plugin as ZIP file to use in standard Wordpress installations,
run the command `composer install --no-dev` to remove all packages from `vendor` directory.
Then you can ZIP the complete plugin. And don't forget to include the `vendor` directory.
It contains the necessary autoloader files.

## Container building

To rebuild the dependency injection container, simply run `composer build-container`.