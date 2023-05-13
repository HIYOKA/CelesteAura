import React from "react";
import ReactDOM from "react-dom/client";
import 'bootstrap/dist/css/bootstrap.min.css';
import App from "./App";
import App2 from "./App2";
import App3 from "./App3";
import App4 from "./App4";
import App5 from "./App5";
import reportWebVitals from "./reportWebVitals";

const root = document.getElementById("root")
  ? ReactDOM.createRoot(document.getElementById("root"))
  : null;

const root2 = document.getElementById("root2")
  ? ReactDOM.createRoot(document.getElementById("root2"))
  : null;

const root3 = document.getElementById("root3")
  ? ReactDOM.createRoot(document.getElementById("root3"))
  : null;
  
  const root4 = document.getElementById("root4")
  ? ReactDOM.createRoot(document.getElementById("root4"))
  : null;
  
  const root5 = document.getElementById("root5")
  ? ReactDOM.createRoot(document.getElementById("root5"))
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

if (root3) {
  root3.render(
    <React.StrictMode>
      <App3 />
    </React.StrictMode>
  );
}

if (root4) {
  root4.render(
    <React.StrictMode>
      <App4 />
    </React.StrictMode>
  );
}

if (root5) {
  root5.render(
    <React.StrictMode>
      <App5 />
    </React.StrictMode>
  );
}

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();