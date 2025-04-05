from flask import Flask, request, jsonify
import mysql.connector
from werkzeug.security import generate_password_hash, check_password_hash

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

# Create a new user (Create operation)
@app.route('/users', methods=['POST'])
def create_user():
    try:
        data = request.get_json()
        username = data['username']
        email = data['email']
        password = data['password']
        role = data.get('role', 'user')  # Default to 'user' if no role is specified

        # Hash the password before saving it to the database
        hashed_password = generate_password_hash(password, method='sha256')

        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()

        query = """
        INSERT INTO users (username, email, password, role, created_at, updated_at)
        VALUES (%s, %s, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
        """
        values = (username, email, hashed_password, role)

        cursor.execute(query, values)
        connection.commit()

        return jsonify({'message': 'User created successfully!'}), 201
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get all users (Read operation)
@app.route('/users', methods=['GET'])
def get_users():
    try:
        connection = create_connection()
        cursor = connection.cursor()

        cursor.execute("SELECT id, username, email, role, created_at, updated_at FROM users")
        result = cursor.fetchall()

        users = []
        for row in result:
            user = {
                'id': row[0],
                'username': row[1],
                'email': row[2],
                'role': row[3],
                'created_at': row[4],
                'updated_at': row[5]
            }
            users.append(user)

        return jsonify(users), 200
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Get a specific user by ID (Read operation)
@app.route('/users/<int:user_id>', methods=['GET'])
def get_user(user_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "SELECT id, username, email, role, created_at, updated_at FROM users WHERE id = %s"
        cursor.execute(query, (user_id,))
        result = cursor.fetchone()

        if result:
            user = {
                'id': result[0],
                'username': result[1],
                'email': result[2],
                'role': result[3],
                'created_at': result[4],
                'updated_at': result[5]
            }
            return jsonify(user), 200
        else:
            return jsonify({'message': 'User not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Update a user (Update operation)
@app.route('/users/<int:user_id>', methods=['PUT'])
def update_user(user_id):
    try:
        data = request.get_json()
        username = data.get('username')
        email = data.get('email')
        password = data.get('password')
        role = data.get('role')

        # If password is provided, hash it
        if password:
            hashed_password = generate_password_hash(password, method='sha256')
        else:
            hashed_password = None

        # Connect to MySQL
        connection = create_connection()
        cursor = connection.cursor()

        query = """
        UPDATE users
        SET username = COALESCE(%s, username), email = COALESCE(%s, email), role = COALESCE(%s, role), password = COALESCE(%s, password), updated_at = CURRENT_TIMESTAMP
        WHERE id = %s
        """
        values = (username, email, role, hashed_password, user_id)

        cursor.execute(query, values)
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'User updated successfully!'}), 200
        else:
            return jsonify({'message': 'User not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

# Delete a user (Delete operation)
@app.route('/users/<int:user_id>', methods=['DELETE'])
def delete_user(user_id):
    try:
        connection = create_connection()
        cursor = connection.cursor()

        query = "DELETE FROM users WHERE id = %s"
        cursor.execute(query, (user_id,))
        connection.commit()

        if cursor.rowcount > 0:
            return jsonify({'message': 'User deleted successfully!'}), 200
        else:
            return jsonify({'message': 'User not found'}), 404
    except mysql.connector.Error as err:
        return jsonify({'error': f"Error: {err}"}), 500
    finally:
        cursor.close()
        connection.close()

if __name__ == '__main__':
    app.run(debug=True)