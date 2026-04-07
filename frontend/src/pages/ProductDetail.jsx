import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

const ProductDetail = () => {
  const { id } = useParams();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      try {
        // ⚠️ chỉ chạy ở browser
        if (typeof window !== "undefined") {
          const cache = localStorage.getItem("products");

          if (cache) {
            const data = JSON.parse(cache);

            const found = data.find(
              (item) =>
                String(item.id) === String(id) ||
                String(item._id) === String(id)
            );

            if (found) {
              setProduct(found);
              setLoading(false);
              return;
            }
          }
        }

        // 👉 fallback gọi API
        const res = await axios.get(
          process.env.REACT_APP_API
        );

        const found = res.data.find(
          (item) =>
            String(item.id) === String(id) ||
            String(item._id) === String(id)
        );

        setProduct(found);
        setLoading(false);

      } catch (err) {
        console.log(err);
        setLoading(false);
      }
    };

    fetchData();
  }, [id]);

  if (loading) return <h3 className="text-center mt-5">Đang tải...</h3>;

  if (!product) return <h3 className="text-center mt-5">Không tìm thấy sản phẩm</h3>;

  return (
    <div className="container my-5">
      <div className="row">

        <div className="col-md-6">
          <img
            src={product.image}
            alt={product.name}
            className="img-fluid rounded shadow"
            style={{ maxHeight: "400px", objectFit: "cover" }}
          />
        </div>

        <div className="col-md-6">
          <h2 className="fw-bold">{product.name}</h2>

          <h3 className="text-danger my-3">
            {product.price.toLocaleString()}₫
          </h3>

          <p>{product.description}</p>

          <p><strong>Danh mục:</strong> {product.category}</p>
          <p><strong>Còn lại:</strong> {product.countInStock}</p>
          <p><strong>Đánh giá:</strong> ⭐ {product.rating}</p>

          <button className="btn btn-dark mt-3 px-4">
            🛒 Thêm vào giỏ hàng
          </button>
        </div>

      </div>
    </div>
  );
};

export default ProductDetail;