#!/bin/bash

# Make sure only root can run our script
if [ "$(id -u)" != "0" ]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

. db_settings.ini

mkdir -p log

function database_exists () {
    # /!\ Will return false if psql can't list database. Edit your pg_hba.conf
    # as appropriate.
    if [ -z $1 ]
        then
        # Argument is null
        return 0
    else
        # Grep db name in the list of database
        sudo -n -u postgres -h $host -s -- psql -tAl | grep -q "^$1|"
        return $?
    fi
}


if database_exists $db_name
then   
	if $drop_apps_db
        then	
	        echo 'Suppression de la base de données...'
			sudo -n -u postgres -h $host -s psql -d $db_name -c "SELECT pg_terminate_backend(pg_stat_activity.pid) FROM pg_stat_activity WHERE pg_stat_activity.datname = '$db_name'  AND pid <> pg_backend_pid();"  
			sudo -n -u postgres -h $host -s dropdb $db_name
        else
        	echo "La base de données existe et le fichier de settings indique de ne pas la supprimer."
	fi
fi

if ! database_exists $db_name 
then
	
	echo "Création de la base..."
	sudo -n -u postgres -h $host -s createdb -O $user_pg $db_name

	echo "Création de la structure de la base de données..."
	export PGPASSWORD=$user_pg_pass;psql -h $host -U $user_pg -d $db_name -f scripts/schema_projet_suivis.sql  &> log/install_db.log


	echo "Insertion des données de vocabulaire et des utilisateurs..."
	export PGPASSWORD=$user_pg_pass;psql -h $host -U $user_pg -d $db_name -f scripts/data_projet_suivis.sql  &>> log/install_db.log
	export PGPASSWORD=$user_pg_pass;psql -h $host -U $user_pg -d $db_name -f scripts/utilisateurs_projet_suivis.sql  &>> log/install_db.log


	echo "Décompression des fichiers du taxref..."
	cd data/inpn
	unzip TAXREF_INPN_v8.0.zip
	unzip ESPECES_REGLEMENTEES.zip
	cd ../..
	echo "Insertion  des données taxonomiques de l'inpn... (cette opération peut être longue)"
	DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
	sed -i "s#PATH_TO_DIR#${DIR}#g" scripts/import_data_inpn_v8.sql
	export PGPASSWORD=$user_pg_pass;psql -h $host -U $user_pg -d $db_name  -f scripts/import_data_inpn_v8.sql &>> log/install_db.log
	
	find data/inpn -type f -not -name '*.zip' | xargs rm

	echo "Insertion  des données géographiques : communes de france"
	pg_restore -h $host -U $user_pg -d $db_name  data/layers/data_communes_projet_suivis.dump  &>> log/install_db.log

fi