import mysql.connector

# Establish the connection
connection = mysql.connector.connect(
      host = "localhost",
      user = "username",
      password = "pacha",
      database = "dbmedical"
)

# Check if the connection was successful
if( conenction.is_connected():
     print("Connected to MySQL database")

# Close the Connection 
connection.close()
