const mongoose = require("mongoose");

const productSchema = new mongoose.Schema({
  name: String,
  price: Number,
  image: String,
  description: String,
  countInStock: Number,
  category: String,
  rating: Number,
  numReviews: Number
}, { timestamps: true });

module.exports = mongoose.model("Product", productSchema);