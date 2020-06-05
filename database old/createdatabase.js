// requerer mysql node.js
var mysql = require("mysql");

// criar ligação à database
var con = mysql.createConnection({
  host: "localhost",
  port: 3308,
  user: "root",
  password: "Naoseiopass598",
  database: "hoteldata",
  multipleStatements: true,
});

con.connect(function (err) {
  if (err) throw err;
  console.log("Connected!");
});

// função get_info
function get_info(row, callback) {
  con.query("SELECT * FROM hotels", function (err, result) {
    if (err) {
      throw err;
    }
    return callback(result[row].id);
  });
}

// loop que usa a função get_info para ir buscar os id's dos hoteis e de seguida criar e preencher as tabelas de preço
for (i = 0; i <= 8; i++) {
  get_info(i, function (result) {
    idd = result;
    var nometabela = "'hotelprice_" + idd + "'";

    con.query(
      "SET @tablename = " +
        nometabela +
        ";" +
        "CALL new_hotelprice (@tablename);" +
        "CALL pop_hotelprice (@tablename)",

      function (err, result) {
        if (err) throw err;
      }
    );

    console.log("Table " + nometabela + " created");
  });
}

// kill processo
setTimeout(function () {
  return process.exit(22);
}, 5000);
