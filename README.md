Last Call Media Phing Build System
==================================

[![Build Status](https://travis-ci.org/LastCallMedia/lastcall-phing-build.svg?branch=master)](https://travis-ci.org/LastCallMedia/lastcall-phing-build)

The purpose of this project is to aid in the automation of testing and code quality tools for Last Call Media's web projects.  It is intended to be run either locally or in a CI environment, and it contains Phing tasks for some common operations.  [Phing documentation](http://www.phing.info/trac/wiki/Users/Documentation)

Setup
-----
1. From the project root, run the following command: `curl https://raw.githubusercontent.com/LastCallMedia/lastcall-phing-build/master/project-setup.sh | sh`
1. Edit the new build file that has been placed in build/build.xml, and change the parameters to fit your project.
1. When you are ready to setup Behat testing, run `vendor/bin/phing setup:behat`.  This will setup a behat directory at the location you have specified in build.xml.
1. Edit your behat.local.yml and set the base_url parameter to the correct URL for the local environment.
1. Run vendor/bin/phing test:behat to run Behat tests.
1. Run vendor/bin/phing ci-build to do a full "CI Build" as configured in your build.xml.

Continuous Integration
----------------------
In CI environments, the ci-build target will be invoked with the following command:
```
    cd build && composer install
    vendor/bin/phing ci-build
```
Whatever is inside your ci-build target will be run.  This means you can add steps to the build by adding tasks inside of the ci-build target.  Having a task "fail" inside of the ci-build target will fail the entire build, so your tasks should be set up to check return codes.  For example:
```
    <drush command="updatedb" yes="true" checkreturn="true"/>
```
In this task, setting "checkreturn" to true means that if this command does not complete successfully, it will fail the build.

Tips
----
* You can add composer script aliases to the build/composer.json file.  For example, the following command will allow you to run `composer behat`:
```
    "scripts": {
        "behat": "vendor/bin/behat -c ../sites/all/behat/behat.yml"
    }
```
* You can add any composer libraries you'd like to the composer.json.  Commit the composer.json and the composer.lock to the repository, but not the vendor/ code.
* This repository and the Last Call Behat repository will be updated frequently, so run composer update as often as you can.

Issues & Changes
----------------
Please use the [Github issue tracker](https://github.com/LastCallMedia/lastcall-phing-build/issues/new) to report bugs for this project.  Please [create pull requests](https://github.com/LastCallMedia/lastcall-phing-build/compare) to submit fixes to this repository.  Always make sure your changes are adequately covered by tests.