const express = require("express");
const cors = require("cors");
const productRoutes = require("./src/routes/productRoutes");

const app = express();
app.use(cors());
app.use(express.json());

// Kết nối API
app.use("/api/products", productRoutes);

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
  console.log("Server running");
});
