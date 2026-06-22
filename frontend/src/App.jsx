import { useState, useEffect } from 'react'
import './styles/App.css'
import { ROUTES, STORAGE_KEYS } from './config/constants'
import HomePage from './pages/HomePage'
import LoginPage from './pages/LoginPage'
import RegisterPage from './pages/RegisterPage'
import ProductsPage from './pages/ProductsPage'

function App() {
  const [currentView, setCurrentView] = useState('home') // home, login, register, products
  const [user, setUser] = useState(null)
  const [token, setToken] = useState(null)

  // Cargar token de localStorage al iniciar
  useEffect(() => {
    const savedToken = localStorage.getItem('auth_token')
    const savedUser = localStorage.getItem('user')
    if (savedToken && savedUser) {
      setToken(savedToken)
      setUser(JSON.parse(savedUser))
      setCurrentView('products')
    }
  }, [])

  const handleLoginSuccess = (newToken, newUser) => {
    setToken(newToken)
    setUser(newUser)
    setCurrentView('products')
  }

  const handleLogout = () => {
    localStorage.removeItem('auth_token')
    localStorage.removeItem('user')
    setToken(null)
    setUser(null)
    setCurrentView('home')
  }
  

  return (
    <>
      <nav style={{ padding: '10px 20px', backgroundColor: '#f0f0f0', borderBottom: '1px solid #ddd', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <div style={{ fontSize: '18px', fontWeight: 'bold', cursor: 'pointer' }} onClick={() => setCurrentView('home')}>
          IND-MAAV
        </div>
        <div style={{ display: 'flex', gap: '15px' }}>
          {user ? (
            <>
              <span>Hola, {user.nombre || user.name || 'Usuario'}</span>
              <button onClick={() => setCurrentView('products')} style={{ cursor: 'pointer', padding: '5px 10px' }}>
                Productos
              </button>
              <button onClick={handleLogout} style={{ cursor: 'pointer', padding: '5px 10px', backgroundColor: '#dc3545', color: 'white', border: 'none', borderRadius: '4px' }}>
                Cerrar sesión
              </button>
            </>
          ) : (
            <>
              <button onClick={() => setCurrentView('login')} style={{ cursor: 'pointer', padding: '5px 10px' }}>
                Iniciar sesión
              </button>
              <button onClick={() => setCurrentView('register')} style={{ cursor: 'pointer', padding: '5px 10px', backgroundColor: '#007bff', color: 'white', border: 'none', borderRadius: '4px' }}>
                Registrarse
              </button>
            </>
          )}
        </div>
      </nav>

      {currentView === 'home' && <HomePage onNavigate={setCurrentView} />}
      {currentView === 'login' && <LoginPage onLoginSuccess={handleLoginSuccess} />}
      {currentView === 'register' && <RegisterPage onRegisterSuccess={handleLoginSuccess} />}
      {currentView === 'products' && <ProductsPage token={token} />}
      </>
    )
}


export default App
