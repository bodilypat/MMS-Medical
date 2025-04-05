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

# Create a new medical record (Create operation)
@app.route('/medical_records', methods=['POST'])
def create_medical_record():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO medical_records (patient_id, appointment_id, diagnosis, treatment_plan, note, status, created_by, updated_by, attachments)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        values = (
            data['patient_id'], data['appointment_id'], data['diagnosis'], data['treatment_plan'], 
            data['note'], data['status'], data['created_by'], data['updated_by'], data['attachments']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Medical record created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all medical records (Read operation)
@app.route('/medical_records', methods=['GET'])
def get_medical_records():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM medical_records")
        result = cursor.fetchall()

        medical_records = []
        for row in result:
            medical_record = {
                'record_id': row[0],
                'patient_id': row[1],
                'appointment_id': row[2],
                'diagnosis': row[3],
                'treatment_plan': row[4],
                'note': row[5],
                'status': row[6],
                'created_at': row[7],
                'updated_at': row[8],
                'created_by': row[9],
                'updated_by': row[10],
                'attachments': row[11]
            }
            medical_records.append(medical_record)

        return jsonify(medical_records), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific medical record by ID (Read operation)
@app.route('/medical_records/<int:record_id>', methods=['GET'])
def get_medical_record(record_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM medical_records WHERE record_id = %s"
        cursor.execute(query, (record_id,))
        result = cursor.fetchone()

        if result:
            medical_record = {
                'record_id': result[0],
                'patient_id': result[1],
                'appointment_id': result[2],
                'diagnosis': result[3],
                'treatment_plan': result[4],
                'note': result[5],
                'status': result[6],
                'created_at': result[7],
                'updated_at': result[8],
                'created_by': result[9],
                'updated_by': result[10],
                'attachments': result[11]
            }
            return jsonify(medical_record), 200
        else:
            return jsonify({'message': 'Medical record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an existing medical record (Update operation)
@app.route('/medical_records/<int:record_id>', methods=['PUT'])
def update_medical_record(record_id):
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        UPDATE medical_records SET patient_id = %s, appointment_id = %s, diagnosis = %s, treatment_plan = %s, 
                                  note = %s, status = %s, updated_by = %s, attachments = %s
        WHERE record_id = %s
        """
        values = (
            data['patient_id'], data['appointment_id'], data['diagnosis'], data['treatment_plan'], data['note'],
            data['status'], data['updated_by'], data['attachments'], record_id
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Medical record updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a medical record (Delete operation)
@app.route('/medical_records/<int:record_id>', methods=['DELETE'])
def delete_medical_record(record_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM medical_records WHERE record_id = %s"
        cursor.execute(query, (record_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Medical record deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Medical record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)