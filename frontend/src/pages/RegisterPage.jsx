import { useState } from 'react';
import { authService } from '../services/api';

export default function RegisterPage({ onRegisterSuccess }) {
  const [nombre, setNombre] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirmation, setPasswordConfirmation] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [errors, setErrors] = useState([]);
  const [success, setSuccess] = useState('');

  const getErrorText = (err) => {
    if (!err) {
      return 'Error al registrarse.';
    }

    const validation = err.errors || err?.response?.errors;
    if (validation) {
      const messages = Object.values(validation).flat();
      return messages.length > 0 ? messages.join(' ') : err.message || 'Error al registrarse.';
    }

    return err.message || err?.response?.message || 'Error al registrarse.';
  };

  const getErrorList = (err) => {
    const validation = err?.errors || err?.response?.errors;
    if (!validation) {
      return [];
    }

    return Object.values(validation).flat();
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setErrors([]);
    setSuccess('');

    try {
      const response = await authService.register({
        nombre,
        email,
        password,
        password_confirmation: passwordConfirmation,
      });

      if (!response?.success) {
        setError(response?.message || 'No se pudo registrar.');
        return;
      }

      const payload = response.data;

      if (!payload?.token) {
        setError('No se recibió token de sesión.');
        return;
      }

      const user = {
        id: payload.id,
        nombre: payload.nombre,
        email: payload.email,
        rol: payload.rol,
      };

      localStorage.setItem('auth_token', payload.token);
      localStorage.setItem('user', JSON.stringify(user));

      setSuccess('¡Registro exitoso! Redirigiendo...');

      if (onRegisterSuccess) {
        setTimeout(() => onRegisterSuccess(payload.token, user), 1000);
      }

      setNombre('');
      setEmail('');
      setPassword('');
      setPasswordConfirmation('');
    } catch (err) {
      console.error('Error en registro:', err);
      setErrors(getErrorList(err));
      setError(getErrorText(err));
    } finally {
      setLoading(false);
    }
  };

  return (
    <section id="register" style={{ maxWidth: '400px', margin: '20px auto', padding: '20px', border: '1px solid #ccc', borderRadius: '8px' }}>
      <h2>Registro</h2>
      {error && <p style={{ color: 'red', marginBottom: '10px' }}>{error}</p>}
      {errors.length > 0 && (
        <ul style={{ color: 'red', marginBottom: '10px', paddingLeft: '20px' }}>
          {errors.map((message, index) => (
            <li key={index}>{message}</li>
          ))}
        </ul>
      )}
      {success && <p style={{ color: 'green', marginBottom: '10px' }}>{success}</p>}

      <form onSubmit={handleSubmit}>
        <div style={{ marginBottom: '12px' }}>
          <label htmlFor="nombre">Nombre completo:</label>
          <input
            id="nombre"
            type="text"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
            required
            placeholder="Juan Pérez"
            style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
          />
        </div>

        <div style={{ marginBottom: '12px' }}>
          <label htmlFor="email">Email:</label>
          <input
            id="email"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
            placeholder="tu@email.com"
            style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
          />
        </div>

        <div style={{ marginBottom: '12px' }}>
          <label htmlFor="password">Contraseña:</label>
          <input
            id="password"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
            placeholder="Contraseña segura"
            style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
          />
        </div>

        <div style={{ marginBottom: '12px' }}>
          <label htmlFor="passwordConfirmation">Confirmar contraseña:</label>
          <input
            id="passwordConfirmation"
            type="password"
            value={passwordConfirmation}
            onChange={(e) => setPasswordConfirmation(e.target.value)}
            required
            placeholder="Repetir contraseña"
            style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
          />
        </div>

        <button
          type="submit"
          disabled={loading}
          style={{
            width: '100%',
            padding: '10px',
            backgroundColor: loading ? '#ccc' : '#28a745',
            color: 'white',
            border: 'none',
            borderRadius: '4px',
            cursor: loading ? 'not-allowed' : 'pointer',
          }}
        >
          {loading ? 'Registrando...' : 'Registrarse'}
        </button>
      </form>
    </section>
  );
}
