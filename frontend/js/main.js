// js/main.js - BẢN FULL ĐẦY ĐỦ CHỨC NĂNG

// --- 1. CÁC HÀM TIỆN ÍCH ---

// Hàm định dạng tiền tệ (Sửa lỗi vnd is not defined)
function vnd(price) {
    if(price == null || isNaN(price)) return "0₫";
    return parseInt(price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

// Hàm thông báo Toast (Cần file toast-message.js để chạy đẹp hơn, nếu không có sẽ alert)
function showToast(title, message, type) {
    if (typeof toast === "function") {
        toast({ title: title, message: message, type: type });
    } else {
        alert(title + ": " + message);
    }
}

// --- 2. QUẢN LÝ POPUP (MODAL) ---

const body = document.querySelector("body");
let modalContainer = document.querySelectorAll('.modal');
let modalBox = document.querySelectorAll('.mdl-cnt');

// Click vùng ngoài sẽ tắt Popup
modalContainer.forEach(item => {
    item.addEventListener('click', closeModal);
});

modalBox.forEach(item => {
    item.addEventListener('click', function (event) {
        event.stopPropagation();
    })
});

function closeModal() {
    modalContainer.forEach(item => {
        item.classList.remove('open');
    });
    body.style.overflow = "auto";
}

// --- 3. XỬ LÝ CHI TIẾT SẢN PHẨM ---

// Hàm hiển thị Modal Chi tiết (Được gọi từ PHP)
function showModalDetail(infoProduct) {
    let modal = document.querySelector('.modal.product-detail');
    
    // Kiểm tra nếu modal không tồn tại
    if(!modal) {
        console.error("Không tìm thấy modal product-detail");
        return;
    }

    // Render nội dung Modal
    let modalHtml = `
    <div class="modal-header">
        <img class="product-image" src="${infoProduct.img}" alt="" onerror="this.src='./assets/img/blank-image.png'">
    </div>
    <div class="modal-body">
        <h2 class="product-title">${infoProduct.title}</h2>
        <div class="product-control">
            <div class="priceBox">
                <span class="current-price">${vnd(infoProduct.price)}</span>
            </div>
            <div class="buttons_added">
                <input class="minus is-form" type="button" value="-" onclick="decreasingNumber(this)">
                <input class="input-qty" max="100" min="1" name="" type="number" value="1">
                <input class="plus is-form" type="button" value="+" onclick="increasingNumber(this)">
            </div>
        </div>
        <p class="product-description">${infoProduct.description || infoProduct.desc || "Đang cập nhật..."}</p>
    </div>
    <div class="notebox">
            <p class="notebox-title">Ghi chú</p>
            <textarea class="text-note" id="popup-detail-note" placeholder="Nhập thông tin cần lưu ý..."></textarea>
    </div>
    <div class="modal-footer">
        <div class="price-total">
            <span class="thanhtien">Thành tiền</span>
            <span class="price">${vnd(infoProduct.price)}</span>
        </div>
        <div class="modal-footer-control">
            <button class="button-dathangngay" onclick="muaNgay(${infoProduct.id})">Mua ngay</button>
            <button class="button-dat" onclick="addToCartJS(${infoProduct.id}, '${infoProduct.title}', '${infoProduct.img}', ${infoProduct.price})"><i class="fa-light fa-basket-shopping"></i> Thêm vào giỏ</button>
        </div>
    </div>`;

    document.querySelector('#product-detail-content').innerHTML = modalHtml;
    modal.classList.add('open');
    body.style.overflow = "hidden";

    // Logic tăng giảm số lượng trong Modal
    setupQuantityButtons(infoProduct.price);
}

function setupQuantityButtons(unitPrice) {
    let qtyInput = document.querySelector('.input-qty');
    let priceText = document.querySelector('.price');
    let minusBtn = document.querySelector('.minus');
    let plusBtn = document.querySelector('.plus');

    if(plusBtn) {
        plusBtn.onclick = () => {
             qtyInput.value = parseInt(qtyInput.value) + 1;
             priceText.innerText = vnd(unitPrice * qtyInput.value);
        }
    }
    if(minusBtn) {
        minusBtn.onclick = () => {
            if (qtyInput.value > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                priceText.innerText = vnd(unitPrice * qtyInput.value);
            }
       }
    }
}

// --- 4. GIỎ HÀNG (LOGIC MỚI) ---

function addToCartJS(id, title, img, price) {
    if(!localStorage.getItem('currentuser')) {
        showToast('Cảnh báo', 'Vui lòng đăng nhập để mua hàng!', 'warning');
        openLoginModal();
        return;
    }

    let soluong = parseInt(document.querySelector('.input-qty').value);
    let note = document.querySelector('#popup-detail-note').value;
    
    let product = {
        id: id,
        title: title,
        img: img,
        price: price,
        soluong: soluong,
        note: note
    };

    let currentuser = JSON.parse(localStorage.getItem('currentuser'));
    let cart = currentuser.cart || [];

    // Check trùng sản phẩm
    let index = cart.findIndex(item => item.id == id);
    if(index !== -1) {
        cart[index].soluong += soluong;
        if(note) cart[index].note = note;
    } else {
        cart.push(product);
    }

    currentuser.cart = cart;
    localStorage.setItem('currentuser', JSON.stringify(currentuser));
    
    updateAmount();
    closeModal();
    showToast('Thành công', 'Đã thêm sản phẩm vào giỏ!', 'success');
}

function updateAmount() {
    let currentuser = localStorage.getItem('currentuser') ? JSON.parse(localStorage.getItem('currentuser')) : null;
    let total = 0;

    if(currentuser && currentuser.cart) {
        currentuser.cart.forEach(item => total += item.soluong);
    }

    let cartIcon = document.querySelector('.count-product-cart');
    if(cartIcon) {
        cartIcon.innerText = total;
    }
}

function getCurrentUserData() {
    const raw = localStorage.getItem('currentuser');
    return raw ? JSON.parse(raw) : null;
}

function saveCurrentUserData(user) {
    localStorage.setItem('currentuser', JSON.stringify(user));
}

function renderCart() {
    const currentuser = getCurrentUserData();
    const cart = currentuser?.cart || [];
    const cartList = document.querySelector('.cart-list');
    const emptyState = document.querySelector('.gio-hang-trong');
    const totalPrice = document.querySelector('.cart-total-price .text-price');
    const checkoutButton = document.querySelector('.thanh-toan');

    if (!cartList || !emptyState || !totalPrice || !checkoutButton) {
        return;
    }

    if (!cart.length) {
        cartList.innerHTML = '';
        emptyState.style.display = 'flex';
        totalPrice.innerText = vnd(0);
        checkoutButton.classList.add('disabled');
        return;
    }

    emptyState.style.display = 'none';

    const total = cart.reduce((sum, item) => sum + (Number(item.price) * Number(item.soluong)), 0);
    totalPrice.innerText = vnd(total);
    checkoutButton.classList.remove('disabled');

    cartList.innerHTML = cart.map((item) => `
        <li class="cart-item">
            <div class="cart-item-info">
                <div class="cart-item-title">
                    <strong>${item.title}</strong>
                    ${item.note ? `<div class="product-note"><i class="fa-light fa-note-sticky"></i>${item.note}</div>` : ''}
                </div>
                <div class="cart-item-price">${vnd(item.price * item.soluong)}</div>
            </div>
            <div class="cart-item-control">
                <span>Số lượng: ${item.soluong}</span>
                <button class="cart-item-delete" type="button" data-remove-cart-id="${item.id}">Xóa</button>
            </div>
        </li>
    `).join('');
}

function openCart() {
    const modalCart = document.querySelector('.modal-cart');
    if (!modalCart) return;
    renderCart();
    modalCart.classList.add('open');
    body.style.overflow = 'hidden';
}

function closeCart() {
    const modalCart = document.querySelector('.modal-cart');
    if (!modalCart) return;
    modalCart.classList.remove('open');
    body.style.overflow = 'auto';
}

function removeCartItem(productId) {
    const currentuser = getCurrentUserData();
    if (!currentuser || !currentuser.cart) return;

    currentuser.cart = currentuser.cart.filter((item) => Number(item.id) !== Number(productId));
    saveCurrentUserData(currentuser);
    updateAmount();
    renderCart();
    showToast('Thành công', 'Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
}

// Mua ngay (Đặt hàng luôn không cần thêm vào giỏ)
function muaNgay(id) {
    // Logic mua ngay có thể phát triển sau, tạm thời thêm vào giỏ và mở giỏ hàng
    // Bạn cần lấy thông tin từ popup hiện tại để add vào giỏ
    let title = document.querySelector('.product-title').innerText;
    // ... (Cần truyền đủ thông tin). 
    // Để đơn giản, ta alert hướng dẫn
    alert("Chức năng Mua ngay đang được cập nhật. Vui lòng thêm vào giỏ hàng để thanh toán.");
}

// --- 5. ĐĂNG NHẬP / ĐĂNG KÝ (GỌI API PHP) ---

// Mở Modal Login
function openLoginModal() {
    let modalAuth = document.querySelector('.modal.signup-login');
    let containerAuth = document.querySelector('.signup-login .modal-container');
    if(modalAuth) {
        modalAuth.classList.add('open');
        containerAuth.classList.add('active'); // Mặc định hiện tab Login
    }
}

// Sự kiện click nút Login/Register trên Header
let loginBtnHeader = document.getElementById('login');
let signupBtnHeader = document.getElementById('signup');
let modalAuth = document.querySelector('.modal.signup-login');
let containerAuth = document.querySelector('.signup-login .modal-container');

if(loginBtnHeader && modalAuth) {
    loginBtnHeader.addEventListener('click', () => {
        modalAuth.classList.add('open');
        containerAuth.classList.add('active'); // Hiện form Login
    });
}

if(signupBtnHeader && modalAuth) {
    signupBtnHeader.addEventListener('click', () => {
        modalAuth.classList.add('open');
        containerAuth.classList.remove('active'); // Hiện form Signup
    });
}

// Chuyển đổi qua lại giữa Login/Signup trong Modal
let signupLink = document.querySelector('.signup-link');
let loginLink = document.querySelector('.login-link');
if(signupLink) {
    signupLink.addEventListener('click', () => {
        containerAuth.classList.remove('active');
    });
}
if(loginLink) {
    loginLink.addEventListener('click', () => {
        containerAuth.classList.add('active');
    });
}

// XỬ LÝ NÚT ĐĂNG NHẬP (GỌI API)
let btnLoginSubmit = document.getElementById('login-button');
if(btnLoginSubmit) {
    btnLoginSubmit.addEventListener('click', async (e) => {
        e.preventDefault();
        let phone = document.getElementById('phone-login').value;
        let pass = document.getElementById('password-login').value;

        if (phone && pass) {
            try {
                let res = await fetch(apiUrl('/login'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ phone: phone, password: pass })
                });
                let raw = await res.text();
                let data;
                try {
                    data = JSON.parse(raw);
                } catch (parseError) {
                    throw new Error(`Phản hồi máy chủ không hợp lệ: ${raw.slice(0, 120)}`);
                }
                
                if (res.ok && data.status === 'success') {
                    // Lưu user vào localStorage
                    localStorage.setItem('currentuser', JSON.stringify(data.user));
                    showToast('Thành công', 'Đăng nhập thành công!', 'success');
                    closeModal();
                    checkLoginStatus(); // Cập nhật lại header
                } else {
                    showToast('Lỗi', data.message || 'Đăng nhập thất bại', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Lỗi', err.message || 'Không thể kết nối Server', 'error');
            }
        } else {
            showToast('Lỗi', 'Vui lòng nhập đầy đủ thông tin', 'warning');
        }
    });
}

// --- 6. KHỞI TẠO ---

function checkLoginStatus() {
    let user = localStorage.getItem('currentuser');
    if(user) {
        user = JSON.parse(user);
        let authContainer = document.querySelector('.auth-container');
        if(authContainer) {
            authContainer.innerHTML = `<span class="text-dndk">Xin chào,</span><span class="text-tk">${user.fullname}</span>`;
            
            // Đổi menu dropdown
            let menu = document.querySelector('.header-middle-right-menu');
            let adminLink = user.user_type == 1 ? `<li><a href="admin.html"><i class="fa-solid fa-gear"></i> Quản lý</a></li>` : '';
            
            menu.innerHTML = `
                ${adminLink}
                <li><a href="javascript:;" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
            `;
            
            // Gán sự kiện đăng xuất
            document.getElementById('logout-btn').addEventListener('click', () => {
                localStorage.removeItem('currentuser');
                window.location.href = "index.html"; // Reload trang
            });
        }
    }
}

// --- ĐĂNG KÝ (GỌI API PHP) ---
let btnSignupSubmit = document.getElementById('signup-button');
if (btnSignupSubmit) {
  btnSignupSubmit.addEventListener('click', async (e) => {
    e.preventDefault();

    let fullname = document.getElementById('fullname')?.value?.trim();
    let phone = document.getElementById('phone')?.value?.trim();
    let pass = document.getElementById('password')?.value;
    let pass2 = document.getElementById('password_confirmation')?.value;
    let checked = document.getElementById('checkbox-signup')?.checked;

    if (!fullname || !phone || !pass || !pass2) {
      showToast('Lỗi', 'Vui lòng nhập đầy đủ thông tin!', 'error');
      return;
    }
    if (pass !== pass2) {
      showToast('Lỗi', 'Mật khẩu nhập lại không khớp!', 'error');
      return;
    }
    if (!checked) {
      showToast('Lỗi', 'Bạn cần đồng ý chính sách trang web!', 'error');
      return;
    }

    try {
      let res = await fetch(apiUrl('/register'), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ fullname: fullname, phone: phone, password: pass })
      });

      let raw = await res.text();
      let data;
      try {
        data = JSON.parse(raw);
      } catch (parseError) {
        throw new Error(`Phản hồi máy chủ không hợp lệ: ${raw.slice(0, 120)}`);
      }

      if (res.ok && data.status === 'success') {
        localStorage.setItem('currentuser', JSON.stringify(data.user));
        showToast('Thành công', data.message || 'Đăng ký thành công!', 'success');
        closeModal();
        checkLoginStatus();
      } else {
        showToast('Lỗi', data.message || 'Đăng ký thất bại!', 'error');
      }
    } catch (err) {
      console.error(err);
      showToast('Lỗi', 'Không thể kết nối Server', 'error');
    }
  });
}

function showToast(title, message, type = 'success') {
  toast({
    title,
    message,
    type,       // 'success' | 'error' | 'warning' | 'info'
    duration: 3000
  });
}



window.onload = function() {
    updateAmount();
    checkLoginStatus();
    renderCart();
    // updateCartTotal(); // Hàm này nằm trong checkout.js hoặc phần xử lý giỏ hàng chi tiết nếu có
}

document.addEventListener('click', (event) => {
    if (event.target.classList.contains('modal-cart')) {
        closeCart();
    }

    const removeButton = event.target.closest('[data-remove-cart-id]');
    if (removeButton) {
        removeCartItem(removeButton.dataset.removeCartId);
    }

    if (event.target.closest('.them-mon')) {
        closeCart();
    }

    if (event.target.closest('.thanh-toan') && !event.target.closest('.thanh-toan').classList.contains('disabled')) {
        showToast('Thông báo', 'Chức năng thanh toán đang được hoàn thiện.', 'info');
    }
});
