import React, { useEffect, useState } from "react";
import axios from "axios";

const CustomDataApp = () => {
  const [data, setData] = useState([]);
  const [formData, setFormData] = useState({ name: "", value: "", url: "" });
  const [editingId, setEditingId] = useState(null);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const response = await axios.get(
        "https://celesteaura.com/wp-json/custom-data/v1/item"
      );
      setData(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (editingId) {
      try {
        await axios.put(
          `https://celesteaura.com/wp-json/custom-data/v1/item/${editingId}`,
          formData
        );
        setEditingId(null);
      } catch (error) {
        console.error(error);
      }
    } else {
      try {
await axios.post(
  "https://celesteaura.com/wp-json/custom-data/v1/item",
  formData,
  {
    headers: {
      "Content-Type": "application/json; charset=utf-8",
    },
  }
);
      } catch (error) {
        console.error(error);
      }
    }
    fetchData();
    setFormData({ name: "", value: "", url: "" });
  };

  const handleDelete = async (id) => {
    try {
      await axios.delete(
        `https://celesteaura.com/wp-json/custom-data/v1/item/${id}`
      );
      fetchData();
    } catch (error) {
      console.error(error);
    }
  };

  const handleEdit = (item) => {
    setFormData({ name: item.name, value: item.value, url: item.url });
    setEditingId(item.id);
  };

  return (
    <div>
      <h1>Custom Data</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Name"
          value={formData.name}
          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
        />
        <input
          type="text"
          placeholder="Value"
          value={formData.value}
          onChange={(e) => setFormData({ ...formData, value: e.target.value })}
        />
        <input
          type="text"
          placeholder="URL"
          value={formData.url}
          onChange={(e) => setFormData({ ...formData, url: e.target.value })}
        />
        <button type="submit">{editingId ? "Update" : "Create"}</button>
      </form>
      {data.map((item) => (
        <div key={item.id}>
          <h2>{item.name}</h2>
          <p>{item.value}</p>
          <img src={item.url} alt="text"></img>
          <button onClick={() => handleEdit(item)}>Edit</button>
          <button onClick={() => handleDelete(item.id)}>Delete</button>
        </div>
      ))}
    </div>
  );
};

export default CustomDataApp;