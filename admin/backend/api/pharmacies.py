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

# Create a new pharmacy record (Create operation)
@app.route('/pharmacies', methods=['POST'])
def create_pharmacy():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO pharmacies (name, address, phone_number, email, created_at, updated_at)
        VALUES (%s, %s, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
        """
        values = (data['name'], data['address'], data['phone_number'], data['email'])

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Pharmacy record created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all pharmacy records (Read operation)
@app.route('/pharmacies', methods=['GET'])
def get_pharmacies():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM pharmacies")
        result = cursor.fetchall()

        pharmacies = []
        for row in result:
            pharmacy = {
                'pharmacy_id': row[0],
                'name': row[1],
                'address': row[2],
                'phone_number': row[3],
                'email': row[4],
                'created_at': row[5],
                'updated_at': row[6]
            }
            pharmacies.append(pharmacy)

        return jsonify(pharmacies), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific pharmacy record by pharmacy ID (Read operation)
@app.route('/pharmacies/<int:pharmacy_id>', methods=['GET'])
def get_pharmacy(pharmacy_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM pharmacies WHERE pharmacy_id = %s"
        cursor.execute(query, (pharmacy_id,))
        result = cursor.fetchone()

        if result:
            pharmacy = {
                'pharmacy_id': result[0],
                'name': result[1],
                'address': result[2],
                'phone_number': result[3],
                'email': result[4],
                'created_at': result[5],
                'updated_at': result[6]
            }
            return jsonify(pharmacy), 200
        else:
            return jsonify({'message': 'Pharmacy record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update a pharmacy record (Update operation)
@app.route('/pharmacies/<int:pharmacy_id>', methods=['PUT'])
def update_pharmacy(pharmacy_id):
    try:
        data = request.get_json()

        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()

        query = """
        UPDATE pharmacies 
        SET name = %s, address = %s, phone_number = %s, email = %s, updated_at = CURRENT_TIMESTAMP
        WHERE pharmacy_id = %s
        """
        values = (data['name'], data['address'], data['phone_number'], data['email'], pharmacy_id)

        cursor.execute(query, values)
        connection.commit()

        return jsonify({'message': 'Pharmacy record updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a pharmacy record (Delete operation)
@app.route('/pharmacies/<int:pharmacy_id>', methods=['DELETE'])
def delete_pharmacy(pharmacy_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM pharmacies WHERE pharmacy_id = %s"
        cursor.execute(query, (pharmacy_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Pharmacy record deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Pharmacy record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)