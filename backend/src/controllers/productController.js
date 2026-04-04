const Product = require('../models/Product');

// 1. DỮ LIỆU MẪU (MOCK DATA)
const mockProducts = [
  {
    _id: "1",
    name: "Nike Air Force 1 '07",
    price: 2900000,
    image: "https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/air-force-1-07-shoes-Wr0Q17.png",
    description: "Đôi giày huyền thoại phong cách cổ điển, dễ phối đồ.",
    category: "Nike",
    countInStock: 10,
    rating: 4.5,
    numReviews: 12
  },
  {
    _id: "2",
    name: "Adidas Superstar",
    price: 2500000,
    image: "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/7ed5b20b0a044949a2a4ad92011b6417_9366/Giay_Superstar_trang_EG4958_01_standard.jpg",
    description: "Mũi giày vỏ sò đặc trưng, phong cách Retro.",
    category: "Adidas",
    countInStock: 5,
    rating: 4.0,
    numReviews: 8
  },
  {
    _id: "3",
    name: "Jordan 1 Retro High",
    price: 5200000,
    image: "https://myshoes.vn/image/cache/catalog/2023/nike/j1/giay-nike-air-jordan-1-low-panda-nam-nu-01-800x800.jpg",
    description: "Phiên bản cao cổ thời thượng, biểu tượng của văn hóa Sneaker.",
    category: "Jordan",
    countInStock: 0,
    rating: 5.0,
    numReviews: 20
  }
];

// 2. Lấy toàn bộ danh sách sản phẩm
const getProducts = async (req, res) => {
  try {
    const products = await Product.find({});
    
    // Nếu Database có dữ liệu, trả về dữ liệu thật. Nếu trống, trả về Mock Data.
    if (products && products.length > 0) {
      res.json(products);
    } else {
      res.json(mockProducts);
    }
  } catch (error) {
    // Trường hợp lỗi kết nối DB, vẫn trả về Mock Data để Frontend không bị lỗi giao diện
    res.json(mockProducts);
  }
};

// 3. Lấy chi tiết sản phẩm theo ID
const getProductById = async (req, res) => {
  try {
    const product = await Product.findById(req.params.id);
    
    if (product) {
      res.json(product);
    } else {
      // Nếu không tìm thấy trong DB, kiểm tra trong Mock Data
      const mockProduct = mockProducts.find(p => p._id === req.params.id);
      if (mockProduct) {
        res.json(mockProduct);
      } else {
        res.status(404).json({ message: "Sản phẩm không tồn tại" });
      }
    }
  } catch (error) {
    // Xử lý khi ID truyền lên không đúng định dạng hoặc lỗi DB
    const mockProduct = mockProducts.find(p => p._id === req.params.id);
    if (mockProduct) return res.json(mockProduct);
    
    res.status(500).json({ message: "ID sản phẩm không hợp lệ" });
  }
};

module.exports = { getProducts, getProductById };
