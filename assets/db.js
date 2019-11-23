var mysql = require('mysql');
var conn = mysql.createConnection({
    host: "remotemysql.com",
    user: "fIH3AfGhcO",
    pass: "oTS3WjYJ1k"
});
conn.connect(function(err) {
    if (err) throw err;
    console.log("connected to " + host);
});