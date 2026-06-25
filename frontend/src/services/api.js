const BASE = import.meta.env.VITE_API_BASE || 'http://localhost:8000/api/v1';
const SANCTUM_ORIGIN = BASE.replace(/\/api\/v1\/?$/, '');

function getCookie(name) {
  const cookies = document.cookie.split(';').map((cookie) => cookie.trim());
  const match = cookies.find((cookie) => cookie.startsWith(`${name}=`));
  return match ? decodeURIComponent(match.split('=')[1]) : null;
}

async function request(path, { method = 'GET', body, token, credentials = 'same-origin' } = {}) {
  const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  };
  if (token) headers['Authorization'] = `Bearer ${token}`;

  const xsrfToken = getCookie('XSRF-TOKEN');
  if (xsrfToken) {
    headers['X-XSRF-TOKEN'] = xsrfToken;
  }

  const res = await fetch(`${BASE}${path}`, {
    method,
    headers,
    credentials,
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
  register: async (data) => {
    // Request CSRF cookie for sanctum (sets XSRF-TOKEN)
    await fetch(`${SANCTUM_ORIGIN}/sanctum/csrf-cookie`, { credentials: 'include' });
    console.log('XSRF cookie before register:', getCookie('XSRF-TOKEN'));
    return request('/auth/register', { method: 'POST', body: data, credentials: 'include' });
  },
  login: async (data) => {
    await fetch(`${SANCTUM_ORIGIN}/sanctum/csrf-cookie`, { credentials: 'include' });
    console.log('XSRF cookie before login:', getCookie('XSRF-TOKEN'));
    return request('/auth/login', { method: 'POST', body: data, credentials: 'include' });
  },
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
