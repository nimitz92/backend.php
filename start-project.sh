#!/bin/bash
if [ "$#" == "0" ]; then
    echo "No arguments provided"
    exit 1
fi

mkdir $1
cd $1

git init
git submodule add http://github.com/tr4n2uil/backend.php.git lib/backend.php
git submodule update --init --recursive

echo "cache/*.php" > .gitignore

mkdir apps
touch apps/models.php

mkdir cache

mkdir core
cp lib/backend.php/demo/core/hybridauth_config.php core/hybridauth_config.php
cp lib/backend.php/demo/core/settings-final.php core/settings.php
cp lib/backend.php/demo/core/urls.php core/urls.php

mkdir tpl
cp lib/backend.php/demo/tpl/*.jade tpl

mkdir ui
mkdir ui/style
cp lib/backend.php/demo/ui/style/* ui/style
mkdir ui/script
cp lib/backend.php/demo/ui/script/* ui/script
mkdir ui/image

cp lib/backend.php/demo/.htaccess-final .htaccess
cp lib/backend.php/demo/index.php index.php
cp lib/backend.php/demo/build-styles.sh build-styles.sh

