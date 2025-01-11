for file in `find /var/mysql-dumps -name "*.sql" -type f`; do
    psql -U postgres -c "DROP DATABASE drugs"
    psql -U postgres -c "CREATE DATABASE drugs"
    psql -U postgres -d drugs < "$file"
done