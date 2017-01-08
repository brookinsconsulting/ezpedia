#!/bin/sh

screen -d -m sh -c "while :; do cd /home/brookins/ezpedia/java; java -server -d64 -Xmx1500m -Xms1500m -XX:+UseParallelGC -XX:+AggressiveOpts -XX:NewRatio=5 -jar start.jar; done;"

exit;
