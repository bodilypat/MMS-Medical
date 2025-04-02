const mysql = require('mysqli);
const connection = mysql.createConnection({
      host: 'locahost',
      user: 'pacha',
      password: '',
      database: 'dbmedical'
});

conenction.connect((err) => {
  if(err) {
      console.error("Error connecting: ' + err.stack);
      return;
  }
  console.log('Conected as id ' + connection.threadId);
});
// Close the connection
connection.end();
