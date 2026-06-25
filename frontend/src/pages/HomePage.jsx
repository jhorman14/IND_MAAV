import { ROUTES } from '../config/constants'

export default function HomePage({ onNavigate }) {
  return (
    <section style={styles.container}>
      <div style={styles.heroCard}>
        <h1 style={styles.title}>Bienvenido a IND-MAAV</h1>
        <p style={styles.description}>
          La plataforma de comercio electrónico para muebles industriales. Navega catálogo, gestiona tu cuenta y realiza pedidos con un flujo simple y rápido.
        </p>
        <div style={styles.buttons}>
          <button style={styles.primaryButton} onClick={() => onNavigate(ROUTES.LOGIN)}>
            Iniciar sesión
          </button>
          <button style={styles.secondaryButton} onClick={() => onNavigate(ROUTES.REGISTER)}>
            Registrarse
          </button>
        </div>
      </div>

      <div style={styles.features}>
        <div style={styles.featureItem}>
          <h2>Catálogo rápido</h2>
          <p>Explora productos en stock con información clara y precios actualizados.</p>
        </div>
        <div style={styles.featureItem}>
          <h2>Acceso seguro</h2>
          <p>Inicia sesión para ver tu perfil, historial y bloquear acciones sensibles.</p>
        </div>
        <div style={styles.featureItem}>
          <h2>Gestión de pedidos</h2>
          <p>Administra tu carrito y pedidos con un flujo moderno y responsivo.</p>
        </div>
      </div>
    </section>
  )
}

const styles = {
  container: {
    display: 'grid',
    gap: '32px',
    padding: '24px 0',
  },
  heroCard: {
    padding: '32px',
    borderRadius: '16px',
    background: '#ffffff',
    boxShadow: '0 14px 40px rgba(0,0,0,0.05)',
  },
  title: {
    margin: 0,
    fontSize: '2.5rem',
    lineHeight: 1.1,
    color: '#111827',
  },
  description: {
    margin: '18px 0 24px',
    maxWidth: '680px',
    fontSize: '1.05rem',
    color: '#4b5563',
  },
  buttons: {
    display: 'flex',
    flexWrap: 'wrap',
    gap: '12px',
  },
  primaryButton: {
    padding: '12px 22px',
    borderRadius: '10px',
    border: 'none',
    backgroundColor: '#007bff',
    color: '#ffffff',
    cursor: 'pointer',
    fontSize: '1rem',
  },
  secondaryButton: {
    padding: '12px 22px',
    borderRadius: '10px',
    border: '1px solid #007bff',
    background: 'transparent',
    color: '#007bff',
    cursor: 'pointer',
    fontSize: '1rem',
  },
  features: {
    display: 'grid',
    gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))',
    gap: '18px',
  },
  featureItem: {
    padding: '24px',
    borderRadius: '14px',
    background: '#f8fafc',
    boxShadow: '0 8px 24px rgba(15,23,42,0.05)',
  },
}
