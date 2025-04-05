import mysql.connector

# Database connection details
host = 'localhost'  # Replace with your host (e.g., localhost or an IP address)
database = 'MEDICAL'  # Replace with your database name
user = 'root'  # Replace with your MySQL username
password = 'password'  # Replace with your MySQL password

try:
    # Establish a connection to the database
    connection = mysql.connector.connect(
        host=host,
        database=database,
        user=user,
        password=password
    )
    
    if connection.is_connected():
        print(f"Successfully connected to the {database} database.")
        
        # Creating a cursor object using the connection
        cursor = connection.cursor()
        
        # Example query: Selecting data from the users table
        cursor.execute("SELECT * FROM users")
        
        # Fetch all the rows from the executed query
        result = cursor.fetchall()
        
        # Loop through the result and print each row
        for row in result:
            print(row)
        
        # Close the cursor and connection
        cursor.close()

except mysql.connector.Error as err:
    print(f"Error: {err}")
    
finally:
    # Close the connection if it's open
    if connection.is_connected():
        connection.close()
        print("MySQL connection is closed.")