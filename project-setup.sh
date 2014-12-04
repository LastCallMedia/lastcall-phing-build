#!/bin/bash

mkdir -p build
cd build
test -f composer.json || { echo "{}" > composer.json; }
composer config repositories.lastcall composer http://satis.lcmdev.com
composer require lastcall/phing:~1.0 lastcall/behat:dev-master behat/mink-zombie-driver:~1.0

cat << "EOF" > .gitignore
vendor/
artifacts/
EOF

# Do not overwrite build.xml...
test -f build.xml && { exit 0; }
cat << "EOF" > build.xml
<?xml version="1.0" encoding="UTF-8"?>

<project name="project" default="ci-build">
    <import file="vendor/lastcall/phing/common.xml"/>

    <!-- PROPERTIES YOU CAN EDIT BELOW: -->
    <!-- The path to the behat binary you wish to use. -->
    <property name="behat.executable" value="vendor/bin/behat"/>
    <!-- The path to your behat directory. -->
    <property name="project.dir.behat" value="../sites/default/behat"/>
    <!-- The path to your behat.yml (you probably don't need to change this) -->
    <property name="behat.config" value="${project.dir.behat}/behat.yml"/>
    <property name="project.dir.artifacts" value="./artifacts" override="true"/>
    <!-- Paths to custom code.  -->
    <!-- In the future we will use this for checking code style. -->
    <!-- @see: http://www.phing.info/docs/guide/trunk/apds03.html-->
    <fileset id="custom_code" dir="../sites/all">
        <include name="modules/custom/**/*.php"/>
        <include name="modules/custom/**/*.module"/>
        <include name="modules/custom/**/*.inc"/>
        <include name="modules/custom/**/*.info"/>
        <include name="themes/**"/>

        <!-- Exclude generated code: -->
        <exclude name="**.views_default.inc"/>
        <exclude name="**.pages_default.inc"/>
        <exclude name="**.strongarm.inc"/>
        <exclude name="**.feeds_importer_default.inc"/>
        <exclude name="**.field_group.inc"/>
        <exclude name="**.context.inc"/>
        <exclude name="**.features.inc"/>
        <exclude name="**.features.*.inc"/>

        <!-- Exclude non-code files-->
        <exclude name="**/.sass-cache/**"/>
        <exclude name="**.jpg"/>
        <exclude name="**.png"/>
        <exclude name="**.gif"/>
        <exclude name="**.eot"/>
        <exclude name="**.ttf"/>
        <exclude name="**.woff"/>
        <exclude name="**.svg"/>
        <exclude name="**.txt"/>
    </fileset>

    <target name="ci-build" description="Steps to be run in a CI environment">
        <drush command="updatedb" yes="true" checkreturn="true"/>
        <drush command="features-revert-all" yes="true" checkreturn="true"/>
        <!-- Optional: Enable testing for the site.
        <phingcall target="test:behat"/>-->
    </target>
</project>

EOF