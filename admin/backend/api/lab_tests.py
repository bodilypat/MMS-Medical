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

# Create a new lab test (Create operation)
@app.route('/lab_tests', methods=['POST'])
def create_lab_test():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO lab_tests (patient_id, appointment_id, test_name, test_date, results, test_status, created_at, updated_at)
        VALUES (%s, %s, %s, %s, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
        """
        values = (
            data['patient_id'], data['appointment_id'], data['test_name'], data['test_date'],
            data['results'], data['test_status']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Lab test created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all lab tests (Read operation)
@app.route('/lab_tests', methods=['GET'])
def get_lab_tests():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM lab_tests")
        result = cursor.fetchall()

        lab_tests = []
        for row in result:
            lab_test = {
                'test_id': row[0],
                'patient_id': row[1],
                'appointment_id': row[2],
                'test_name': row[3],
                'test_date': row[4],
                'results': row[5],
                'test_status': row[6],
                'created_at': row[7],
                'updated_at': row[8]
            }
            lab_tests.append(lab_test)

        return jsonify(lab_tests), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific lab test by ID (Read operation)
@app.route('/lab_tests/<int:test_id>', methods=['GET'])
def get_lab_test(test_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM lab_tests WHERE test_id = %s"
        cursor.execute(query, (test_id,))
        result = cursor.fetchone()

        if result:
            lab_test = {
                'test_id': result[0],
                'patient_id': result[1],
                'appointment_id': result[2],
                'test_name': result[3],
                'test_date': result[4],
                'results': result[5],
                'test_status': result[6],
                'created_at': result[7],
                'updated_at': result[8]
            }
            return jsonify(lab_test), 200
        else:
            return jsonify({'message': 'Lab test not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an existing lab test (Update operation)
@app.route('/lab_tests/<int:test_id>', methods=['PUT'])
def update_lab_test(test_id):
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        UPDATE lab_tests 
        SET patient_id = %s, appointment_id = %s, test_name = %s, test_date = %s, results = %s, test_status = %s, updated_at = CURRENT_TIMESTAMP
        WHERE test_id = %s
        """
        values = (
            data['patient_id'], data['appointment_id'], data['test_name'], data['test_date'],
            data['results'], data['test_status'], test_id
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Lab test updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a lab test (Delete operation)
@app.route('/lab_tests/<int:test_id>', methods=['DELETE'])
def delete_lab_test(test_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM lab_tests WHERE test_id = %s"
        cursor.execute(query, (test_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Lab test deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Lab test not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)