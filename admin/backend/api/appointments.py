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

# Create a new appointment (Create operation)
@app.route('/appointments', methods=['POST'])
def create_appointment():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason_for_visit, status, duration, appointment_type, notes)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
        """
        values = (
            data['patient_id'], data['doctor_id'], data['appointment_date'], data['reason_for_visit'],
            data['status'], data['duration'], data['appointment_type'], data['notes']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Appointment created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all appointments (Read operation)
@app.route('/appointments', methods=['GET'])
def get_appointments():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM appointments")
        result = cursor.fetchall()

        appointments = []
        for row in result:
            appointment = {
                'appointment_id': row[0],
                'patient_id': row[1],
                'doctor_id': row[2],
                'appointment_date': row[3],
                'reason_for_visit': row[4],
                'status': row[5],
                'duration': row[6],
                'appointment_type': row[7],
                'notes': row[8],
                'created_at': row[9],
                'updated_at': row[10]
            }
            appointments.append(appointment)

        return jsonify(appointments), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific appointment by ID (Read operation)
@app.route('/appointments/<int:appointment_id>', methods=['GET'])
def get_appointment(appointment_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM appointments WHERE appointment_id = %s"
        cursor.execute(query, (appointment_id,))
        result = cursor.fetchone()

        if result:
            appointment = {
                'appointment_id': result[0],
                'patient_id': result[1],
                'doctor_id': result[2],
                'appointment_date': result[3],
                'reason_for_visit': result[4],
                'status': result[5],
                'duration': result[6],
                'appointment_type': result[7],
                'notes': result[8],
                'created_at': result[9],
                'updated_at': result[10]
            }
            return jsonify(appointment), 200
        else:
            return jsonify({'message': 'Appointment not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an existing appointment (Update operation)
@app.route('/appointments/<int:appointment_id>', methods=['PUT'])
def update_appointment(appointment_id):
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        UPDATE appointments SET patient_id = %s, doctor_id = %s, appointment_date = %s, reason_for_visit = %s, 
                              status = %s, duration = %s, appointment_type = %s, notes = %s
        WHERE appointment_id = %s
        """
        values = (
            data['patient_id'], data['doctor_id'], data['appointment_date'], data['reason_for_visit'], data['status'],
            data['duration'], data['appointment_type'], data['notes'], appointment_id
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Appointment updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete an appointment (Delete operation)
@app.route('/appointments/<int:appointment_id>', methods=['DELETE'])
def delete_appointment(appointment_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM appointments WHERE appointment_id = %s"
        cursor.execute(query, (appointment_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Appointment deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Appointment not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)