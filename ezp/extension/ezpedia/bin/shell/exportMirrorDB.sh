#!/bin/bash



if [ $(id --user) -eq 0 ]; then
  echo "INFO: Switching to user www-data..."
  su www-data -c $0
  exit $?
fi

# Export Database

# Command
dumpCmd="$(which mysqldump5 || which mysqldump)"

db_access_ini="settings/override/site.ini"
if [ ! -f "$db_access_ini" ]; then
  echo "ERROR: File '$db_access_ini' not found..." 1>&2
  exit 1
fi

# Export Database Variables
user=$(cat $db_access_ini | grep -E -e "^User="| cut --only-delimited -d "=" -f 2)
password=$(cat $db_access_ini | grep -E -e "^Password=" | cut --only-delimited -d "=" -f 2)
db=$(cat $db_access_ini | grep -E -e "^Database="| cut --only-delimited -d "=" -f 2)
host=$(cat $db_access_ini | grep -E -e "^Server="| cut --only-delimited -d "=" -f 2)

if [ -z "$user" ] || \
   [ -z "$password" ] || \
   [ -z "$db" ] || \
   [ -z "$host" ]; then
  echo "ERROR: Failed to extract db-access-information out og '$db_access_ini'" 1>&2
  exit 1
fi

# Export Database Variable Calculations
timestamp=$(date +"%Y%m%d-%H%M")
dumpFile="download/$db-mirror-of-db-$timestamp.sql"

if [ ! -d "download" ]; then
  mkdir download
fi

# Dump Database to File
echo "INFO: Dumping database (with --skip-lock-tables)..."
$dumpCmd -u "$user" \
         -p"$password" \
         -h "$host" \
         --skip-lock-tables \
         --ignore-table="$db".ezuser \
         --ignore-table="$db".ezuser_accountkey \
         --ignore-table="$db".ezuser_discountrule \
         --ignore-table="$db".ezuser_setting \
         --ignore-table="$db".ezuservisit \
         --ignore-table="$db".ezsession \
         "$db" > $dumpFile
if [ $? -ne 0 ]; then
  echo "ERROR: Failed to generate the dump..." 1>&2
  rm -f $dumpFile
  exit 1
fi

# Package Database Dump File
echo "INFO: Compressing database-dump..." 1>&2
gzip $dumpFile

# Inform the user
echo ""
echo "Database File: "$dumpFile.gz
echo ""

# End