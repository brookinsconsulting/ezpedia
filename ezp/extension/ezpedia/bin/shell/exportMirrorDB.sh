#!/bin/bash


# Export Database

# Command
dumpCmd='mysqldump5';

# Export Database Variables
user='db';
password='db';
db='ezpedia';

# Export Database Variable Calculations
timestamp=$(date +"%Y%m%d-%H%M");
dumpFile="download/$db-mirror-of-db-$timestamp.sql";
dumpFilePackage="download/"$dumpFile".tar.gz";

# Dump Database to File
$dumpCmd -u $user -p$password -h localhost --ignore-table=$db.ezuser --ignore-table=$db.ezuser_accountkey --ignore-table=$db.ezuser_discountrule --ignore-table=$db.ezuser_setting --ignore-table=$db.ezuservisit --ignore-table=$db.ezsession $db > $dumpFile;

# Package Database Dump File
tar -zcf $dumpFilePackage.tar.gz $dumpFile;

# Inform the user
echo "";
echo "Database Package: "$dumpFilePackage;
echo "Database File: "$dumpFile;
echo "";

# End