import { useState, useEffect } from 'react'
import './styles/App.css'
import { ROUTES, STORAGE_KEYS } from './config/constants'
import Header from './components/Header'
import HomePage from './pages/HomePage'
import LoginPage from './pages/LoginPage'
import RegisterPage from './pages/RegisterPage'
import ProductsPage from './pages/ProductsPage'

function App() {
  const [currentView, setCurrentView] = useState(ROUTES.HOME)
  const [user, setUser] = useState(null)
  const [token, setToken] = useState(null)

  useEffect(() => {
    const savedToken = localStorage.getItem(STORAGE_KEYS.TOKEN)
    const savedUser = localStorage.getItem(STORAGE_KEYS.USER)
    if (savedToken && savedUser) {
      setToken(savedToken)
      setUser(JSON.parse(savedUser))
      setCurrentView(ROUTES.PRODUCTS)
    }
  }, [])

  const handleLoginSuccess = (newToken, newUser) => {
    setToken(newToken)
    setUser(newUser)
    setCurrentView(ROUTES.PRODUCTS)
  }

  const handleLogout = () => {
    localStorage.removeItem(STORAGE_KEYS.TOKEN)
    localStorage.removeItem(STORAGE_KEYS.USER)
    setToken(null)
    setUser(null)
    setCurrentView(ROUTES.HOME)
  }

  return (
    <>
      <Header
        user={user}
        onLoginClick={() => setCurrentView(ROUTES.LOGIN)}
        onNavigate={setCurrentView}
        onLogout={handleLogout}
      />

      <main style={{ padding: '24px 20px', maxWidth: 1080, margin: '0 auto' }}>
        {currentView === ROUTES.HOME && <HomePage onNavigate={setCurrentView} />}
        {currentView === ROUTES.LOGIN && <LoginPage onLoginSuccess={handleLoginSuccess} />}
        {currentView === ROUTES.REGISTER && <RegisterPage onRegisterSuccess={handleLoginSuccess} />}
        {currentView === ROUTES.PRODUCTS && <ProductsPage token={token} />}
      </main>
    </>
  )
}
export default App