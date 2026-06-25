import { useState } from 'react';
import Button from './Button';
import { ROUTES } from '../config/constants';

export default function Header({ user, onLoginClick, onNavigate, onLogout }) {
  const [menuOpen, setMenuOpen] = useState(false);

  const handleUserClick = () => setMenuOpen((prev) => !prev);
  const handleLogout = () => {
    setMenuOpen(false);
    onLogout();
  };

  return (
    <header style={styles.header}>
      <div style={styles.brand} onClick={() => onNavigate(ROUTES.HOME)}>
        IND-MAAV
      </div>
      <nav style={styles.nav}>
        <button type="button" style={styles.navButton} onClick={() => onNavigate(ROUTES.HOME)}>
          Home
        </button>
        <button type="button" style={styles.navButton} onClick={() => onNavigate(ROUTES.PRODUCTS)}>
          Productos
        </button>
      </nav>

      <div style={styles.actions}>
        {!user ? (
          <>
            <Button variant="ghost" onClick={onLoginClick} style={{ marginRight: '10px' }}>
              Iniciar sesión
            </Button>
            <Button variant="primary" onClick={() => onNavigate(ROUTES.REGISTER)}>
              Registrarse
            </Button>
          </>
        ) : (
          <div style={styles.userSection}>
            <button type="button" onClick={handleUserClick} style={styles.userButton}>
              {user.nombre || user.name || user.username || 'Mi cuenta'}
            </button>
            {menuOpen && (
              <div style={styles.dropdown}>
                <button type="button" style={styles.dropdownItem} onClick={handleLogout}>
                  Cerrar sesión
                </button>
              </div>
            )}
          </div>
        )}
      </div>
    </header>
  );
}

const styles = {
  header: {
    width: '100%',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'space-between',
    padding: '16px 24px',
    backgroundColor: '#ffffff',
    boxShadow: '0 2px 10px rgba(0, 0, 0, 0.05)',
    position: 'sticky',
    top: 0,
    zIndex: 20,
  },
  brand: {
    fontSize: '1.25rem',
    fontWeight: 700,
    color: '#007bff',
    cursor: 'pointer',
  },
  nav: {
    display: 'flex',
    gap: '16px',
  },
  navButton: {
    background: 'none',
    border: 'none',
    padding: 0,
    color: '#343a40',
    fontSize: '1rem',
    cursor: 'pointer',
  },
  actions: {
    display: 'flex',
    alignItems: 'center',
    gap: '12px',
  },
  userSection: {
    position: 'relative',
  },
  userButton: {
    background: '#f8f9fa',
    border: '1px solid #ced4da',
    borderRadius: '8px',
    padding: '10px 14px',
    cursor: 'pointer',
  },
  dropdown: {
    position: 'absolute',
    right: 0,
    top: 'calc(100% + 8px)',
    background: '#ffffff',
    border: '1px solid #dee2e6',
    borderRadius: '10px',
    boxShadow: '0 8px 20px rgba(0,0,0,0.08)',
    minWidth: '160px',
    zIndex: 10,
  },
  dropdownItem: {
    display: 'block',
    width: '100%',
    padding: '10px 14px',
    textAlign: 'left',
    background: 'transparent',
    border: 'none',
    cursor: 'pointer',
  },
};
