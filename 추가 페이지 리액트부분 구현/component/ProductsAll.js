import React, { useState } from "react"; // useState : 함수형 컴포넌트에서 상태를 관리하는 Hook
import axios from "axios"; // axios : HTTP 비동기 통신 라이브러리
import "./custom.css";
import Pagination from "./Pagination";
import {
  WOOCOMMERCE_API_KEY,
  WOOCOMMERCE_API_SECRET,
} from "./woocommerceConfig"; // woocommerceConfig.js 파일에서 API 키와 시크릿을 가져옴

const ProductsAll = () => {
  const [selectedCategory, setSelectedCategory] = useState("");
  const [selectedColor, setSelectedColor] = useState("");
  const [products, setProducts] = useState([]);
  const [noProductFound, setNoProductFound] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 8;
  const endIndex = currentPage * itemsPerPage;
  const startIndex = endIndex - itemsPerPage;
  const currentProducts = products.slice(startIndex, endIndex); // slice : 배열의 일부분을 선택하여 새로운 배열을 만듦

  const totalPages = Math.ceil(products.length / itemsPerPage); // ceil : 올림

  const handleCategoryChange = (e) => {
    setSelectedCategory(e.target.value);
    setNoProductFound(false);
  };

  const handleColorChange = (e) => {
    setSelectedColor(e.target.value);
    setNoProductFound(false);
  };

  async function getCategoryID(categoryName) {
    // 카테고리 이름을 받아서 해당 카테고리의 ID를 반환하는 함수
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
    // 태그 이름을 받아서 해당 태그의 ID를 반환하는 함수
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
    // 상품을 검색하는 함수
    try {
      setCurrentPage(1);
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
      if (products.length > 0) {
        setProducts(products);
        setNoProductFound(false);
      } else {
        setNoProductFound(true);
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  };

  return (
    <div id="allproductpage">
      <h2
        style={{
          textAlign: "center",
          paddingTop: "20px",
          paddingBottom: "20px",
        }}
      >
        소중한 퍼스널 컬러를 빛내는 완벽한 아이템을 발견하세요.
      </h2>
      <div className="container">
        <select
          className="select-input"
          onChange={handleColorChange}
          value={selectedColor}
        >
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
        <select
          className="select-input"
          onChange={handleCategoryChange}
          value={selectedCategory}
        >
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
        <button className="search-button" onClick={recommendProduct}>
          상품 검색
        </button>
      </div>
      {noProductFound && (
        <p>
          선택한 퍼스널 컬러(<strong>{selectedColor}</strong>)와 카테고리(
          <strong>{selectedCategory}</strong>)에 해당하는 상품이 없습니다.
        </p>
      )}
      <br></br>
      <div className="products">
        {currentProducts.map((product) => (
          <div key={product.id} className="product">
            <a
              href={product.permalink}
              target="_self"
              rel="noopener noreferrer"
            >
              <img
                src={product.images[0]?.src}
                alt={product.images[0]?.alt}
                style={{ width: "200px", height: "auto" }}
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
            <span className="product-price">&#8361;{product.price}</span>
          </div>
        ))}
      </div>
      <Pagination
        totalPages={totalPages}
        currentPage={currentPage}
        setCurrentPage={setCurrentPage}
      />
    </div>
  );
};

export default ProductsAll;
