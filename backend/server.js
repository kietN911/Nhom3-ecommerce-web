const express = require("express");
const cors = require("cors");
const productRoutes = require("./src/routes/productRoutes");
require("dotenv").config();
const connectDB = require("./config/db");

const app = express();
app.use(cors());
app.use(express.json());

connectDB();

// Kết nối API
app.use("/api/products", require("./src/routes/productRoutes"));

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
  console.log("Server running");
});

app.use("/api/auth", require("./src/routes/auth"));