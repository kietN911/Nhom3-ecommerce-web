const express = require("express");
const cors = require("cors");

const app = express();
app.use(cors());

const users = [
  { id: 1, name: "Nguyễn Hoài Anh Kiệt" },
  { id: 2, name: "Võ Thành Lộc"},
  { id: 3, name: "Nguyễn Lê Huy"},
  { id: 4, name: "Lê Nguyễn Chí Bảo"},
  { id: 5, name: "Chung Thành Đạt"},
  { id: 6, name: "Tạ Minh Hậu"}
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