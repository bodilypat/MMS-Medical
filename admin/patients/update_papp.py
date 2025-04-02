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

@app.route('/update_patient/<int:patient_id>', methods=['GET', 'POST'])
def update_patient(patient_id):
    conn = None
    cursor = None
    patient = None

    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor(dictionary=True)

        if request.method == 'GET':
            # Fetch patient data from database
            cursor.execute("SELECT * FROM patients WHERE patient_id = %s", (patient_id,))
            patient = cursor.fetchone()

            if not patient:
                return "Patient not found", 404  # Handle case where patient is not found

            return render_template_string(TEMPLATE, patient=patient)

        elif request.method == 'POST':
            # Collect form data
            first_name = request.form['first_name']
            last_name = request.form['last_name']
            date_of_birth = request.form['date_of_birth']
            gender = request.form['gender']
            email = request.form['email']
            phone_number = request.form['phone_number']
            address = request.form['address']
            insurance_provider = request.form['insurance_provider']
            insurance_policy_number = request.form['insurance_policy_number']
            primary_care_physician = request.form['primary_care_physician']
            medical_history = request.form['medical_history']
            allergies = request.form['allergies']
            status = request.form['status']

            # Update query
            update_query = """
            UPDATE patients
            SET first_name=%s, last_name=%s, date_of_birth=%s, gender=%s, email=%s, 
                phone_number=%s, address=%s, insurance_provider=%s, 
                insurance_policy_number=%s, primary_care_physician=%s, 
                medical_history=%s, allergies=%s, status=%s
            WHERE patient_id=%s
            """
            cursor.execute(update_query, (first_name, last_name, date_of_birth, gender, email, 
                                          phone_number, address, insurance_provider, 
                                          insurance_policy_number, primary_care_physician, 
                                          medical_history, allergies, status, patient_id))
            conn.commit()

            return redirect(url_for('update_patient', patient_id=patient_id))

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
    <title>Update Patient</title>
</head>
<body>
    <h2>Update Patient</h2>
    
    <form method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="number" name="patient_id" value="{{ patient['patient_id'] }}" readonly><br>

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="{{ patient['first_name'] }}" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ patient['last_name'] }}" required><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" value="{{ patient['date_of_birth'] }}" required><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male" {% if patient['gender'] == 'male' %} selected {% endif %}>Male</option>
            <option value="female" {% if patient['gender'] == 'female' %} selected {% endif %}>Female</option>
            <option value="other" {% if patient['gender'] == 'other' %} selected {% endif %}>Other</option>
        </select><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ patient['email'] }}" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="{{ patient['phone_number'] }}" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="{{ patient['address'] }}"><br>

        <label for="insurance_provider">Insurance Provider:</label>
        <input type="text" name="insurance_provider" value="{{ patient['insurance_provider'] }}"><br>

        <label for="insurance_policy_number">Insurance Policy Number:</label>
        <input type="text" name="insurance_policy_number" value="{{ patient['insurance_policy_number'] }}"><br>

        <label for="primary_care_physician">Primary Care Physician:</label>
        <input type="text" name="primary_care_physician" value="{{ patient['primary_care_physician'] }}"><br>

        <label for="medical_history">Medical History:</label>
        <textarea name="medical_history">{{ patient['medical_history'] }}</textarea><br>

        <label for="allergies">Allergies:</label>
        <textarea name="allergies">{{ patient['allergies'] }}</textarea><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active" {% if patient['status'] == 'active' %} selected {% endif %}>Active</option>
            <option value="inactive" {% if patient['status'] == 'inactive' %} selected {% endif %}>Inactive</option>
            <option value="deceased" {% if patient['status'] == 'deceased' %} selected {% endif %}>Deceased</option>
        </select><br>

        <button type="submit">Update Patient</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)