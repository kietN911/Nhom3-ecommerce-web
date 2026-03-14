import { useEffect, useState } from "react";

function App() {

  const [users, setUsers] = useState([]);

  useEffect(() => {
    fetch("https://nhom3-backend.onrender.com/users")
      .then(res => res.json())
      .then(data => setUsers(data));
  }, []);

  return (
    <div style={{padding:"40px"}}>
      <h1>Danh sách Users</h1>

      {users.map(user => (
        <p key={user.id}>
          {user.name} - {user.email}
        </p>
      ))}

    </div>
  );
}

export default App;