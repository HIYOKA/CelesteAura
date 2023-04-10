import React, { useState, useEffect } from "react";
import axios from "axios";

const WP_API_URL = "https://celesteaura.com/wp-json/mo/v1";

function Test() {
  const [data, setData] = useState([]);

  useEffect(() => {
    const axiosData = async () => {
      try {
        const response = await axios.get(`${WP_API_URL}/data`);
        console.log('res', response.data);
        setData(response.data);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };
    axiosData();
  }, []);

  return (
    <div className="App">
      <h1>Custom Data</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          {data.map((item) => (
            <tr key={item.id}>
              <td>{item.id}</td>
              <td>{item.name}</td>
              <td>{item.value}</td>
              <td><img src={item.url} alt="null" /></td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default Test;