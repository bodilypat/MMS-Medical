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

@app.route('/update_medical_record/<int:record_id>', methods=['GET', 'POST'])
def update_medical_record(record_id):
    conn = None
    cursor = None
    record = None

    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor(dictionary=True)

        if request.method == 'GET':
            # Fetch medical record data from database
            cursor.execute("SELECT * FROM medical_records WHERE record_id = %s", (record_id,))
            record = cursor.fetchone()

            if not record:
                return "Medical record not found", 404  # Handle case where record is not found

            return render_template_string(TEMPLATE, record=record)

        elif request.method == 'POST':
            # Collect form data
            patient_id = request.form['patient_id']
            appointment_id = request.form['appointment_id']
            diagnosis = request.form['diagnosis']
            treatment_plan = request.form['treatment_plan']
            note = request.form['note']
            status = request.form['status']
            updated_by = request.form['updated_by']
            attachments = request.form['attachments']

            # Update query
            update_query = """
            UPDATE medical_records
            SET patient_id=%s, appointment_id=%s, diagnosis=%s, treatment_plan=%s, 
                note=%s, status=%s, updated_by=%s, attachments=%s
            WHERE record_id=%s
            """
            cursor.execute(update_query, (patient_id, appointment_id, diagnosis, treatment_plan,
                                          note, status, updated_by, attachments, record_id))
            conn.commit()

            return redirect(url_for('update_medical_record', record_id=record_id))

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
    <title>Update Medical Record</title>
</head>
<body>
    <h2>Update Medical Record</h2>
    
    <form method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" value="{{ record['patient_id'] }}" required><br>

        <label for="appointment_id">Appointment ID:</label>
        <input type="number" name="appointment_id" value="{{ record['appointment_id'] }}" required><br>

        <label for="diagnosis">Diagnosis:</label>
        <input type="text" name="diagnosis" value="{{ record['diagnosis'] }}" required><br>

        <label for="treatment_plan">Treatment Plan:</label>
        <textarea name="treatment_plan">{{ record['treatment_plan'] }}</textarea><br>

        <label for="note">Note:</label>
        <textarea name="note">{{ record['note'] }}</textarea><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="Active" {% if record['status'] == 'Active' %} selected {% endif %}>Active</option>
            <option value="Archived" {% if record['status'] == 'Archived' %} selected {% endif %}>Archived</option>
            <option value="Inactive" {% if record['status'] == 'Inactive' %} selected {% endif %}>Inactive</option>
        </select><br>

        <label for="updated_by">Updated By (User ID):</label>
        <input type="number" name="updated_by" value="{{ record['updated_by'] }}" required><br>

        <label for="attachments">Attachments (File Path/URL):</label>
        <input type="text" name="attachments" value="{{ record['attachments'] }}"><br>

        <button type="submit">Update Medical Record</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)