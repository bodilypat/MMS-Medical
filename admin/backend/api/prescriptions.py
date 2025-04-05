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

# Create a new prescription (Create operation)
@app.route('/prescriptions', methods=['POST'])
def create_prescription():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO prescriptions (record_id, medication_name, dosage, frequency, start_date, end_date, instructions, status, created_by, updated_by)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        values = (
            data['record_id'], data['medication_name'], data['dosage'], data['frequency'],
            data['start_date'], data['end_date'], data['instructions'], data['status'], 
            data['created_by'], data['updated_by']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Prescription created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all prescriptions (Read operation)
@app.route('/prescriptions', methods=['GET'])
def get_prescriptions():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM prescriptions")
        result = cursor.fetchall()

        prescriptions = []
        for row in result:
            prescription = {
                'prescription_id': row[0],
                'record_id': row[1],
                'medication_name': row[2],
                'dosage': row[3],
                'frequency': row[4],
                'start_date': row[5],
                'end_date': row[6],
                'instructions': row[7],
                'status': row[8],
                'created_at': row[9],
                'updated_at': row[10],
                'created_by': row[11],
                'updated_by': row[12]
            }
            prescriptions.append(prescription)

        return jsonify(prescriptions), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific prescription by ID (Read operation)
@app.route('/prescriptions/<int:prescription_id>', methods=['GET'])
def get_prescription(prescription_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM prescriptions WHERE prescription_id = %s"
        cursor.execute(query, (prescription_id,))
        result = cursor.fetchone()

        if result:
            prescription = {
                'prescription_id': result[0],
                'record_id': result[1],
                'medication_name': result[2],
                'dosage': result[3],
                'frequency': result[4],
                'start_date': result[5],
                'end_date': result[6],
                'instructions': result[7],
                'status': result[8],
                'created_at': result[9],
                'updated_at': result[10],
                'created_by': result[11],
                'updated_by': result[12]
            }
            return jsonify(prescription), 200
        else:
            return jsonify({'message': 'Prescription not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an existing prescription (Update operation)
@app.route('/prescriptions/<int:prescription_id>', methods=['PUT'])
def update_prescription(prescription_id):
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        UPDATE prescriptions 
        SET record_id = %s, medication_name = %s, dosage = %s, frequency = %s, start_date = %s, 
            end_date = %s, instructions = %s, status = %s, updated_by = %s
        WHERE prescription_id = %s
        """
        values = (
            data['record_id'], data['medication_name'], data['dosage'], data['frequency'],
            data['start_date'], data['end_date'], data['instructions'], data['status'],
            data['updated_by'], prescription_id
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Prescription updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a prescription (Delete operation)
@app.route('/prescriptions/<int:prescription_id>', methods=['DELETE'])
def delete_prescription(prescription_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM prescriptions WHERE prescription_id = %s"
        cursor.execute(query, (prescription_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Prescription deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Prescription not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)