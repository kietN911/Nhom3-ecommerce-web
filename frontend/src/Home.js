import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from "react-router-dom";

const Home = () => {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  // Gọi API
  useEffect(() => {
  const fetchData = async () => {
    try {
      const res = await axios.get(process.env.REACT_APP_API);
      setProducts(res.data);
    } catch (err) {
      console.log(err);
    } finally {
      setLoading(false);
    }
  };

  fetchData();
}, []);

  return (
    <main className="flex-grow-1">
      {/* Hero Banner Carousel Section */}
      <section id="heroCarousel" className="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
        <div className="carousel-inner">
          <div className="carousel-item active">
            <div className="text-white text-center d-flex align-items-center justify-content-center" style={{ height: '70vh', background: 'linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url("https://placehold.co/1920x1080/111/FFF?text=Banner+1") center/cover' }}>
              <div>
                <h1 className="display-4 fw-bold">Bộ Sưu Tập Giới Hạn</h1>
                <p className="lead">Trải nghiệm đỉnh cao cùng thiết bị chuyên nghiệp</p>
                <button className="btn btn-light btn-lg mt-3 rounded-pill px-5 fw-bold">Tìm hiểu thêm</button>
              </div>
            </div>
          </div>
          
          <div className="carousel-item">
            <div className="text-white text-center d-flex align-items-center justify-content-center" style={{ height: '70vh', background: 'linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url("https://placehold.co/1920x1080/333/FFF?text=Banner+2") center/cover' }}>
              <div>
                <h1 className="display-4 fw-bold">Gear Mới Cực Chất</h1>
                <p className="lead">Nâng tầm góc máy của bạn ngay hôm nay</p>
                <button className="btn btn-light btn-lg mt-3 rounded-pill px-5 fw-bold">Tìm hiểu thêm</button>
              </div>
            </div>
          </div>

          <div className="carousel-item">
            <div className="text-white text-center d-flex align-items-center justify-content-center" style={{ height: '70vh', background: 'linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url("https://placehold.co/1920x1080/555/FFF?text=Banner+3") center/cover' }}>
              <div>
                <h1 className="display-4 fw-bold">Hiệu Năng Vượt Trội</h1>
                <p className="lead">Sẵn sàng chinh phục mọi tựa game</p>
                <button className="btn btn-light btn-lg mt-3 rounded-pill px-5 fw-bold">Tìm hiểu thêm</button>
              </div>
            </div>
          </div>
        </div>
        
        <button className="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
          <span className="carousel-control-prev-icon" aria-hidden="true"></span>
          <span className="visually-hidden">Previous</span>
        </button>
        <button className="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
          <span className="carousel-control-next-icon" aria-hidden="true"></span>
          <span className="visually-hidden">Next</span>
        </button>
      </section>

      {/* Danh sách sản phẩm */}
      <section className="container my-5">
        <div className="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
          <div>
            <h2 className="fw-bold mb-1">Sản phẩm nổi bật</h2>
            <p className="text-muted mb-0">Danh sách sản phẩm mới nhất từ cửa hàng</p>
          </div>
        </div>

        {loading ? (
          <h3 className="text-center">Đang tải sản phẩm...</h3>
        ) : (
          <div className="row">
            {products.map((item) => (
              <div className="col-md-3 mb-4" key={item._id}>
                <div className="card h-100 shadow-sm">

                  <img
                    src={item.image}
                    alt={item.name}
                    loading="lazy"
                    className="card-img-top"
                    style={{ height: "200px", objectFit: "cover" }}
                  />

                  <div className="card-body text-center">
                    <h6 className="fw-bold">{item.name}</h6>
                    <p className="text-danger fw-bold">{item.price}₫</p>

                    <Link
                      to={`/product/${item._id}`}
                      className="btn btn-dark btn-sm"
                    >
                      Xem chi tiết
                    </Link>
                  </div>

                </div>
              </div>
            ))}
          </div>
        )}
      </section>

      {/* 4 Lý do Section */}
      <section className="bg-light py-5">
        <div className="container text-center">
          <h3 className="fw-bold mb-5">4 lý do anh em tin tưởng GEAR</h3>
          <div className="row">
            <div className="col-md-3 mb-4">
              <div className="display-4 mb-3 text-primary">🤝</div>
              <h5 className="fw-bold">Hiểu bạn trước khi bán</h5>
              <p className="small text-muted">Tư vấn chuẩn xác theo nhu cầu, grip style, form tay, ngân sách.</p>
            </div>
            <div className="col-md-3 mb-4">
              <div className="display-4 mb-3 text-success">✔️</div>
              <h5 className="fw-bold">Test kỹ mới dám bán</h5>
              <p className="small text-muted">Mỗi sản phẩm đều qua tay team kỹ thuật kiểm tra kỹ lưỡng.</p>
            </div>
            <div className="col-md-3 mb-4">
              <div className="display-4 mb-3 text-warning">⚡</div>
              <h5 className="fw-bold">Gear mới? Có trước</h5>
              <p className="small text-muted">Cập nhật nhanh nhất các mẫu mã hot trên thị trường.</p>
            </div>
            <div className="col-md-3 mb-4">
              <div className="display-4 mb-3 text-danger">🛡️</div>
              <h5 className="fw-bold">Bảo hành không drama</h5>
              <p className="small text-muted">Có vấn đề? Nhắn tin, xác nhận, xử lý. Không vòng vo.</p>
            </div>
          </div>
        </div>
      </section>
      
    </main>
  );
};

export default Home;