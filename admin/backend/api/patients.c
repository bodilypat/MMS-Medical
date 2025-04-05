#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "civetweb.h" // Civetweb HTTP server

#define MAX_PATIENTS 100
#define MAX_NAME_LENGTH 100

typedef struct {
    int id;
    char first_name[MAX_NAME_LENGTH];
    char last_name[MAX_NAME_LENGTH];
    char email[MAX_NAME_LENGTH];
    char phone_number[MAX_NAME_LENGTH];
    char date_of_birth[MAX_NAME_LENGTH];
    char address[MAX_NAME_LENGTH];
} Patient;

Patient patients[MAX_PATIENTS];
int patient_count = 0;

int find_patient_by_id(int id) {
    for (int i = 0; i < patient_count; i++) {
        if (patients[i].id == id) {
            return i;
        }
    }
    return -1;
}

void handle_create_patient(struct mg_connection *conn) {
    // To be called when POST /patients is made
    char body[1024];
    int body_len = mg_read(conn, body, sizeof(body));

    // Example: Parse the body and populate the patient structure
    Patient new_patient;
    sscanf(body, "first_name=%99[^&]&last_name=%99[^&]&email=%99[^&]&phone_number=%99[^&]&date_of_birth=%99[^&]&address=%99[^\n]",
           new_patient.first_name, new_patient.last_name, new_patient.email, new_patient.phone_number, new_patient.date_of_birth, new_patient.address);

    new_patient.id = patient_count + 1; // Auto increment ID
    patients[patient_count++] = new_patient;

    mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", "{\"status\": \"success\"}");
}

void handle_get_patients(struct mg_connection *conn) {
    // To be called when GET /patients is made
    char response[4096] = "{\"patients\": [";
    for (int i = 0; i < patient_count; i++) {
        char patient_data[1024];
        snprintf(patient_data, sizeof(patient_data),
                 "{\"id\": %d, \"first_name\": \"%s\", \"last_name\": \"%s\", \"email\": \"%s\", \"phone_number\": \"%s\", \"date_of_birth\": \"%s\", \"address\": \"%s\"}",
                 patients[i].id, patients[i].first_name, patients[i].last_name, patients[i].email, patients[i].phone_number, patients[i].date_of_birth, patients[i].address);
        strcat(response, patient_data);
        if (i < patient_count - 1) {
            strcat(response, ", ");
        }
    }
    strcat(response, "]}");

    mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", response);
}

void handle_get_patient_by_id(struct mg_connection *conn, int patient_id) {
    // To be called when GET /patients/{id} is made
    int index = find_patient_by_id(patient_id);
    if (index != -1) {
        char patient_data[1024];
        snprintf(patient_data, sizeof(patient_data),
                 "{\"id\": %d, \"first_name\": \"%s\", \"last_name\": \"%s\", \"email\": \"%s\", \"phone_number\": \"%s\", \"date_of_birth\": \"%s\", \"address\": \"%s\"}",
                 patients[index].id, patients[index].first_name, patients[index].last_name, patients[index].email, patients[index].phone_number, patients[index].date_of_birth, patients[index].address);
        mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", patient_data);
    } else {
        mg_send_http_response(conn, 404, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Patient not found\"}");
    }
}

void handle_update_patient(struct mg_connection *conn, int patient_id) {
    // To be called when PUT /patients/{id} is made
    int index = find_patient_by_id(patient_id);
    if (index != -1) {
        char body[1024];
        int body_len = mg_read(conn, body, sizeof(body));

        // Example: Update patient info
        sscanf(body, "first_name=%99[^&]&last_name=%99[^&]&email=%99[^&]&phone_number=%99[^&]&date_of_birth=%99[^&]&address=%99[^\n]",
               patients[index].first_name, patients[index].last_name, patients[index].email, patients[index].phone_number, patients[index].date_of_birth, patients[index].address);

        mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", "{\"status\": \"success\"}");
    } else {
        mg_send_http_response(conn, 404, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Patient not found\"}");
    }
}

void handle_delete_patient(struct mg_connection *conn, int patient_id) {
    // To be called when DELETE /patients/{id} is made
    int index = find_patient_by_id(patient_id);
    if (index != -1) {
        for (int i = index; i < patient_count - 1; i++) {
            patients[i] = patients[i + 1];
        }
        patient_count--;
        mg_send_http_response(conn, 200, "Content-Type: application/json\r\n", "{\"status\": \"success\"}");
    } else {
        mg_send_http_response(conn, 404, "Content-Type: application/json\r\n", "{\"status\": \"error\", \"message\": \"Patient not found\"}");
    }
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

    // Register API routes
    mg_set_request_handler(ctx, "/patients", handle_get_patients, NULL);
    mg_set_request_handler(ctx, "/patients/create", handle_create_patient, NULL);
    mg_set_request_handler(ctx, "/patients/update/", handle_update_patient, NULL);
    mg_set_request_handler(ctx, "/patients/delete/", handle_delete_patient, NULL);
    mg_set_request_handler(ctx, "/patients/", handle_get_patient_by_id, NULL);

    printf("Patient management system running on port 8080...\n");

    getchar(); // Wait for Enter to stop the server

    mg_stop(ctx);
    return 0;
}