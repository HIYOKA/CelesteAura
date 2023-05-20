import React, { useState, useEffect } from "react";
import _ from "lodash";
import axios from "axios";
import {
  WOOCOMMERCE_API_KEY,
  WOOCOMMERCE_API_SECRET,
} from "./woocommerceConfig";

const fetchProducts = async () => {
  const response = await axios.get(
    "https://celesteaura.com/wp-json/wc/v3/products",
    {
      headers: {
        Authorization:
          "Basic " + btoa(`${WOOCOMMERCE_API_KEY}:${WOOCOMMERCE_API_SECRET}`),
      },
      params: {
        orderby: "popularity",
        order: "desc",
        per_page: 10,
      },
    }
  );

  const reviews = await fetchReviews();

  const products = response.data.map((product) => {
    const productReviews = reviews.filter(
      (review) => review.product_id === product.id
    );

    const wordsFrequency = _.chain(productReviews)
      .map((review) =>
        review.review
          .replace(/<[^>]*>/g, "")
          .replace(/,/g, "")
          .split(/\s+/)
      )
      .flatten()
      .countBy()
      .toPairs()
      .sortBy((pair) => -pair[1])
      .take(10)
      .map((pair) => pair[0])
      .value();

    const topWords = wordsFrequency.join(", ");
    return {
      id: product.id,
      name: product.name,
      image: product.images[0].src,
      category: product.categories[0].name,
      personalcolor: product.tags[1].name,
      sold: product.total_sales,
      //Math.floor(Math.random() * 1000), // 임의의 팔린 수량 값
      text: topWords,
      //getRandomEmotion(), // 임의의 텍스트 값
    };
  });

  // 팔린 수량을 기준으로 상품 정렬
  products.sort((a, b) => b.sold - a.sold);

  // 상위 10개의 상품만 반환
  return products.slice(0, 10);
};

const fetchReviews = async () => {
  const response = await axios.get(
    "https://celesteaura.com/wp-json/wc/v3/products/reviews",
    {
      headers: {
        Authorization:
          "Basic " + btoa(`${WOOCOMMERCE_API_KEY}:${WOOCOMMERCE_API_SECRET}`),
      },
      params: {
        per_page: 100,
      },
    }
  );

  return response.data;
};

const TopProducts = () => {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      const fetchedProducts = await fetchProducts();
      setProducts(fetchedProducts);
    };

    fetchData();
  }, []);

  return (
    <div style={{ display: "flex", justifyContent: "center" }}>
      <div>
        <a href="https://celesteaura.com/manager/">
          <button style={buttonStyle}>
            의류 타입별<br></br> 리뷰분석
          </button>
        </a>
        <br></br>
                <a href="https://celesteaura.com/manager-3/">
          <button style={buttonStyle}>
            퍼스널컬러별<br></br>리뷰분석
          </button>
        </a>
        <br></br>
        <a href="https://celesteaura.com/manager-2/">
          <button style={buttonStyle}>
            베스트<br></br>감성분석
          </button>
        </a>
      </div>
      <table>
        <thead>
          <tr>
            <th style={headerCellStyle}>순위</th>
            <th style={headerCellStyle}>이미지</th>
            <th style={headerCellStyle}>이름</th>
            <th style={headerCellStyle}>의류타입</th>
            <th style={headerCellStyle}>퍼스널컬러</th>
            <th style={headerCellStyle}>판매수량</th>
            <th style={headerCellStyle}>감성(빈도수에 따라 최대 10개)</th>
          </tr>
        </thead>
        <tbody>
          {products.map((product, index) => (
            <tr key={product.id}>
              <td style={cellStyle}>{index + 1}</td>
              <td style={cellStyle}>
                <img src={product.image} alt={product.name} width="100" />
              </td>
              <td style={cellStyle}>{product.name}</td>
              <td style={cellStyle}>{product.category}</td>
              <td style={cellStyle}>{product.personalcolor}</td>
              <td style={cellStyle}>{product.sold}</td>
              <td style={cellStyle}>{product.text}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

const headerCellStyle = {
  textAlign: "center",
  padding: "8px",
  border: "1px solid black",
  fontWeight: "bold",
  backgroundColor: "#f2f2f2",
  whiteSpace: "nowrap",
};

const cellStyle = {
  textAlign: "center",
  padding: "8px",
  border: "1px solid black",
  whiteSpace: "nowrap",
};
const buttonStyle = {
  width: "160px", 
  height: "70px", 
};
export default TopProducts;