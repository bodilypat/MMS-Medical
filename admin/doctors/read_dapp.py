from flask import Flask, render_template, redirect, url_for
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)

# Database connection configuration
db_config = {
    'host': 'psmedical',        # Replace with your database host
    'user': 'pacha',        # Replace with your database username
    'password': 'medical', # Replace with your database password
    'database': 'dbmedical'  # Replace with your database name
}

@app.route('/doctors')
def doctors():
    conn = None
    cursor = None
    doctors_list = []

    try:
        # Establish database connection
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor(dictionary=True)

        # Fetch all doctors from the database
        cursor.execute("SELECT * FROM doctors")
        doctors_list = cursor.fetchall()

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
    <title>Doctors List</title>
</head>
<body>
    <h2>Doctors List</h2>

    {% if doctors %}
        <table border="1">
            <thead>
                <tr>
                    <th>Doctor ID</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {% for doctor in doctors %}
                <tr>
                    <td>{{ doctor['doctor_id'] }}</td>
                    <td>{{ doctor['first_name'] }} {{ doctor['last_name'] }}</td>
                    <td>{{ doctor['specialization'] }}</td>
                    <td>{{ doctor['email'] }}</td>
                    <td>{{ doctor['phone_number'] }}</td>
                    <td>{{ doctor['department'] }}</td>
                    <td>{{ doctor['status'] }}</td>
                    <td>
                        <a href="{{ url_for('update_doctor', doctor_id=doctor['doctor_id']) }}">Edit</a> |
                        <a href="{{ url_for('delete_doctor', doctor_id=doctor['doctor_id']) }}">Delete</a>
                    </td>
                </tr>
                {% endfor %}
            </tbody>
        </table>
    {% else %}
        <p>No doctors found.</p>
    {% endif %}

</body>
</html>
'''


    # Render template with doctors' data
    return render_template('doctors.html', doctors=doctors_list)

@app.route('/update_doctor/<int:doctor_id>')
def update_doctor(doctor_id):
    # Handle doctor update logic here (omitted for brevity)
    return f"Update doctor with ID: {doctor_id}"

@app.route('/delete_doctor/<int:doctor_id>')
def delete_doctor(doctor_id):
    # Handle doctor delete logic here (omitted for brevity)
    return f"Delete doctor with ID: {doctor_id}"

if __name__ == '__main__':
    app.run(debug=True)
 