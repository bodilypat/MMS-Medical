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

# Create a new patient (Create operation)
@app.route('/patients', methods=['POST'])
def create_patient():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO patients (first_name, last_name, date_of_birth, gender, email, phone_number, address, insurance_provider, 
                              insurance_policy_number, primary_care_physician, medical_history, allergies, status)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        values = (
            data['first_name'], data['last_name'], data['date_of_birth'], data['gender'], data['email'],
            data['phone_number'], data['address'], data['insurance_provider'], data['insurance_policy_number'],
            data['primary_care_physician'], data['medical_history'], data['allergies'], data['status']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Patient created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all patients (Read operation)
@app.route('/patients', methods=['GET'])
def get_patients():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM patients")
        result = cursor.fetchall()

        patients = []
        for row in result:
            patient = {
                'patient_id': row[0],
                'first_name': row[1],
                'last_name': row[2],
                'date_of_birth': row[3],
                'gender': row[4],
                'email': row[5],
                'phone_number': row[6],
                'address': row[7],
                'insurance_provider': row[8],
                'insurance_policy_number': row[9],
                'primary_care_physician': row[10],
                'medical_history': row[11],
                'allergies': row[12],
                'status': row[13],
                'created_at': row[14],
                'updated_at': row[15]
            }
            patients.append(patient)

        return jsonify(patients), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific patient by ID (Read operation)
@app.route('/patients/<int:patient_id>', methods=['GET'])
def get_patient(patient_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM patients WHERE patient_id = %s"
        cursor.execute(query, (patient_id,))
        result = cursor.fetchone()

        if result:
            patient = {
                'patient_id': result[0],
                'first_name': result[1],
                'last_name': result[2],
                'date_of_birth': result[3],
                'gender': result[4],
                'email': result[5],
                'phone_number': result[6],
                'address': result[7],
                'insurance_provider': result[8],
                'insurance_policy_number': result[9],
                'primary_care_physician': result[10],
                'medical_history': result[11],
                'allergies': result[12],
                'status': result[13],
                'created_at': result[14],
                'updated_at': result[15]
            }
            return jsonify(patient), 200
        else:
            return jsonify({'message': 'Patient not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an existing patient (Update operation)
@app.route('/patients/<int:patient_id>', methods=['PUT'])
def update_patient(patient_id):
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        UPDATE patients SET first_name = %s, last_name = %s, date_of_birth = %s, gender = %s, email = %s,
                            phone_number = %s, address = %s, insurance_provider = %s, insurance_policy_number = %s,
                            primary_care_physician = %s, medical_history = %s, allergies = %s, status = %s
        WHERE patient_id = %s
        """
        values = (
            data['first_name'], data['last_name'], data['date_of_birth'], data['gender'], data['email'],
            data['phone_number'], data['address'], data['insurance_provider'], data['insurance_policy_number'],
            data['primary_care_physician'], data['medical_history'], data['allergies'], data['status'], patient_id
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Patient updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a patient (Delete operation)
@app.route('/patients/<int:patient_id>', methods=['DELETE'])
def delete_patient(patient_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM patients WHERE patient_id = %s"
        cursor.execute(query, (patient_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Patient deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Patient not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)