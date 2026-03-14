import "./App.css";
import { useEffect, useState } from "react";

function App() {

  const [users, setUsers] = useState([]);

  useEffect(() => {
    fetch("https://nhom3-backend.onrender.com/users")
      .then(res => res.json())
      .then(data => setUsers(data));
  }, []);

  return (
    <div style={styles.container}>

      <h1 style={styles.title}>Danh sách Users</h1>

      <table style={styles.table}>
        <thead>
          <tr>
            <th>ID</th>
            <th>Họ và Tên</th>
          </tr>
        </thead>

        <tbody>
          {users.map(user => (
            <tr key={user.id}>
              <td>{user.id}</td>
              <td>{user.name}</td>
            </tr>
          ))}
        </tbody>

      </table>

    </div>
  );
}

const styles = {

  container: {
    padding: "40px",
    background: "#f5f6f7",
    minHeight: "100vh",
    fontFamily: "Arial"
  },

  title: {
    marginBottom: "20px"
  },

  table: {
    width: "100%",
    borderCollapse: "collapse",
    background: "white",
    boxShadow: "0 2px 10px rgba(0,0,0,0.1)"
  },

};

export default App;