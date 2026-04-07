import { useState } from "react";
import axios from "axios";
import { useNavigate, Link } from "react-router-dom";

function Register() {
  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const navigate = useNavigate();

  const handleRegister = async () => {
    try {
      await axios.post("http://localhost:5000/api/auth/register", {
        username,
        email,
        password
      });

      alert("Đăng ký thành công");
      navigate("/login");

    } catch (err) {
      alert("Lỗi đăng ký");
    }
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>
        <h2 className="text-center mb-4">📝 Đăng ký</h2>

        <input
          className="form-control mb-3"
          placeholder="Username"
          onChange={e => setUsername(e.target.value)}
        />

        <input
          className="form-control mb-3"
          placeholder="Email"
          onChange={e => setEmail(e.target.value)}
        />

        <input
          type="password"
          className="form-control mb-3"
          placeholder="Password"
          onChange={e => setPassword(e.target.value)}
        />

        <button className="btn btn-primary w-100" onClick={handleRegister}>
          Đăng ký
        </button>

        <p className="text-center mt-3">
          Đã có tài khoản? <Link to="/login">Đăng nhập</Link>
        </p>
      </div>
    </div>
  );
}

const styles = {
  container: {
    height: "100vh",
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
  card: {
    width: "350px",
    padding: "30px",
    borderRadius: "15px",
    background: "#fff",
    boxShadow: "0 10px 30px rgba(0,0,0,0.2)"
  }
};

export default Register;