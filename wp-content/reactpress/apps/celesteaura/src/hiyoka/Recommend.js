import React, { useState } from "react";
import axios from "axios";
import "./hiyoka.css";
import {
  WOOCOMMERCE_API_KEY,
  WOOCOMMERCE_API_SECRET,
} from "./woocommerceConfig";

const Recommend = () => {
  const [selectedCategory, setSelectedCategory] = useState("");
  const [selectedColor, setSelectedColor] = useState("");
  const [product, setProduct] = useState(null);
  const [noProductFound, setNoProductFound] = useState(false);
  const [recommendMethod, setrecommendMethod] = useState("random");

  const handleCategoryChange = (e) => {
    setSelectedCategory(e.target.value);
    setNoProductFound(false);
  };

  const handleColorChange = (e) => {
    setSelectedColor(e.target.value);
    setNoProductFound(false);
  };
  const handleRecommendMethodChange = (e) => {
    setrecommendMethod(e.target.value);
    setNoProductFound(false);
  };

  async function getCategoryID(categoryName) {
    try {
      const response = await axios.get(
        "https://celesteaura.com/wp-json/wc/v3/products/categories",
        {
          headers: {
            Authorization:
              "Basic " +
              btoa(`${WOOCOMMERCE_API_KEY}:${WOOCOMMERCE_API_SECRET}`),
          },
        }
      );
      const categories = response.data;
      const category = categories.find((cat) => cat.name === categoryName);
      return category?.id;
    } catch (error) {
      console.error("Error fetching categories:", error);
    }
  }

  async function getTagID(tagName) {
    try {
      const response = await axios.get(
        "https://celesteaura.com/wp-json/wc/v3/products/tags",
        {
          headers: {
            Authorization:
              "Basic " +
              btoa(`${WOOCOMMERCE_API_KEY}:${WOOCOMMERCE_API_SECRET}`),
          },
          params: {
            per_page: 100,
          },
        }
      );
      const tags = response.data;
      const tag = tags.find((t) => t.name === tagName);

      return tag?.id;
    } catch (error) {
      console.error("Error fetching tags:", error);
    }
  }

  const recommendProduct = async () => {
    try {
      const categoryID = await getCategoryID(selectedCategory);
      const tagID = await getTagID(selectedColor);

      const response = await axios.get(
        "https://celesteaura.com/wp-json/wc/v3/products",
        {
          headers: {
            Authorization:
              "Basic " +
              btoa(`${WOOCOMMERCE_API_KEY}:${WOOCOMMERCE_API_SECRET}`),
          },
          params: {
            category: categoryID,
            tag: tagID,
            per_page: 100,
          },
        }
      );

      const products = response.data;
      if (recommendMethod === "high_rating") {
        const highRatedProducts = products.filter((product) => {
          return product.average_rating >= 4.0;
        });

        if (highRatedProducts.length > 0) {
          const randomIndex = Math.floor(
            Math.random() * highRatedProducts.length
          );
          setProduct(highRatedProducts[randomIndex]);
          setNoProductFound(false);
        } else {
          setNoProductFound(true);
        }
      } else if (recommendMethod === "random" && products.length > 0) {
        const randomIndex = Math.floor(Math.random() * products.length);
        setProduct(products[randomIndex]);
        setNoProductFound(false);
      } else {
        setNoProductFound(true);
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  };

  return (
    <div id="randomrecommendpage">
      <h2
        style={{
          textAlign: "center",
          paddingTop: "20px",
          paddingBottom: "20px",
        }}
      >
        무슨 상품을 고를까요? 걱정 마세요, 저희가 도와드릴게요!
      </h2>
      <div className="container">
        <select className="select-input" onChange={handleRecommendMethodChange} value={recommendMethod}>
          <option value="random">-- 방식 선택--</option>
          <option value="high_rating">높은평점</option>
        </select>
        <select className="select-input" onChange={handleColorChange} value={selectedColor}>
          <option value="">-- 퍼스널컬러 선택 --</option>
          <option value="spring_pastel">spring_pastel</option>
          <option value="spring_bright">spring_bright</option>
          <option value="summer_light">summer_light</option>
          <option value="summer_mute">summer_mute</option>
          <option value="fall_deep">fall_deep</option>
          <option value="fall_mute">fall_mute</option>
          <option value="winter_deep">winter_deep</option>
          <option value="winter_bright">winter_bright</option>
        </select>
        <select className="select-input" onChange={handleCategoryChange} value={selectedCategory}>
          <option value="">-- 카테고리 선택 --</option>
          <option value="Trousers">Trousers</option>
          <option value="Top">Top</option>
          <option value="Skirt">Skirt</option>
          <option value="Dress">Dress</option>
          <option value="Jacket">Jacket</option>
          <option value="Cardigan">Cardigan</option>
          <option value="Hoodie">Hoodie</option>
          <option value="Coat">Coat</option>
        </select>

        <button className="recommend-button" onClick={recommendProduct}>
          상품 추천
        </button>
      </div>
      <br></br>
      {recommendMethod === "random" && (
        <p
          style={{
            textAlign: "center",
            border: "2px solid black",
          }}
        >
          선택하지 않으면 랜덤으로 추천합니다.
        </p>
      )}
      {recommendMethod === "high_rating" && (
        <p
          style={{
            textAlign: "center",
            border: "2px solid black",
          }}
        >
          평점이 4점 이상인 상품을 추천합니다.
        </p>
      )}
      {noProductFound && (
        <p
          style={{
            textAlign: "center",
          }}
        >
          방식({recommendMethod}), 퍼스널컬러({selectedColor}), 카테고리(
          {selectedCategory})에 해당하는 상품이 없습니다.
        </p>
      )}
      <div
        className="productrandom"
        style={{
          height: "100%",
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
        }}
      >
        {product && (
          <div key={product.id} className="product">
            <a
              href={product.permalink}
              target="_self"
              rel="noopener noreferrer"
            >
              <img
                src={product.images[0]?.src}
                alt={product.images[0]?.alt}
                style={{ width: "430px", height: "auto" }}
              />
            </a>
            <br></br>
            <a
              href={product.permalink}
              target="_self"
              rel="noopener noreferrer"
            >
              <span className="product-name">{product.name}</span>
            </a>
            <br></br>
            <span className="product-category">
              {product.categories[0]?.name}
            </span>
            <br></br>
            <span className="product-personalcolor">
              {product.tags[1]?.name}
            </span>
            <br></br>
            <span className="product-price">\{product.price}</span>
          </div>
        )}
      </div>
    </div>
  );
};

export default Recommend;