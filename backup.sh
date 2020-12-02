BASENAME="../PGSF_"
TARGZEXT=".tar.gz"
DBSQLEXT=".sql"

DATE=`date '+%Y-%m-%d_%Hh%M'`

TARNAME="$BASENAME$DATE$TARGZEXT"

echo "Generating '$TARNAME'... \c"
tar --exclude='./var' --exclude='./vendor' -czf $TARNAME .
echo "done."

DBHOST='db5000319800.hosting-data.io'
DBNAME='dbs311941'
DBUSER='dbu581878'
DBPASS='GestSessForm_2020'

DBDUMP="$BASENAME$DATE$DBSQLEXT"

echo "Generating '$DBDUMP'... \c"
mysqldump --host="$DBHOST" --user="$DBUSER" --password="$DBPASS" "$DBNAME" > "$DBDUMP"
echo "done."
