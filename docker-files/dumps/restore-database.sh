for file in `find /var/mysql-dumps -name "*.sql" -type f`; do
    psql -U postgres -c "DROP DATABASE workify"
    psql -U postgres -c "CREATE DATABASE workify"
    psql -U postgres -d workify < "$file"
done