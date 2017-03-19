#!/bin/sh

screen -d -m sh -c "while :; do cd /web/doc/vh/ezpedia/ezpedia.org/vhosts/www.ezpedia.org/ezpublish_legacy/extension/ezfind/java; java -server -d64 -Xmx1500m -Xms1500m -XX:+UseParallelGC -XX:+AggressiveOpts -XX:NewRatio=5 -jar start.jar; done;"

exit;
