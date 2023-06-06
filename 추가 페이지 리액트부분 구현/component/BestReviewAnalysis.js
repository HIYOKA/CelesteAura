import React, { useState, useEffect } from "react"; // useState : 함수형 컴포넌트에서 상태를 관리하는 Hook
// useEffect : 컴포넌트가 렌더링 될 때마다 특정 작업을 수행하도록 설정하는 Hook https://xiubindev.tistory.com/100
import _ from "lodash"; // lodash : 자바스크립트 유틸리티 라이브러리
import axios from "axios"; // axios : HTTP 비동기 통신 라이브러리
import {
  WOOCOMMERCE_API_KEY,
  WOOCOMMERCE_API_SECRET,
} from "./woocommerceConfig"; // woocommerceConfig.js 파일에서 API 키와 시크릿을 가져옴

const fetchProducts = async () => {
  //async : 비동기 함수 선언 https://springfall.cc/post/7
  //비동기 함수 : 함수의 실행이 완료되기 전에 반환되는 함수, 호출 시점에서 실행 결과를 기다리지 않는 함수
  //동기 함수 : 함수의 실행이 완료된 후에 반환되는 함수
  // 판매수량을 기준으로 상품 정렬해서 가져오는 함수
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

  const reviews = await fetchReviews(); // await : 비동기 함수 호출 시 사용, 해당 함수가 끝날 때까지 기다림

  const products = response.data.map((product) => {
    //
    const productReviews = reviews.filter(
      (review) => review.product_id === product.id // 리뷰에서 상품 아이디가 일치하는 것만 필터링
    );
    // 리뷰에서 단어 빈도수를 계산하는 부분
    const wordsFrequency = _.chain(productReviews) //https://lodash.com/docs 참고
      .map(
        // map : 배열의 각 요소에 대해 함수를 적용한 결과를 새로운 배열로 반환
        (review) =>
          review.review
            .replace(/<[^>]*>/g, "") //html 태그 제거
            .replace(/,/g, "") // 쉼표 제거
            .split(/\s+/) // 공백으로 단어 분리
      )
      .flatten() // 2차원 배열을 1차원 배열로 변환
      .countBy() // 단어별 빈도수 계산
      .toPairs() // 객체를 배열로 변환
      .sortBy((pair) => -pair[1]) // 빈도수를 기준으로 내림차순 정렬
      .take(10) // 상위 10개만 추출
      .map((pair) => pair[0]) // 단어만 추출
      .value(); // lodash 연산 결과 반환

    const topWords = wordsFrequency.join(", "); // 단어들을 쉼표로 구분하여 문자열로 변환
    return {
      id: product.id,
      name: product.name,
      permalink: product.permalink,
      image: product.images[0].src,
      category: product.categories[0].name,
      personalcolor: product.tags[1].name,
      sold: product.total_sales,
      text: topWords,
    };
  });

  // 팔린 수량을 기준으로 상품 정렬
  products.sort((a, b) => b.sold - a.sold);

  // 상위 10개의 상품만 반환
  return products.slice(0, 10);
};

const fetchReviews = async () => {
  // 상품 리뷰를 가져오는 함수
  const response = await axios.get(
    "https://celesteaura.com/wp-json/wc/v3/products/reviews",
    {
      headers: {
        // 헤더에 인증 정보를 추가, 헤더 : HTTP 요청이나 응답의 시작 부분에 위치하는 메타 정보
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
    // 상품 데이터를 가져오는 부분
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
                <a
                  href={product.permalink}
                  target="_self"
                  rel="noopener noreferrer"
                >
                  <img src={product.image} alt={product.name} width="100" />
                </a>
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
