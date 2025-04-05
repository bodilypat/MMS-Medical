from flask import Flask, request, jsonify
import mysql.connector

app = Flask(__name__)

# Database connection details
host = 'localhost'
database = 'MEDICAL'
user = 'root'
password = 'password'

# Helper function to create a MySQL connection
def create_connection():
    return mysql.connector.connect(
        host=host,
        database=database,
        user=user,
        password=password
    )

# Create a new doctor (Create operation)
@app.route('/doctors', methods=['POST'])
def create_doctor():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        values = (
            data['first_name'], data['last_name'], data['specialization'], data['email'], data['phone_number'],
            data['department'], data['birthdate'], data['address'], data['status'], data['notes']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Doctor created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all doctors (Read operation)
@app.route('/doctors', methods=['GET'])
def get_doctors():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM doctors")
        result = cursor.fetchall()

        doctors = []
        for row in result:
            doctor = {
                'doctor_id': row[0],
                'first_name': row[1],
                'last_name': row[2],
                'specialization': row[3],
                'email': row[4],
                'phone_number': row[5],
                'department': row[6],
                'birthdate': row[7],
                'address': row[8],
                'status': row[9],
                'notes': row[10],
                'created_at': row[11],
                'updated_at': row[12]
            }
            doctors.append(doctor)

        return jsonify(doctors), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific doctor by ID (Read operation)
@app.route('/doctors/<int:doctor_id>', methods=['GET'])
def get_doctor(doctor_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM doctors WHERE doctor_id = %s"
        cursor.execute(query, (doctor_id,))
        result = cursor.fetchone()

        if result:
            doctor = {
                'doctor_id': result[0],
                'first_name': result[1],
                'last_name': result[2],
                'specialization': result[3],
                'email': result[4],
                'phone_number': result[5],
                'department': result[6],
                'birthdate': result[7],
                'address': result[8],
                'status': result[9],
                'notes': result[10],
                'created_at': result[11],
                'updated_at': result[12]
            }
            return jsonify(doctor), 200
        else:
            return jsonify({'message': 'Doctor not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an existing doctor (Update operation)
@app.route('/doctors/<int:doctor_id>', methods=['PUT'])
def update_doctor(doctor_id):
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        UPDATE doctors SET first_name = %s, last_name = %s, specialization = %s, email = %s, phone_number = %s,
                            department = %s, birthdate = %s, address = %s, status = %s, notes = %s
        WHERE doctor_id = %s
        """
        values = (
            data['first_name'], data['last_name'], data['specialization'], data['email'], data['phone_number'],
            data['department'], data['birthdate'], data['address'], data['status'], data['notes'], doctor_id
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Doctor updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a doctor (Delete operation)
@app.route('/doctors/<int:doctor_id>', methods=['DELETE'])
def delete_doctor(doctor_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM doctors WHERE doctor_id = %s"
        cursor.execute(query, (doctor_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Doctor deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Doctor not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)