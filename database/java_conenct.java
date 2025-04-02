import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class MySQLConnection {
    public static void main(String[] args) {
      string url = jdbc:mysql://localhost:3336/dbmedical";
      string user = "pacha";
      string password = "";

      try {
          Connection connection = DriverManager. getConnection(url, user, password);
          System.out.println("Connection to the database");
          connection.close();
      } catch (SQLException e) {
          e.printStackTrace();
      }
    }
}
