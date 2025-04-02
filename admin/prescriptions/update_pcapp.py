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

@app.route('/update_prescription/<int:prescription_id>', methods=['GET', 'POST'])
def update_prescription(prescription_id):
    conn = None
    cursor = None
    prescription = None

    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor(dictionary=True)

        if request.method == 'GET':
            # Fetch prescription data from the database
            cursor.execute("SELECT * FROM prescriptions WHERE prescription_id = %s", (prescription_id,))
            prescription = cursor.fetchone()

            if not prescription:
                return "Prescription not found", 404  # Handle case where prescription is not found

            return render_template_string(TEMPLATE, prescription=prescription)

        elif request.method == 'POST':
            # Collect form data
            record_id = request.form['record_id']
            medication_name = request.form['medication_name']
            dosage = request.form['dosage']
            frequency = request.form['frequency']
            start_date = request.form['start_date']
            end_date = request.form['end_date'] or None  # Optional field
            instructions = request.form['instructions'] or None  # Optional field
            status = request.form['status']
            created_by = request.form['created_by']
            updated_by = request.form['updated_by']

            # Prepare the SQL query to update the prescription
            update_query = """
            UPDATE prescriptions SET
                record_id=%s, medication_name=%s, dosage=%s, frequency=%s, 
                start_date=%s, end_date=%s, instructions=%s, status=%s, 
                updated_at=CURRENT_TIMESTAMP, created_by=%s, updated_by=%s
            WHERE prescription_id=%s
            """
            cursor.execute(update_query, (record_id, medication_name, dosage, frequency, start_date, 
                                          end_date, instructions, status, created_by, updated_by, prescription_id))
            conn.commit()

            return redirect(url_for('update_prescription', prescription_id=prescription_id))

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
    <title>Update Prescription</title>
</head>
<body>
    <h2>Update Prescription</h2>
    <form method="POST" action="{{ url_for('update_prescription', prescription_id=prescription['prescription_id']) }}">
        <input type="hidden" name="prescription_id" value="{{ prescription['prescription_id'] }}">

        <label for="record_id">Record ID:</label>
        <input type="number" id="record_id" name="record_id" value="{{ prescription['record_id'] }}" required><br>

        <label for="medication_name">Medication Name:</label>
        <input type="text" id="medication_name" name="medication_name" value="{{ prescription['medication_name'] }}" required><br>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" value="{{ prescription['dosage'] }}" required><br>

        <label for="frequency">Frequency:</label>
        <input type="text" id="frequency" name="frequency" value="{{ prescription['frequency'] }}" required><br>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="{{ prescription['start_date'] }}" required><br>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="{{ prescription['end_date'] }}"><br>

        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions">{{ prescription['instructions'] }}</textarea><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Active" {% if prescription['status'] == 'Active' %} selected {% endif %}>Active</option>
            <option value="Completed" {% if prescription['status'] == 'Completed' %} selected {% endif %}>Completed</option>
            <option value="Expired" {% if prescription['status'] == 'Expired' %} selected {% endif %}>Expired</option>
            <option value="Cancelled" {% if prescription['status'] == 'Cancelled' %} selected {% endif %}>Cancelled</option>
        </select><br>

        <label for="created_by">Created By (User ID):</label>
        <input type="number" id="created_by" name="created_by" value="{{ prescription['created_by'] }}" required><br>

        <label for="updated_by">Updated By (User ID):</label>
        <input type="number" id="updated_by" name="updated_by" value="{{ prescription['updated_by'] }}" required><br>

        <input type="submit" value="Update Prescription">
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)
