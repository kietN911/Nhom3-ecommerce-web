// js/checkout.js - Cập nhật hàm xử lý đặt hàng

function xulyDathang(product) {
    // ... (Giữ nguyên phần lấy thông tin địa chỉ, người nhận bên trên) ...
    // ...
    
    // ĐOẠN LOGIC TÍNH TIỀN & TẠO ĐƠN (Sửa đổi):
    let currentUser = JSON.parse(localStorage.getItem('currentuser'));
    let orderDetails = [];
    let madon = "DH" + new Date().getTime(); // Tạo mã đơn theo thời gian thực
    let tongtien = 0;

    // Xử lý giỏ hàng hoặc mua ngay
    if(product == undefined) {
        currentUser.cart.forEach(item => {
            let price = getpriceProduct(item.id);
            tongtien += price * item.soluong;
            orderDetails.push({
                id: item.id,
                soluong: item.soluong,
                price: price,
                note: item.note
            });
        });
    } else {
        let price = getpriceProduct(product.id);
        tongtien += price * product.soluong;
        orderDetails.push({
            id: product.id,
            soluong: product.soluong,
            price: price,
            note: product.note
        });
    }

    // Kiểm tra thông tin
    let tennguoinhan = document.querySelector("#tennguoinhan").value;
    let sdtnhan = document.querySelector("#sdtnhan").value;

    if (tennguoinhan == "" || sdtnhan == "" || diachinhan == "") {
        toast({ title: 'Chú ý', message: 'Vui lòng nhập đủ thông tin!', type: 'warning' });
        return;
    }

    // Gửi dữ liệu về Server PHP
    let orderData = {
        order: {
            id: madon,
            user_id: currentUser.id,
            fullname: tennguoinhan,
            phone: sdtnhan,
            address: diachinhan,
            total_money: tongtien,
            note: document.querySelector(".note-order").value,
            shipping_method: hinhthucgiao
        },
        details: orderDetails
    };

    fetch(apiUrl('/checkout'), {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(orderData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            // Xóa giỏ hàng nếu đặt thành công
            if(product == null) {
                currentUser.cart = [];
                localStorage.setItem("currentuser", JSON.stringify(currentUser));
            }
            toast({ title: 'Thành công', message: 'Cảm ơn bạn đã mua sắm tại F&K STORE!', type: 'success' });
            setTimeout(() => { window.location = "/"; }, 2000);
        } else {
            toast({ title: 'Lỗi', message: data.message, type: 'error' });
        }
    });
}// js/checkout.js - Cập nhật hàm xử lý đặt hàng

function xulyDathang(product) {
    // ... (Giữ nguyên phần lấy thông tin địa chỉ, người nhận bên trên) ...
    // ...
    
    // ĐOẠN LOGIC TÍNH TIỀN & TẠO ĐƠN (Sửa đổi):
    let currentUser = JSON.parse(localStorage.getItem('currentuser'));
    let orderDetails = [];
    let madon = "DH" + new Date().getTime(); // Tạo mã đơn theo thời gian thực
    let tongtien = 0;

    // Xử lý giỏ hàng hoặc mua ngay
    if(product == undefined) {
        currentUser.cart.forEach(item => {
            let price = getpriceProduct(item.id);
            tongtien += price * item.soluong;
            orderDetails.push({
                id: item.id,
                soluong: item.soluong,
                price: price,
                note: item.note
            });
        });
    } else {
        let price = getpriceProduct(product.id);
        tongtien += price * product.soluong;
        orderDetails.push({
            id: product.id,
            soluong: product.soluong,
            price: price,
            note: product.note
        });
    }

    // Kiểm tra thông tin
    let tennguoinhan = document.querySelector("#tennguoinhan").value;
    let sdtnhan = document.querySelector("#sdtnhan").value;

    if (tennguoinhan == "" || sdtnhan == "" || diachinhan == "") {
        toast({ title: 'Chú ý', message: 'Vui lòng nhập đủ thông tin!', type: 'warning' });
        return;
    }

    // Gửi dữ liệu về Server PHP
    let orderData = {
        order: {
            id: madon,
            user_id: currentUser.id,
            fullname: tennguoinhan,
            phone: sdtnhan,
            address: diachinhan,
            total_money: tongtien,
            note: document.querySelector(".note-order").value,
            shipping_method: hinhthucgiao
        },
        details: orderDetails
    };

    fetch(apiUrl('/checkout'), {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(orderData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            // Xóa giỏ hàng nếu đặt thành công
            if(product == null) {
                currentUser.cart = [];
                localStorage.setItem("currentuser", JSON.stringify(currentUser));
            }
            toast({ title: 'Thành công', message: 'Cảm ơn bạn đã mua sắm tại F&K STORE!', type: 'success' });
            setTimeout(() => { window.location = "/"; }, 2000);
        } else {
            toast({ title: 'Lỗi', message: data.message, type: 'error' });
        }
    });
}
