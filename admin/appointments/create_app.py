from flask import Flask, request, render_template_string
import mysql.connector

app = Flask(__name__)

# Database connection configuration
db_config = {
    'host': 'localhost',
    'user': 'pacha',
    'password': 'medical',
    'database': 'dbmedical'
}

# Route for creating appointment
@app.route('/create_appointment', methods=['GET', 'POST'])
def create_appointment():
    if request.method == 'POST':
        # Collect form data
        patient_id = request.form['patient_id']
        doctor_id = request.form['doctor_id']
        appointment_date = request.form['appointment_date']
        reason_for_visit = request.form['reason_for_visit']
        status = request.form['status']
        duration = request.form['duration']
        appointment_type = request.form['appointment_type']
        notes = request.form['notes']
        
        # Establish database connection
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        
        # Insert query
        query = """
        INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
        """
        
        try:
            # Execute the query
            cursor.execute(query, (patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes))
            conn.commit()
            message = "New appointment created successfully."
        except mysql.connector.Error as err:
            message = f"Error: {err}"
        finally:
            cursor.close()
            conn.close()
        
        return render_template_string(TEMPLATE, message=message)

    # Display the form
    return render_template_string(TEMPLATE, message=None)

TEMPLATE = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment</title>
</head>
<body>
    <h2>Create Appointment</h2>
    {% if message %}
        <p>{{ message }}</p>
    {% endif %}
    
    <form method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" required><br>

        <label for="doctor_id">Doctor ID:</label>
        <input type="number" name="doctor_id" required><br>

        <label for="appointment_date">Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" required><br>

        <label for="reason_for_visit">Reason for Visit:</label>
        <input type="text" name="reason_for_visit"><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="Scheduled">Scheduled</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
            <option value="No-Show">No-Show</option>
        </select><br>

        <label for="duration">Duration (in minutes):</label>
        <input type="number" name="duration"><br>

        <label for="appointment_type">Appointment Type:</label>
        <input type="text" name="appointment_type"><br>

        <label for="notes">Notes:</label>
        <textarea name="notes"></textarea><br>

        <button type="submit">Create Appointment</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)