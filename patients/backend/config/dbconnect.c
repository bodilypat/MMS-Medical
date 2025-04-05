#include <mysql/mysql.h>
#include <stdio.h>
#include <stdlib.h>

int main() {
    MYSQL *conn;
    MYSQL_RES *res;
    MYSQL_ROW row;

    // Initialize MySQL connection
    conn = mysql_init(NULL);
    if (conn == NULL) {
        fprintf(stderr, "mysql_init() failed\n");
        exit(EXIT_FAILURE);
    }

    // Establish a connection to the database
    if (mysql_real_connect(conn, "localhost", "root", "your_password", "MEDICAL", 0, NULL, 0) == NULL) {
        fprintf(stderr, "mysql_real_connect() failed\n");
        mysql_close(conn);
        exit(EXIT_FAILURE);
    }

    // Execute a simple query to check the connection
    if (mysql_query(conn, "SHOW TABLES")) {
        fprintf(stderr, "SHOW TABLES failed. Error: %s\n", mysql_error(conn));
        mysql_close(conn);
        exit(EXIT_FAILURE);
    }

    // Retrieve the result set
    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "mysql_store_result() failed. Error: %s\n", mysql_error(conn));
        mysql_close(conn);
        exit(EXIT_FAILURE);
    }

    // Print the tables in the database
    printf("Tables in the MEDICAL database:\n");
    while ((row = mysql_fetch_row(res)) != NULL) {
        printf("%s\n", row[0]);
    }

    // Clean up
    mysql_free_result(res);
    mysql_close(conn);

    return 0;
}