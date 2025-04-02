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

# Route for creating patient
@app.route('/create_patient', methods=['GET', 'POST'])
def create_patient():
    if request.method == 'POST':
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

        # Establish database connection
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Insert query
        query = """
        INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, 
                              insurance_provider, insurance_policy_number, primary_care_physician, medical_history, 
                              allergies, status)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        try:
            # Execute the query
            cursor.execute(query, (first_name, last_name, date_of_birth, gender, email, phone_number, address, 
                                   insurance_provider, insurance_policy_number, primary_care_physician, medical_history, 
                                   allergies, status))
            conn.commit()
            message = "New patient record created successfully."
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
    <title>Create Patient</title>
</head>
<body>
    <h2>Create Patient</h2>
    {% if message %}
        <p>{{ message }}</p>
    {% endif %}

    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="date" name="date_of_birth" required><br>
        
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>
        
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="phone_number" placeholder="Phone Number" required><br>
        <input type="text" name="address" placeholder="Address"><br>
        <input type="text" name="insurance_provider" placeholder="Insurance Provider"><br>
        <input type="text" name="insurance_policy_number" placeholder="Insurance Policy Number"><br>
        <input type="text" name="primary_care_physician" placeholder="Primary Care Physician"><br>
        <textarea name="medical_history" placeholder="Medical History"></textarea><br>
        <textarea name="allergies" placeholder="Allergies"></textarea><br>
        
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="deceased">Deceased</option>
        </select><br>

        <button type="submit">Create Patient</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)