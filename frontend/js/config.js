window.API_BASE = "https://nhom3-backend.onrender.com/api";

window.apiUrl = function apiUrl(path) {
    const normalizedPath = path.startsWith("/") ? path : `/${path}`;
    return `${window.API_BASE}${normalizedPath}`;
};
