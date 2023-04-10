import React, { useState, useEffect } from "react";
import axios from "axios";

function Posts() {
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    axios
      .get("https://celesteaura.com/wp-json/wp/v2/posts")
      .then((response) => setPosts(response.data))
      .then((response) => console.log(response))
      .catch((error) => console.error(error));
  }, []);

  return (
    <ul>
      {posts.map((post) => (
        <li key={post.id}>
          <h2>{post.title.rendered}</h2>
          <div dangerouslySetInnerHTML={{ __html: post.content.rendered }} />
        </li>
      ))}
    </ul>
  );
}

export default Posts;