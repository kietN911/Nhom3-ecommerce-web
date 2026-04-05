// src/KeyboardPage.js
import React from 'react';

const KeyboardPage = () => {
  return (
    <main className="container my-5 flex-grow-1">
      <style>
        {`
          .filter-toggle .arrow-icon {
            transition: transform 0.3s ease;
            display: inline-block;
          }
          .filter-toggle[aria-expanded="true"] .arrow-icon {
            transform: rotate(180deg);
          }
          input[type="number"]::-webkit-inner-spin-button, 
          input[type="number"]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
          }
          input[type="number"] {
            -moz-appearance: textfield;
          }
        `}
      </style>
      <div className="row">
        {/* Sidebar Lọc */}
        <div className="col-md-3">
          <div className="d-flex align-items-center mb-4">
            <h5 className="fw-bold mb-0 me-2"><i className="bi bi-sliders"></i> Lọc</h5>
          </div>
          
          <div className="d-flex justify-content-between align-items-center py-3 border-bottom">
            <span className="fw-semibold">Còn hàng</span>
            <div className="form-check form-switch m-0">
              <input className="form-check-input shadow-none" type="checkbox" role="switch" id="stockSwitch" />
            </div>
          </div>

          <div className="border-bottom">
            <div className="py-3 d-flex justify-content-between align-items-center filter-toggle" data-bs-toggle="collapse" data-bs-target="#brandCollapse" aria-expanded="false" style={{cursor: 'pointer'}}>
              <span className="fw-semibold">Thương hiệu</span>
              <span className="text-dark fs-5 arrow-icon">&#709;</span>
            </div>
            <div className="collapse" id="brandCollapse">
              <div className="pb-3">
                <div className="form-check mb-3">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="brand1" />
                  <label className="form-check-label text-muted" htmlFor="brand1" style={{ fontSize: '15px' }}>Arbiter Studio</label>
                </div>
                <div className="form-check mb-3">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="brand2" />
                  <label className="form-check-label text-muted" htmlFor="brand2" style={{ fontSize: '15px' }}>DrunkDeer</label>
                </div>
                <div className="form-check mb-3">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="brand3" />
                  <label className="form-check-label text-muted" htmlFor="brand3" style={{ fontSize: '15px' }}>Filco</label>
                </div>
                <div className="form-check mb-2">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="brand4" />
                  <label className="form-check-label text-muted" htmlFor="brand4" style={{ fontSize: '15px' }}>Fnatic</label>
                </div>
              </div>
            </div>
          </div>

          <div className="border-bottom">
            <div className="py-3 d-flex justify-content-between align-items-center filter-toggle" data-bs-toggle="collapse" data-bs-target="#typeCollapse" aria-expanded="false" style={{cursor: 'pointer'}}>
              <span className="fw-semibold">Loại sản phẩm</span>
              <span className="text-dark fs-5 arrow-icon">&#709;</span>
            </div>
            <div className="collapse" id="typeCollapse">
              <div className="pb-3">
                <div className="form-check mb-3">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="type1" />
                  <label className="form-check-label text-muted" htmlFor="type1" style={{ fontSize: '15px' }}>Bàn phím cơ</label>
                </div>
                <div className="form-check mb-2">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="type2" />
                  <label className="form-check-label text-muted" htmlFor="type2" style={{ fontSize: '15px' }}>Bàn phím HE</label>
                </div>
              </div>
            </div>
          </div>

          <div className="border-bottom">
            <div className="py-3 d-flex justify-content-between align-items-center filter-toggle" data-bs-toggle="collapse" data-bs-target="#connectionCollapse" aria-expanded="false" style={{cursor: 'pointer'}}>
              <span className="fw-semibold">Kết nối</span>
              <span className="text-dark fs-5 arrow-icon">&#709;</span>
            </div>
            <div className="collapse" id="connectionCollapse">
              <div className="pb-3">
                <div className="form-check mb-3">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="conn1" />
                  <label className="form-check-label text-muted" htmlFor="conn1" style={{ fontSize: '15px' }}>Có kết nối dây</label>
                </div>
                <div className="form-check mb-2">
                  <input className="form-check-input shadow-none border-secondary" type="checkbox" id="conn2" />
                  <label className="form-check-label text-muted" htmlFor="conn2" style={{ fontSize: '15px' }}>Bluetooth</label>
                </div>
              </div>
            </div>
          </div>

          <div className="border-bottom">
            <div className="py-3 d-flex justify-content-between align-items-center filter-toggle" data-bs-toggle="collapse" data-bs-target="#priceCollapse" aria-expanded="false" style={{cursor: 'pointer'}}>
              <span className="fw-semibold">Giá</span>
              <span className="text-dark fs-5 arrow-icon">&#709;</span>
            </div>
            <div className="collapse" id="priceCollapse">
              <div className="pb-3 pt-2">
                <div className="position-relative mb-4 mt-2" style={{ height: '3px', backgroundColor: '#212529' }}>
                  <div className="position-absolute top-50 translate-middle rounded-circle bg-dark" style={{ width: '14px', height: '14px', left: '0%' }}></div>
                  <div className="position-absolute top-50 translate-middle rounded-circle bg-dark" style={{ width: '14px', height: '14px', left: '100%' }}></div>
                </div>
                
                <div className="d-flex align-items-center justify-content-between">
                  <div className="position-relative" style={{ width: '42%' }}>
                    <span className="position-absolute top-50 translate-middle-y text-muted ms-2" style={{ fontSize: '14px' }}>đ</span>
                    <input type="number" className="form-control text-secondary text-end shadow-none" defaultValue="0" style={{ paddingLeft: '24px', fontSize: '15px' }} />
                  </div>
                  <span className="text-muted" style={{ fontSize: '14px' }}>đến</span>
                  <div className="position-relative" style={{ width: '42%' }}>
                    <span className="position-absolute top-50 translate-middle-y text-muted ms-2" style={{ fontSize: '14px' }}>đ</span>
                    <input type="number" className="form-control text-secondary text-end shadow-none" defaultValue="1023000" style={{ paddingLeft: '24px', fontSize: '15px' }} />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Product List */}
        <div className="col-md-9">
          <div className="d-flex justify-content-end align-items-center mb-4">
            <span className="me-2 fw-semibold">Sắp xếp:</span>
            <select className="form-select w-auto bg-light border-0 fw-semibold shadow-none">
              <option>Ngày (từ mới đến cũ)</option>
              <option>Giá (Thấp đến cao)</option>
              <option>Giá (Cao xuống thấp)</option>
            </select>
          </div>

          <div className="row g-4" id="product-list-container">
          </div>
        </div>
      </div>
    </main>
  );
};

export default KeyboardPage;