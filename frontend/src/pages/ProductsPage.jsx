import { useEffect, useState } from 'react';
import { productService } from '../services/api';

export default function ProductsPage({ token }) {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [form, setForm] = useState({ name: '', price: 0, available_quantity: 0 });

  const loadProducts = async () => {
    setLoading(true);
    try {
      const data = await productService.list();
      setProducts(data.data || data);
    } catch (e) {
      console.error(e);
      alert('Error cargando productos');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadProducts();
  }, []);

  const handleCreate = async (e) => {
    e.preventDefault();
    try {
      await productService.create(form, token || undefined);
      setForm({ name: '', price: 0, available_quantity: 0 });
      await loadProducts();
    } catch (err) {
      console.error(err);
      alert('Error creando producto');
    }
  };

  const handleDelete = async (id) => {
    if (!confirm('¿Eliminar producto?')) return;
    try {
      await productService.delete(id, token || undefined);
      await loadProducts();
    } catch (err) {
      console.error(err);
      alert('Error eliminando producto');
    }
  };

  return (
    <section id="products">
      <h2>Productos</h2>

      {token && (
        <form onSubmit={handleCreate} style={{marginTop:10, padding: '15px', backgroundColor: '#f9f9f9', borderRadius: '4px'}}>
          <h3>Crear Producto (requiere autenticación)</h3>
          <input placeholder="Nombre" value={form.name} onChange={e => setForm({...form, name: e.target.value})} required />
          <input type="number" step="0.01" placeholder="Precio" value={form.price} onChange={e => setForm({...form, price: e.target.value})} required />
          <input type="number" placeholder="Stock" value={form.available_quantity} onChange={e => setForm({...form, available_quantity: e.target.value})} />
          <button type="submit">Crear Producto</button>
        </form>
      )}

      {loading ? <p>Cargando...</p> : (
        <ul>
          {products.map(p => (
            <li key={p.id} style={{marginTop:8}}>
              <strong>{p.nombre}</strong> — ${p.precio} — stock: {p.stock}
              {token && (
                <button onClick={() => handleDelete(p.id)} style={{marginLeft:8}}>Eliminar</button>
              )}
            </li>
          ))}
        </ul>
      )}
    </section>
  );
}
