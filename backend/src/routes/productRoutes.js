const express = require('express');
const router = express.Router();
const { getProducts, getProductById } = require('../controllers/productController');

// Đường dẫn lấy tất cả sản phẩm: GET /api/products
router.get('/', getProducts);

// Đường dẫn lấy chi tiết 1 sản phẩm: GET /api/products/:id
router.get('/:id', getProductById);

module.exports = router;
