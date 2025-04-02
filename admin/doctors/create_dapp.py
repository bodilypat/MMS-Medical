from flask import Flask, request, render_template_string
import mysql.connector

app = Flask(__name__)

# Database connection configuration
db_config = {
    'host': 'psmedical.com',
    'user': 'pacha',
    'password': 'medical',
    'database': 'dbmedical'
}

# Route for creating doctor
@app.route('/create_doctor', methods=['GET', 'POST'])
def create_doctor():
    if request.method == 'POST':
        # Collect form data
        first_name = request.form['first_name']
        last_name = request.form['last_name']
        specialization = request.form['specialization']
        email = request.form['email']
        phone_number = request.form['phone_number']
        department = request.form['department']
        birthdate = request.form['birthdate']
        address = request.form['address']
        status = request.form['status']
        notes = request.form['notes']

        # Establish database connection
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Insert query
        query = """
        INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        try:
            # Execute the query
            cursor.execute(query, (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes))
            conn.commit()
            message = "New doctor record created successfully."
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
    <title>Create Doctor</title>
</head>
<body>
    <h2>Create Doctor</h2>
    {% if message %}
        <p>{{ message }}</p>
    {% endif %}

    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="text" name="specialization" placeholder="Specialization" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone_number" placeholder="Phone Number" required><br>
        <input type="text" name="department" placeholder="Department"><br>
        <input type="date" name="birthdate" placeholder="Birthdate"><br>
        <textarea name="address" placeholder="Address"></textarea><br>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="retired">Retired</option>
        </select><br>
        <textarea name="notes" placeholder="Notes"></textarea><br>

        <button type="submit">Create Doctor</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)
