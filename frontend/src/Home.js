// src/Home.js
import React from 'react';
// Import ảnh từ folder imageTab (thay đổi tên file cho đúng với file của bạn)
import mouseIcon from './imageTab/icon-chuot-gaming-2.png';
import keyboardIcon from './imageTab/icon-ban-phim-gaming-2.png';
import mousepadIcon from './imageTab/icon-lot-chuot-2.png';
import chairIcon from './imageTab/icon-ghe-cong-thai-hoc-2.png';

const Home = () => {
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

      {/* Categories Section */}
      <section className="container my-5">
        <div className="d-flex flex-wrap justify-content-center gap-4 text-center">
          <a href="/products" className="text-decoration-none text-dark p-3" style={{width: '160px'}}>
            <img src={mouseIcon} alt="Chuột gaming" className="mb-3 border rounded-3 p-2 shadow-sm" style={{height: '80px', width: '80px', objectFit: 'contain'}} />
            <h6 className="fw-bold">Chuột gaming</h6>
          </a>
          <a href="/keyboards" className="text-decoration-none text-dark p-3" style={{width: '160px'}}>
            <img src={keyboardIcon} alt="Bàn phím cơ & HE" className="mb-3 border rounded-3 p-2 shadow-sm" style={{height: '80px', width: '80px', objectFit: 'contain'}} />
            <h6 className="fw-bold">Bàn phím cơ &<br/>HE</h6>
          </a>
          <a href="/mousepads" className="text-decoration-none text-dark p-3" style={{width: '160px'}}>
            <img src={mousepadIcon} alt="Lót chuột" className="mb-3 border rounded-3 p-2 shadow-sm" style={{height: '80px', width: '80px', objectFit: 'contain'}} />
            <h6 className="fw-bold">Lót chuột</h6>
          </a>
          <a href="/chairs" className="text-decoration-none text-dark p-3" style={{width: '160px'}}>
            <img src={chairIcon} alt="Ghế công thái học" className="mb-3 border rounded-3 p-2 shadow-sm" style={{height: '80px', width: '80px', objectFit: 'contain'}} />
            <h6 className="fw-bold">Ghế công thái<br/>học</h6>
          </a>
        </div>
      </section>

      {/* Gear Mới Nóng Hổi */}
      <section className="container my-5">
        <div className="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
          <div>
            <h2 className="fw-bold mb-1">Gear mới nóng hổi</h2>
            <p className="text-muted mb-0">Tụi mình luôn cầm thử trước khi gear đến tay bạn. Mới về, đã test, sẵn sàng chiến.</p>
          </div>
          <a href="/products" className="text-decoration-none text-dark fw-semibold">Xem hàng mới về &gt;</a>
        </div>
        <div className="row" id="new-gear-container">
        </div>
      </section>

      {/* Top Bán Chạy */}
      <section className="container my-5">
        <div className="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
          <div>
            <h2 className="fw-bold mb-1">Top bán chạy - con số không biết nói dối</h2>
            <p className="text-muted mb-0">Hàng nghìn game thủ đã chốt đơn. Bạn thì sao?</p>
          </div>
          <a href="/products" className="text-decoration-none text-dark fw-semibold">Xem top bán chạy &gt;</a>
        </div>
        <div className="row" id="top-selling-container">
        </div>
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