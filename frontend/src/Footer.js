// src/Footer.js
import React from 'react';

const Footer = () => {
  return (
    <footer className="bg-white pt-5 pb-3 mt-auto border-top">
      <div className="container">
        <div className="row">
          <div className="col-md-4 mb-4">
            <h5 className="fw-bold mb-3">NHOM3 GEAR - ĐỒ ÁN ECOMMERCE</h5>
            <p className="small text-muted">Mang đến trải nghiệm mua sắm thiết bị chơi game đỉnh cao.</p>
            <p className="small text-muted"><strong>Địa chỉ:</strong> 180 Cao Lỗ, Phường, Chánh Hưng, Hồ Chí Minh</p>
          </div>
          
          <div className="col-md-4 mb-4">
            <h6 className="fw-bold mb-3">LIÊN HỆ & HỖ TRỢ</h6>
            <ul className="list-unstyled small text-muted">
              <li className="mb-2">Tư vấn mua hàng: <strong>0123.456.789</strong></li>
              <li className="mb-2">Bảo hành & Đổi trả: <strong>0987.654.321</strong></li>
              <li className="mb-2">Email: support@nhom3gear.com</li>
              <li>Giờ làm việc: 8:30 - 20:00 hàng ngày</li>
            </ul>
          </div>
          
          <div className="col-md-4 mb-4">
            <h6 className="fw-bold mb-3">CHÍNH SÁCH CỬA HÀNG</h6>
            <ul className="list-unstyled small">
              <li className="mb-2"><a href="/policy" className="text-decoration-none text-muted">Trả góp 0% - nhẹ ví, dễ nâng cấp</a></li>
              <li className="mb-2"><a href="/policy" className="text-decoration-none text-muted">Chính sách bảo hành - rõ ràng, nhanh gọn</a></li>
              <li className="mb-2"><a href="/policy" className="text-decoration-none text-muted">Chính sách đổi trả</a></li>
              <li className="mb-2"><a href="/policy" className="text-decoration-none text-muted">Chính sách hoàn tiền</a></li>
              <li><a href="/policy" className="text-decoration-none text-muted">Điều khoản dịch vụ</a></li>
            </ul>
          </div>
        </div>
        
        <hr className="my-4 text-muted" />
        
        <div className="text-center small text-muted">
          &copy; 2026 Bản quyền thuộc về Nhóm 3 Ecommerce Web.
        </div>
      </div>
    </footer>
  );
};

export default Footer;