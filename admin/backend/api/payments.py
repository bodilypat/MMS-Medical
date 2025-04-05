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

# Create a new payment record (Create operation)
@app.route('/payments', methods=['POST'])
def create_payment():
    try:
        data = request.get_json()
        
        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()
        
        query = """
        INSERT INTO payments (patient_id, appointment_id, total_amount, amount_paid, balance_due, payment_status, 
        payment_date, insurance_claimed_amount, insurance_status, created_at, updated_at)
        VALUES (%s, %s, %s, %s, %s, %s, CURRENT_TIMESTAMP, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
        """
        values = (
            data['patient_id'], data['appointment_id'], data['total_amount'], data['amount_paid'], 
            data['balance_due'], data['payment_status'], data['insurance_claimed_amount'], data['insurance_status']
        )

        cursor.execute(query, values)
        connection.commit()
        
        return jsonify({'message': 'Payment record created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all payment records (Read operation)
@app.route('/payments', methods=['GET'])
def get_payments():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT * FROM payments")
        result = cursor.fetchall()

        payments = []
        for row in result:
            payment = {
                'billing_id': row[0],
                'patient_id': row[1],
                'appointment_id': row[2],
                'total_amount': row[3],
                'amount_paid': row[4],
                'balance_due': row[5],
                'payment_status': row[6],
                'payment_date': row[7],
                'insurance_claimed_amount': row[8],
                'insurance_status': row[9],
                'created_at': row[10],
                'updated_at': row[11]
            }
            payments.append(payment)

        return jsonify(payments), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific payment record by billing ID (Read operation)
@app.route('/payments/<int:billing_id>', methods=['GET'])
def get_payment(billing_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT * FROM payments WHERE billing_id = %s"
        cursor.execute(query, (billing_id,))
        result = cursor.fetchone()

        if result:
            payment = {
                'billing_id': result[0],
                'patient_id': result[1],
                'appointment_id': result[2],
                'total_amount': result[3],
                'amount_paid': result[4],
                'balance_due': result[5],
                'payment_status': result[6],
                'payment_date': result[7],
                'insurance_claimed_amount': result[8],
                'insurance_status': result[9],
                'created_at': result[10],
                'updated_at': result[11]
            }
            return jsonify(payment), 200
        else:
            return jsonify({'message': 'Payment record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update a payment record (Update operation)
@app.route('/payments/<int:billing_id>', methods=['PUT'])
def update_payment(billing_id):
    try:
        data = request.get_json()

        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()

        query = """
        UPDATE payments 
        SET patient_id = %s, appointment_id = %s, total_amount = %s, amount_paid = %s, balance_due = %s, 
        payment_status = %s, payment_date = CURRENT_TIMESTAMP, insurance_claimed_amount = %s, insurance_status = %s, 
        updated_at = CURRENT_TIMESTAMP
        WHERE billing_id = %s
        """
        values = (
            data['patient_id'], data['appointment_id'], data['total_amount'], data['amount_paid'],
            data['balance_due'], data['payment_status'], data['insurance_claimed_amount'], 
            data['insurance_status'], billing_id
        )

        cursor.execute(query, values)
        connection.commit()

        return jsonify({'message': 'Payment record updated successfully!'}), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a payment record (Delete operation)
@app.route('/payments/<int:billing_id>', methods=['DELETE'])
def delete_payment(billing_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM payments WHERE billing_id = %s"
        cursor.execute(query, (billing_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'Payment record deleted successfully!'}), 200
        else:
            return jsonify({'message': 'Payment record not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)