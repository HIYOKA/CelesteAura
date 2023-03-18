import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import App2 from "./App2";
import App3 from "./App3";

const root = document.getElementById("root")
  ? ReactDOM.createRoot(document.getElementById("root"))
  : null;

const root2 = document.getElementById("root2")
  ? ReactDOM.createRoot(document.getElementById("root2"))
  : null;


  const contact = document.getElementById("contact")
  ? ReactDOM.createRoot(document.getElementById("contact"))
  : null;

if (root) {
  root.render(
    <React.StrictMode>
      <App />
    </React.StrictMode>
  );
}

if (root2) {
  root2.render(
    <React.StrictMode>
      <App2 />
    </React.StrictMode>
  );
}

if (contact) {
  contact.render(
    <React.StrictMode>
      <App3 />
    </React.StrictMode>
  );
}

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
