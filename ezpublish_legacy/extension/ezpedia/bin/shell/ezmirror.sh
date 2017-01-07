#!/bin/bash
# create a read-only eZ publish database mirror

dumpdir=
finaldir=
dbuser=xxx
dbpasswd=xxx
sourcedb=xxx
mirrordb=xxx

echo "dumping database"
mysqldump -u ${dbuser} --password=${dbpasswd} --single-transaction --extended-insert -r ${dumpdir}${sourcedb}.sql ${sourcedb}

echo "making mirror database"
mysql -u ${dbuser} --password=${dbpasswd} --execute=" \
    DROP DATABASE IF EXISTS ${mirrordb}; \
    CREATE DATABASE ${mirrordb} DEFAULT CHARSET utf8; \
    USE ${mirrordb}; \
    SOURCE ${dumpdir}${sourcedb}.sql; \
    DROP TABLE IF EXISTS access_log; \
    UPDATE ezuser SET email='nospam@ez.no', password_hash_type=5, password_hash='publish' WHERE login='admin'; \
    UPDATE ezuser SET login=contentobject_id, email='', password_hash_type=5, password_hash=RAND() WHERE login<>'admin'; \
    DELETE FROM ezsession; \
    DELETE FROM ezuser_accountkey; \
    DELETE FROM ezuservisit; \
    DELETE FROM ezsubtree_notification_rule; \
    DELETE FROM ezforgot_password; \
    DELETE FROM ezcontentbrowserecent; \
    DELETE FROM ezgeneral_digest_user_settings; \
    DELETE FROM eznotificationcollection_item; \
    DELETE FROM eznotificationcollection; \
    DELETE FROM eznotificationevent; \
    DELETE FROM ezpreferences WHERE user_id<>14; \
    DELETE FROM eztipafriend_request; \
    DELETE FROM ezworkflow_process;"

rm ${dumpdir}${sourcedb}.sql

echo "dumping mirror database"
mysqldump -u ${dbuser} --password=${dbpasswd} --single-transaction --extended-insert -r ${dumpdir}${mirrordb}.sql ${mirrordb}

echo "compressing mirror database dump"
gzip ${dumpdir}${mirrordb}.sql

echo "moving mirror database dump"
mv ${dumpdir}${mirrordb}.sql.gz ${finaldir}${mirrordb}.sql.gz
