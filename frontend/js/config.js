window.API_BASE = "http://127.0.0.1:8000/api";

window.apiUrl = function apiUrl(path) {
    const normalizedPath = path.startsWith("/") ? path : `/${path}`;
    return `${window.API_BASE}${normalizedPath}`;
};
