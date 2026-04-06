// src/App.js
import React from 'react';
import Header from './Header';
import Home from './Home';
import Footer from './Footer';
import ProductPage from './ProductPage';
import KeyboardPage from './KeyboardPage';
import MousepadPage from './MousepadPage';
import ChairPage from './ChairPage';

function App() {
  const path = window.location.pathname;

  const renderContent = () => {
    switch (path) {
      case '/products':
        return <ProductPage />;
      case '/keyboards':
        return <KeyboardPage />;
      case '/mousepads':
        return <MousepadPage />;
      case '/chairs':
        return <ChairPage />;
      default:
        return <Home />;
    }
  };

  return (
    <div className="d-flex flex-column min-vh-100">
      <Header />
      {renderContent()}
      <Footer />
    </div>
  );
}

export default App;