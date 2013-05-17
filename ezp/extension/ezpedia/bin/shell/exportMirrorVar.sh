#!/bin/bash


if [ $(id --user) -eq 0 ]; then
  echo "INFO: Switching to user www-data..."
  su www-data -c $0
  exit $?
fi

# Package Command Variables
packageCmd='tar --dereference -zcf';
site='ezpedia';
dir='var';

# Export Database Variable Calculations
timestamp=$(date +"%Y%m%d-%H%M");
dumpFilePackage="download/$site-$dir-$timestamp.tar.gz";

# Clean Var Directory
rm -vrf var/autoload/ezp_*;
rm -vrf var/cache/* var/plain_site/cache/* var/log/*;

if [ ! -d "download" ]; then
  mkdir download
fi

# Package Var Directory
$packageCmd $dumpFilePackage $dir;

# Regenerate autoloads
php ./bin/php/ezpgenerateautoloads.php -o;
php ./bin/php/ezpgenerateautoloads.php -e;

# Inform the user
echo "";
echo "Var Directory Package: "$dumpFilePackage;
echo "";

# End