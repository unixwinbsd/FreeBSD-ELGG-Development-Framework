Elgg CLI
########

.. contents:: Contents
   :local:
   :depth: 1


elgg-cli command line tools
===========================

Depending on how you installed Elgg and your server configuration you can access``elgg-cli`` binaries as one of the following 
from the root of your Elgg installation:

.. code-block:: sh

    php ./elgg-cli list
    ./elgg-cli list
    php ./vendor/bin/elgg-cli list
    ./vendor/bin/elgg-cli list

.. note::

	Be advised that when using elgg-cli it might be needed to run the command as the same user as the webserver to prevent issues with rights related to files.

Available commands
==================

.. code-block:: sh

    cd /path/to/elgg/

    # Get help
    vendor/bin/elgg-cli --help

    # List all commands
    vendor/bin/elgg-cli list

    # Install Elgg
    # no-plugins: This is an optional argument, it'll prevent the activation of any plugins
    # config: (string) Path to php file that returns an array with installation configuration, if not provided the config parameters will be questioned in the console.
    vendor/bin/elgg-cli install [--no-plugins] [-c|--config CONFIG]

    # Seed the database with fake entities
    # limit: (int) number of items to seed (will be asked interactively for each seeder unless the -n/--no-interaction is used or only one type is seeded)
    # type: (string) only seed given entity type
    # create_since: (string) a compatible PHP date/time string to set the lower bound entity time created (eg, '-5 months')
    # create_until: (string) a compatible PHP date/time string to set the upper bound entity time created (eg, 'yesterday')
    # image_folder: (string) a folder where the seeder can find images to use as icons, etc.
    # create: This is an argument, it'll force the creation of entities instead of building up to the limit
    vendor/bin/elgg-cli database:seed [-l|--limit LIMIT] [-t|--type TYPE] [--create_since DATE/TIME] [--create_until DATE/TIME] [--image_folder FOLDER] [create]

    # List information about the seeded database content
    # this will show the available seeders to be used with the database:seed and database:unseed command and the currently seeded amounts
    vendor/bin/elgg-cli database:seeders

    # Remove seeded faked entities
    # type: (string) only unseed given entity type
    vendor/bin/elgg-cli database:unseed [-t|--type TYPE]

    # Optimize database tables
    # Requires garbagecollector plugin
    vendor/bin/elgg-cli database:optimize

    # Run cron jobs
    vendor/bin/elgg-cli cron [-i|--interval INTERVAL] [-q|--quiet]

    # Clear caches
    vendor/bin/elgg-cli cache:clear

    # Invalidate caches
    vendor/bin/elgg-cli cache:invalidate
    
    # Purge caches
    vendor/bin/elgg-cli cache:purge

    # System upgrade
    # -v|-vv|-vvv control verbosity of the command (helpful for debugging upgrade scripts)
    vendor/bin/elgg-cli upgrade [-v]

    # Upgrade and execute all async upgrades
    vendor/bin/elgg-cli upgrade async [-v]

    # List all upgrades
    vendor/bin/elgg-cli upgrade:list

    # Execute a specific upgrade
    # <upgrades>: a space separated list of upgrade classes to execute (see the upgrade:list command for a list)
    vendor/bin/elgg-cli upgrade:batch <upgrades>

    # List all, active or inactive plugins
    # STATUS = all | active | inactive
    vendor/bin/elgg-cli plugins:list [-s|--status STATUS]

    # Activate plugins
    # List plugin ids separating them with spaces: vendor/bin/elgg-cli plugins:activate activity blog
    # use -f flag to resolve conflicts and dependencies
    # you can set a plugin priority by using the format plugin_id:priority (eg. blog:last)
    vendor/bin/elgg-cli plugins:activate [<plugins>] [-f|--force]

    # Deactivate plugins
    # List plugin ids separating them with spaces: vendor/bin/elgg-cli plugins:deactivate activity blog
    # use -f flag to also disable dependents
    vendor/bin/elgg-cli plugins:deactivate [<plugins>] [-f|--force]


Adding custom commands
======================

Plugins can add their commands to the CLI application, by adding command class name via a configuration in ``elgg-plugin.php`` or via the ``'commands','cli'`` event.
Command class must extend ``\Elgg\CLI\Command``.

.. code-block:: php

    class MyCommand extends \Elgg\Сli\Command {

    }

    elgg_register_event_handler('commands', 'cli', function(\Elgg\Event $event) {
        $return = $event->getValue();

        $return[] = MyCommand::class;

        return $return;

    });

Custom commands are based on `Symfony Console Commands`_. Please refer to their documentation for more details.

.. _Symfony Console Commands: https://symfony.com/doc/current/console.html
