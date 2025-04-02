from flask import Flask, request, render_template_string
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)

# Database connection configuration
db_config = {
    'host': 'localhost',        # Replace with your database host
    'user': 'pacha',        # Replace with your database username
    'password': 'medical', # Replace with your database password
    'database': 'dbmedical'  # Replace with your database name
}

@app.route('/create_prescription', methods=['GET', 'POST'])
def create_prescription():
    if request.method == 'POST':
        # Collect form data
        record_id = request.form['record_id']
        medication_name = request.form['medication_name']
        dosage = request.form['dosage']
        frequency = request.form['frequency']
        start_date = request.form['start_date']
        end_date = request.form.get('end_date')  # Optional field
        instructions = request.form.get('instructions')  # Optional field
        status = request.form['status']
        created_by = request.form['created_by']
        updated_by = request.form['updated_by']

        # Establish database connection
        try:
            conn = mysql.connector.connect(**db_config)
            cursor = conn.cursor()

            # SQL query to insert the prescription data
            query = """
            INSERT INTO prescriptions (record_id, medication_name, dosage, frequency, start_date, end_date, instructions, status, created_at, updated_at, created_by, updated_by)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, %s, %s)
            """

            # Execute the SQL query
            cursor.execute(query, (record_id, medication_name, dosage, frequency, start_date, end_date, instructions, status, created_by, updated_by))
            conn.commit()

            message = "Prescription created successfully!"
        except mysql.connector.Error as err:
            message = f"Error: {err}"
        finally:
            if conn.is_connected():
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
    <title>Create Prescription</title>
</head>
<body>
    <h2>Create Prescription</h2>
    {% if message %}
        <p>{{ message }}</p>
    {% endif %}
    
    <form method="POST">
        <label for="record_id">Record ID:</label>
        <input type="number" id="record_id" name="record_id" required><br>

        <label for="medication_name">Medication Name:</label>
        <input type="text" id="medication_name" name="medication_name" required><br>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required><br>

        <label for="frequency">Frequency:</label>
        <input type="text" id="frequency" name="frequency" required><br>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date"><br>

        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions"></textarea><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Active">Active</option>
            <option value="Completed">Completed</option>
            <option value="Expired">Expired</option>
            <option value="Cancelled">Cancelled</option>
        </select><br>

        <label for="created_by">Created By (User ID):</label>
        <input type="number" id="created_by" name="created_by" required><br>

        <label for="updated_by">Updated By (User ID):</label>
        <input type="number" id="updated_by" name="updated_by" required><br>

        <input type="submit" value="Create Prescription">
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)