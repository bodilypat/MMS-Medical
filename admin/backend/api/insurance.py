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

# Create a new insurance record (Create operation)
@app.route('/insurance', methods=['POST'])
def create_insurance():
    try:
        data = request.get_json()

        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()

        query = """
        INSERT INTO insurance (provider_name, policy_number, coverage_type, coverage_amount, patient_id, start_date, end_date, created_at, updated_at)
        VALUES (%s, %s, %s, %s, %s, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
        """
        values = (data['provider_name'], data['policy_number'], data['coverage_type'], data['coverage_amount'], data['patient_id'], data['start_date'], data['end_date'])

        cursor.execute(query, values)
        connection.commit()

        return jsonify({'message': 'Insurance record created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all insurance records (Read operation)
@app.route('/insurance', methods=['GET'])
def get_insurances():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM insurance")
        result = cursor.fetchall()

        insurances = []
        for row in result:
            insurance = {
                'insurance_id': row[0],
                'provider_name': row[1],
                'policy_number': row[2],
                'coverage_type': row[3],
                'coverage_amount': row[4],
                'patient_id': row[5],
                'start_date': row[6],
                'end_date': row[7],
                'created_at': row[8],
                'updated_at': row[9]
            }
            insurances.append(insurance)

        return jsonify(insurances), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific insurance record by insurance ID (Read operation)
@app.route('/insurance/<int:insurance_id>', methods=['GET'])
def get_insurance(insurance_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM insurance WHERE insurance_id = %s"
        cursor.execute(query, (insurance_id,))
        result = cursor.fetchone()

        if result:
            insurance = {
                'insurance_id': result[0],
                'provider_name': result[1],
                'policy_number': result[2],
                'coverage_type': result[3],
                'coverage_amount': result[4],
                'patient_id': result[5],
                'start_date': result[6],
                'end_date': result[7],
                'created_at': result[8],
                'updated_at': result[9]
            }
            return jsonify(insurance), 200
        else:
            return jsonify({'message': 'Insurance record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update an insurance record (Update operation)
@app.route('/insurance/<int:insurance_id>', methods=['PUT'])
def update_insurance(insurance_id):
    try:
        data = request.get_json()

        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()

        query = """
        UPDATE insurance
        SET provider_name = %s, policy_number = %s, coverage_type = %s, coverage_amount = %s, patient_id = %s, start_date = %s, end_date = %s, updated_at = CURRENT_TIMESTAMP
        WHERE insurance_id = %s
        """
        values = (data['provider_name'], data['policy_number'], data['coverage_type'], data['coverage_amount'], data['patient_id'], data['start_date'], data['end_date'], insurance_id)

        cursor.execute(query, values)
        connection.commit()

        return jsonify({'message': 'Insurance record updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete an insurance record (Delete operation)
@app.route('/insurance/<int:insurance_id>', methods=['DELETE'])
def delete_insurance(insurance_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM insurance WHERE insurance_id = %s"
        cursor.execute(query, (insurance_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Insurance record deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Insurance record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)