#!/bin/bash


# Package Command Variables
packageCmd='tar -zcf';
site='ezpedia';
dir='var';

# Export Database Variable Calculations
timestamp=$(date +"%Y%m%d-%H%M");
dumpFilePackage="download/$site-$dir-$timestamp.tar.gz";

# Clean Var Directory
rm -vrf var/autoload/ezp_*;
rm -vrf var/cache/* var/plain_site/cache/* var/log/*;

# Package Var Directory
$packageCmd $dumpFilePackage $dir;

# Regenerate autoloads
php ./bin/php/ezpgenerateautoloads.php -o;
php ./bin/php/ezpgenerateautoloads.php -e;
php ./bin/php/ezpgenerateautoloads.php -k;

# Inform the user
echo "";
echo "Var Directory Package: "$dumpFilePackage;
echo "";

# End