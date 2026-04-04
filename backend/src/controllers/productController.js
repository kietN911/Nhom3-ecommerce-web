const Product = require('../models/Product');

// Lấy toàn bộ danh sách sản phẩm
const getProducts = async (req, res) => {
    try {
        const products = await Product.find({});
        res.json(products);
    } catch (error) {
        res.status(500).json({ message: "Lỗi hệ thống khi lấy sản phẩm" });
    }
};

// Lấy chi tiết một sản phẩm theo ID
const getProductById = async (req, res) => {
    try {
        const product = await Product.findById(req.params.id);
        if (product) {
            res.json(product);
        } else {
            res.status(404).json({ message: "Không tìm thấy sản phẩm" });
        }
    } catch (error) {
        res.status(500).json({ message: "ID sản phẩm không hợp lệ" });
    }
};

module.exports = { getProducts, getProductById };
