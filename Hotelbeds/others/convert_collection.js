db.teste.find({ title: { $type: "string" } }).forEach(function (x) {
  x.title = new NumberDecimal(x.title);
  db.teste.save(x);
});
