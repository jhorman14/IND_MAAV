export default function Button({ variant = 'primary', children, style, ...props }) {
  const baseStyle = {
    padding: '10px 16px',
    borderRadius: '6px',
    border: '1px solid transparent',
    cursor: 'pointer',
    fontWeight: 600,
    minWidth: '120px',
    transition: 'background-color 0.2s ease, border-color 0.2s ease',
  };

  const variants = {
    primary: {
      backgroundColor: '#007bff',
      color: '#fff',
    },
    secondary: {
      backgroundColor: '#6c757d',
      color: '#fff',
    },
    danger: {
      backgroundColor: '#dc3545',
      color: '#fff',
    },
    ghost: {
      backgroundColor: 'transparent',
      color: '#007bff',
      borderColor: '#007bff',
    },
  };

  return (
    <button style={{ ...baseStyle, ...variants[variant], ...style }} {...props}>
      {children}
    </button>
  );
}
