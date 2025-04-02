using System;
using MySql.Data.MySqlClient;

namespace MySQLConnectionExample
{
    public class DatabaseHelper
    {
        private string connectionString;

        // Constructor to initialize the connection string
        public DatabaseHelper(string host, string username, string password, string database)
        {
            connectionString = $"Server={host}; database={database}; UID={username}; password={password};";
        }

        // Method to open the database connection
        public MySqlConnection GetConnection()
        {
            return new MySqlConnection(connectionString);
        }

        // Method to execute a simple SELECT query and return the results
        public void ExecuteQuery(string query)
        {
            using (var connection = GetConnection())
            {
                try
                {
                    connection.Open();
                    MySqlCommand command = new MySqlCommand(query, connection);

                    // Execute the query and read the result
                    using (var reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            Console.WriteLine(reader.GetString(0));  // Assuming the result is a single column
                        }
                    }
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
        }

        // Method to execute an INSERT query
        public void ExecuteInsert(string query)
        {
            using (var connection = GetConnection())
            {
                try
                {
                    connection.Open();
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.ExecuteNonQuery();
                    Console.WriteLine("Insert operation successful.");
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            // Database credentials
            string host = "localhost";
            string username = "your_username";
            string password = "your_password";
            string database = "your_database";

            // Initialize the DatabaseHelper class
            DatabaseHelper dbHelper = new DatabaseHelper(host, username, password, database);

            // Example: SELECT query
            string selectQuery = "SELECT column_name FROM your_table";
            dbHelper.ExecuteQuery(selectQuery);

            // Example: INSERT query
            string insertQuery = "INSERT INTO your_table (column_name) VALUES ('value')";
            dbHelper.ExecuteInsert(insertQuery);
        }
    }
}