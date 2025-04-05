#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "civetweb.h"
#include <mysql/mysql.h>

#define MAX_BODY_LENGTH 2048
#define MAX_DOCTORS 100
#define MAX_NAME_LENGTH 100

typedef struct {
    int doctor_id;
    char first_name[MAX_NAME_LENGTH];
    char last_name[MAX_NAME_LENGTH];
    char specialization[MAX_NAME_LENGTH];
    char email[MAX_NAME_LENGTH];
    char phone_number[MAX_NAME_LENGTH];
    char department[MAX_NAME_LENGTH];
    char birthdate[MAX_NAME_LENGTH];
    char address[MAX_NAME_LENGTH];
    char status[MAX_NAME_LENGTH];
    char notes[MAX_NAME_LENGTH];
} Doctor;

Doctor doctors[MAX_DOCTORS];
int doctor_count = 0;

MYSQL *conn;

void connect_to_db() {
    conn = mysql_init(NULL);
    if (conn == NULL) {
        fprintf(stderr, "mysql_init() failed\n");
        exit(1);
    }

    if (mysql_real_connect(conn, "localhost", "root", "password", "hospital_db", 0, NULL, 0) == NULL) {
        fprintf(stderr, "mysql_real_connect() failed: %s\n", mysql_error(conn));
        mysql_close(conn);
        exit(1);
    }
}
void handle_create_doctor(struct mg_connection *conn) {
    char body[MAX_BODY_LENGTH];
    int body_len = mg_read(conn, body, sizeof(body));

    if (body_len <= 0) {
        mg_send_http_response(conn, 400, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Invalid input\"}");
        return;
    }

    // Example of parsing the input body
    Doctor new_doctor;
    int parsed = sscanf(body, "first_name=%99[^&]&last_name=%99[^&]&specialization=%99[^&]&email=%99[^&]&phone_number=%99[^&]&department=%99[^&]&birthdate=%99[^&]&address=%99[^&]&status=%99[^&]&notes=%99[^\n]",
                        new_doctor.first_name, new_doctor.last_name, new_doctor.specialization, new_doctor.email, new_doctor.phone_number, new_doctor.department,
                        new_doctor.birthdate, new_doctor.address, new_doctor.status, new_doctor.notes);
    
    if (parsed != 10) {
        mg_send_http_response(conn, 400, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Invalid input format\"}");
        return;
    }

    // Insert into the database
    char query[1024];
    snprintf(query, sizeof(query),
             "INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes) VALUES "
             "('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
             new_doctor.first_name, new_doctor.last_name, new_doctor.specialization, new_doctor.email, new_doctor.phone_number, new_doctor.department,
             new_doctor.birthdate, new_doctor.address, new_doctor.status, new_doctor.notes);

    if (mysql_query(conn, query)) {
        mg_send_http_response(conn, 500, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Database error\"}");
        return;
    }

    mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", "{\"status\": \"success\"}");
}
2. Get All Doctors (GET /doctors):
c
Copy
void handle_get_doctors(struct mg_connection *conn) {
    char response[4096] = "{\"doctors\": [";
    char query[] = "SELECT * FROM doctors";
    if (mysql_query(conn, query)) {
        mg_send_http_response(conn, 500, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Database error\"}");
        return;
    }

    MYSQL_RES *res = mysql_store_result(conn);
    MYSQL_ROW row;

    while ((row = mysql_fetch_row(res)) != NULL) {
        char doctor_data[1024];
        snprintf(doctor_data, sizeof(doctor_data),
                 "{\"doctor_id\": %s, \"first_name\": \"%s\", \"last_name\": \"%s\", \"specialization\": \"%s\", \"email\": \"%s\", \"phone_number\": \"%s\", "
                 "\"department\": \"%s\", \"birthdate\": \"%s\", \"address\": \"%s\", \"status\": \"%s\", \"notes\": \"%s\"}",
                 row[0], row[1], row[2], row[3], row[4], row[5], row[6], row[7], row[8], row[9], row[10]);

        strcat(response, doctor_data);
        if (mysql_fetch_row(res)) {
            strcat(response, ", ");
        }
    }

    strcat(response, "]}");
    mysql_free_result(res);

    mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", response);
}
void handle_get_doctor_by_id(struct mg_connection *conn, int doctor_id) {
    char query[128];
    snprintf(query, sizeof(query), "SELECT * FROM doctors WHERE doctor_id = %d", doctor_id);

    if (mysql_query(conn, query)) {
        mg_send_http_response(conn, 500, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Database error\"}");
        return;
    }

    MYSQL_RES *res = mysql_store_result(conn);
    MYSQL_ROW row;
    
    if ((row = mysql_fetch_row(res)) != NULL) {
        char doctor_data[1024];
        snprintf(doctor_data, sizeof(doctor_data),
                 "{\"doctor_id\": %s, \"first_name\": \"%s\", \"last_name\": \"%s\", \"specialization\": \"%s\", \"email\": \"%s\", \"phone_number\": \"%s\", "
                 "\"department\": \"%s\", \"birthdate\": \"%s\", \"address\": \"%s\", \"status\": \"%s\", \"notes\": \"%s\"}",
                 row[0], row[1], row[2], row[3], row[4], row[5], row[6], row[7], row[8], row[9], row[10]);

        mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", doctor_data);
    } else {
        mg_send_http_response(conn, 404, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Doctor not found\"}");
    }

    mysql_free_result(res);
}
4. Update Doctor (PUT /doctors/{id}):
c
Copy
void handle_update_doctor(struct mg_connection *conn, int doctor_id) {
    char body[MAX_BODY_LENGTH];
    int body_len = mg_read(conn, body, sizeof(body));

    if (body_len <= 0) {
        mg_send_http_response(conn, 400, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Invalid input\"}");
        return;
    }

    // Parse the body and update doctor information
    char query[1024];
    snprintf(query, sizeof(query),
             "UPDATE doctors SET first_name='%s', last_name='%s', specialization='%s', email='%s', phone_number='%s', department='%s', birthdate='%s', address='%s', status='%s', notes='%s' WHERE doctor_id=%d",
             body["first_name"], body["last_name"], body["specialization"], body["email"], body["phone_number"], body["department"],
             body["birthdate"], body["address"], body["status"], body["notes"], doctor_id);

    if (mysql_query(conn, query)) {
        mg_send_http_response(conn, 500, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Database error\"}");
        return;
    }

    mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", "{\"status\": \"success\"}");
}
void handle_delete_doctor(struct mg_connection *conn, int doctor_id) {
    char query[128];
    snprintf(query, sizeof(query), "DELETE FROM doctors WHERE doctor_id = %d", doctor_id);

    if (mysql_query(conn, query)) {
        mg_send_http_response(conn, 500, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Database error\"}");
        return;
    }

    mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", "{\"status\": \"success\"}");
}
int main(void) {
    struct mg_context *ctx;
    struct mg_callbacks callbacks;
    memset(&callbacks, 0, sizeof(callbacks));
    const char *options[] = {
        "document_root", ".",
        "listening_ports", "8080", // HTTP server listens on port 8080
        NULL
    };

    ctx = mg_start(&callbacks, NULL, options);
    connect_to_db();

    // Register API routes
    mg_set_request_handler(ctx, "/doctors", handle_get_doctors, NULL);
    mg_set_request_handler(ctx, "/doctors/create", handle_create_doctor, NULL);
    mg_set_request_handler(ctx, "/doctors/update/", handle_update_doctor, NULL);
    mg_set_request_handler(ctx, "/doctors/delete/", handle_delete_doctor, NULL);
    mg_set_request_handler(ctx, "/doctors/", handle_get_doctor_by_id, NULL);

    printf("Doctor management system running on port 8080...\n");

    getchar();  // Wait for Enter to stop the server

    mg_stop(ctx);
    mysql_close(conn);
    return 0;
}
