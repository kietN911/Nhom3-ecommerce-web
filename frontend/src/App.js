import { BrowserRouter, Routes, Route } from "react-router-dom";
import Header from "./Header";
import Footer from "./Footer";
import Home from "./Home";
import ProductPage from "./ProductPage";
import KeyboardPage from "./KeyboardPage";
import MousepadPage from "./MousepadPage";
import ChairPage from "./ChairPage";
import ProductDetail from "./pages/ProductDetail";

function App() {
  return (
    <BrowserRouter>
      <div className="d-flex flex-column min-vh-100">
        <Header />

        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/products" element={<ProductPage />} />
          <Route path="/keyboards" element={<KeyboardPage />} />
          <Route path="/mousepads" element={<MousepadPage />} />
          <Route path="/chairs" element={<ChairPage />} />

          {/* 🔥 Trang chi tiết */}
          <Route path="/product/:id" element={<ProductDetail />} />
        </Routes>

        <Footer />
      </div>
    </BrowserRouter>
  );
}

export default App;