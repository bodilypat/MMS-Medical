from flask import Flask, request, render_template_string, redirect, url_for
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)

# Database connection configuration
db_config = {
    'host': 'psmedical.com',        # Replace with your database host
    'user': 'pacha',        # Replace with your database username
    'password': 'medical', # Replace with your database password
    'database': 'dbmedical'  # Replace with your database name
}

@app.route('/update_appointment/<int:appointment_id>', methods=['GET', 'POST'])
def update_appointment(appointment_id):
    conn = None
    cursor = None
    appointment = None

    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor(dictionary=True)

        if request.method == 'GET':
            # Fetch appointment data from database
            cursor.execute("SELECT * FROM appointments WHERE appointment_id = %s", (appointment_id,))
            appointment = cursor.fetchone()

            if not appointment:
                return "Appointment not found", 404  # Handle case where appointment is not found

            return render_template_string(TEMPLATE, appointment=appointment)

        elif request.method == 'POST':
            # Collect form data
            patient_id = request.form['patient_id']
            doctor_id = request.form['doctor_id']
            appointment_date = request.form['appointment_date']
            reason_for_visit = request.form['reason_for_visit']
            status = request.form['status']
            duration = request.form['duration']
            appointment_type = request.form['appointment_type']
            notes = request.form['notes']

            # Update query
            update_query = """
            UPDATE appointments
            SET patient_id=%s, doctor_id=%s, appointment_date=%s, reason_for_visit=%s, 
                status=%s, duration=%s, appointment_type=%s, notes=%s
            WHERE appointment_id=%s
            """
            cursor.execute(update_query, (patient_id, doctor_id, appointment_date, reason_for_visit, 
                                          status, duration, appointment_type, notes, appointment_id))
            conn.commit()

            return redirect(url_for('update_appointment', appointment_id=appointment_id))

    except Error as err:
        return f"Error: {err}"

    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

TEMPLATE = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment</title>
</head>
<body>
    <h2>Update Appointment</h2>
    
    <form method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" value="{{ appointment['patient_id'] }}" required><br>

        <label for="doctor_id">Doctor ID:</label>
        <input type="number" name="doctor_id" value="{{ appointment['doctor_id'] }}" required><br>

        <label for="appointment_date">Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" value="{{ appointment['appointment_date'] }}" required><br>

        <label for="reason_for_visit">Reason for Visit:</label>
        <input type="text" name="reason_for_visit" value="{{ appointment['reason_for_visit'] }}"><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="Scheduled" {% if appointment['status'] == 'Scheduled' %} selected {% endif %}>Scheduled</option>
            <option value="Completed" {% if appointment['status'] == 'Completed' %} selected {% endif %}>Completed</option>
            <option value="Cancelled" {% if appointment['status'] == 'Cancelled' %} selected {% endif %}>Cancelled</option>
            <option value="No-Show" {% if appointment['status'] == 'No-Show' %} selected {% endif %}>No-Show</option>
        </select><br>

        <label for="duration">Duration (in minutes):</label>
        <input type="number" name="duration" value="{{ appointment['duration'] }}"><br>

        <label for="appointment_type">Appointment Type:</label>
        <input type="text" name="appointment_type" value="{{ appointment['appointment_type'] }}"><br>

        <label for="notes">Notes:</label>
        <textarea name="notes">{{ appointment['notes'] }}</textarea><br>

        <button type="submit">Update Appointment</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)
