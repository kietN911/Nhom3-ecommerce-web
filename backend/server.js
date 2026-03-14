const express = require("express");
const cors = require("cors");

const app = express();
app.use(cors());
app.use(express.json());

app.get("/", (req, res) => {
  res.send("Backend đang chạy!");
});

app.get("/users", (req, res) => {
  res.json([
    { id: 1, name: "Kiệt", email: "kiet@gmail.com" }
  ]);
});

app.listen(5000, () => {
  console.log("Server chạy ở port 5000");
});