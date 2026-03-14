const express = require("express");
const cors = require("cors");

const app = express();
app.use(cors());
app.use(express.json());

const users = [
  { id: 1, name: "Kiệt" },
  { id: 2, name: "User2" }
];

// Lấy tất cả users
app.get("/users", (req, res) => {
  res.json(users);
});

// Lấy user theo id
app.get("/users/:id", (req, res) => {
  const id = parseInt(req.params.id);
  const user = users.find(u => u.id === id);

  if (!user) {
    return res.status(404).json({ message: "User not found" });
  }

  res.json(user);
});

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
  console.log("Server running on port " + PORT);
});