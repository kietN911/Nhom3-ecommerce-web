// src/Header.js
import React from 'react';
import { Link } from "react-router-dom";
const user = JSON.parse(localStorage.getItem("user"));

const logout = () => {
  localStorage.removeItem("user");
  localStorage.removeItem("token");
  window.location.reload();
};

const Header = () => {
  return (
    <header>
      {/* Top Bar */}
      <div className="bg-dark text-white text-center py-2 d-none d-md-block" style={{ fontSize: '13px' }}>
        <div className="container d-flex justify-content-between">
          <span>Trả góp 0%</span>
          <span>Tư vấn chuẩn, chọn đúng gear</span>
          <span>Bảo hành gọn, xử lý nhanh</span>
          <span>Giao nhanh 0-2 ngày</span>
          <span>Miễn phí ship từ 1 triệu</span>
        </div>
      </div>

      {/* Main Navbar */}
      <nav className="navbar navbar-expand-lg navbar-dark bg-black py-3">
        <div className="container">
          <a className="navbar-brand fw-bold fs-4 d-flex align-items-center" href="/">
            <span className="ms-2">GEAR</span>
          </a>
          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarNav">
            <ul className="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold ms-4">
              <li className="nav-item"><a className="nav-link text-white" href="/">New & Featured</a></li>
              <li className="nav-item"><a className="nav-link text-white" href="/">Sale</a></li>
            </ul>
            <form className="d-flex me-4" role="search">
              <input className="form-control rounded-pill bg-dark text-white border-secondary" type="search" placeholder="Tìm chuột, bàn phím, tai nghe..." />
            </form>
            <div className="d-flex text-white align-items-center gap-3">
              {user ? (
                <>
                  <span>Xin chào {user.username}</span>
                  <span onClick={logout} style={{cursor: "pointer"}}>
                    Đăng xuất
                  </span>
                </>
              ) : (
                <Link to="/login" className="text-white text-decoration-none">
                  Đăng nhập
                </Link>
              )}

              <span style={{cursor: 'pointer'}}>
                Giỏ hàng (0)
              </span>
            </div>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default Header;