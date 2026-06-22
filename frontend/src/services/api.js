const BASE = import.meta.env.VITE_API_BASE || 'http://localhost:8000/api/v1';

async function request(path, { method = 'GET', body, token } = {}) {
  const headers = { 'Content-Type': 'application/json' };
  if (token) headers['Authorization'] = `Bearer ${token}`;

  const res = await fetch(`${BASE}${path}`, {
    method,
    headers,
    body: body ? JSON.stringify(body) : undefined,
  });

  const text = await res.text();
  try {
    const json = text ? JSON.parse(text) : null;
    if (!res.ok) throw json || { message: res.statusText };
    return json;
  } catch (e) {
    throw e;
  }
}

// ============ AUTH SERVICES ============
export const authService = {
  register: (data) => request('/auth/register', { method: 'POST', body: data }),
  login: (data) => request('/auth/login', { method: 'POST', body: data }),
  logout: (token) => request('/auth/logout', { method: 'POST', token }),
  getProfile: (token) => request('/users/me', { token }),
};

// ============ PRODUCT SERVICES ============
export const productService = {
  list: (params = {}) => {
    const qs = new URLSearchParams(params).toString();
    return request(`/products${qs ? `?${qs}` : ''}`);
  },
  get: (id) => request(`/products/${id}`),
  create: (data, token) => request('/products', { method: 'POST', body: data, token }),
  update: (id, data, token) => request(`/products/${id}`, { method: 'PUT', body: data, token }),
  delete: (id, token) => request(`/products/${id}`, { method: 'DELETE', token }),
};

// ============ LEGACY EXPORTS (para compatibilidad) ============
// Estos se pueden eliminar una vez actualices las importaciones en los componentes
export const register = authService.register;
export const login = authService.login;
export const logout = authService.logout;
export const getMe = authService.getProfile;
export const getProducts = productService.list;
export const getProduct = productService.get;
export const createProduct = productService.create;
export const updateProduct = productService.update;
export const deleteProduct = productService.delete;

export default {
  auth: authService,
  products: productService,
  // legacy exports
  register,
  login,
  logout,
  getMe,
  getProducts,
  getProduct,
  createProduct,
  updateProduct,
  deleteProduct,
};
