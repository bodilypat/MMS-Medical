from flask import Flask, request, render_template_string, redirect, url_for
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

@app.route('/update_doctor/<int:doctor_id>', methods=['GET', 'POST'])
def update_doctor(doctor_id):
    conn = None
    cursor = None
    doctor = None

    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor(dictionary=True)

        if request.method == 'GET':
            # Fetch doctor data from database
            cursor.execute("SELECT * FROM doctors WHERE doctor_id = %s", (doctor_id,))
            doctor = cursor.fetchone()

            if not doctor:
                return "Doctor not found", 404  # Handle case where doctor is not found

            return render_template_string(TEMPLATE, doctor=doctor)

        elif request.method == 'POST':
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

            # Update query
            update_query = """
            UPDATE doctors
            SET first_name=%s, last_name=%s, specialization=%s, email=%s, phone_number=%s,
                department=%s, birthdate=%s, address=%s, status=%s, notes=%s
            WHERE doctor_id=%s
            """
            cursor.execute(update_query, (first_name, last_name, specialization, email, phone_number,
                                          department, birthdate, address, status, notes, doctor_id))
            conn.commit()

            return redirect(url_for('update_doctor', doctor_id=doctor_id))

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
    <title>Update Doctor</title>
</head>
<body>
    <h2>Update Doctor</h2>
    
    <form method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="{{ doctor['first_name'] }}" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ doctor['last_name'] }}" required><br>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" value="{{ doctor['specialization'] }}" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ doctor['email'] }}" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="{{ doctor['phone_number'] }}" required><br>

        <label for="department">Department:</label>
        <input type="text" name="department" value="{{ doctor['department'] }}"><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" value="{{ doctor['birthdate'] }}"><br>

        <label for="address">Address:</label>
        <textarea name="address">{{ doctor['address'] }}</textarea><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active" {% if doctor['status'] == 'active' %} selected {% endif %}>Active</option>
            <option value="inactive" {% if doctor['status'] == 'inactive' %} selected {% endif %}>Inactive</option>
            <option value="retired" {% if doctor['status'] == 'retired' %} selected {% endif %}>Retired</option>
        </select><br>

        <label for="notes">Notes:</label>
        <textarea name="notes">{{ doctor['notes'] }}</textarea><br>

        <button type="submit">Update Doctor</button>
    </form>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True)