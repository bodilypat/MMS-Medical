from flask import Flask, request, render_template_string
import mysql.connector

app = Flask(__name__)

# Database connection configuration
db_config = {
    'host': 'psmedical.com',       # Replace with your database host
    'user': 'pacha',       # Replace with your database username
    'password': 'medical', # Replace with your database password
    'database': 'dbmedical' # Replace with your database name
}

@app.route('/create_medical_record', methods=['GET', 'POST'])
def create_medical_record():
    if request.method == 'POST':
        # Collect form data
        patient_id = request.form['patient_id']
        appointment_id = request.form['appointment_id']
        diagnosis = request.form['diagnosis']
        treatment_plan = request.form['treatment_plan']
        note = request.form['note']
        status = request.form['status']
        created_by = request.form['created_by']
        updated_by = request.form['updated_by']
        attachments = request.form['attachments']

        # Establish database connection
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Insert query
        query = """
        INSERT INTO medical_records (patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, updated_by, attachments)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        try:
            # Execute the query
            cursor.execute(query, (patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, updated_by, attachments))
            conn.commit()
            message = "New medical record created successfully."
        except mysql.connector.Error as err:
            message = f"Error: {err}"
        finally:
            cursor.close()
            conn.close()

        return render_template_string(TEMPLATE, message=message)

    return render_template_string(TEMPLATE, message=None)

TEMPLATE = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Medical Record</title>
</head>
<body>
    <h2>Create Medical Record</h2>
    {% if message %}
        <p>{{ message }}</p>
    {% endif %}
    
    <form method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" required><br>

        <label for="appointment_id">Appointment ID:</label>
        <input type="number" name="appointment_id" required><br>

        <label for="diagnosis">Diagnosis:</label>
        <input type="text" name="diagnosis" required><br>

        <label for="treatment_plan">Treatment Plan:</label>
        <textarea name="treatment_plan"></textarea><br>

        <label for="note">Note:</label>
        <textarea name="note"></textarea><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="Active">Active</option>
            <option value="Archived">Archived</option>
            <option value="Inactive">Inactive</option>
        </select><br>

        <label for="created_by">Created By (User ID):</label>
        <input type="number" name="created_by" required><br>

        <label for="updated_by">Updated By (User ID):</label>
        <input type="number" name="updated_by" required><br>

        <label for="attachments">Attachments (File Path/URL):</label>
        <input type="text" name="attachments"><br>

        <button type="submit">Create Medical Record</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)
