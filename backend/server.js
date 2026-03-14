const express = require("express");
const cors = require("cors");

const app = express();
app.use(cors());

const users = [
  { id: 1, name: "Kiệt", email: "kiet@gmail.com" },
  { id: 2, name: "User2", email: "user2@gmail.com" }
];

// lấy tất cả users
app.get("/users", (req, res) => {
  res.json(users);
});

// lấy user theo id
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
  console.log("Server running");
});