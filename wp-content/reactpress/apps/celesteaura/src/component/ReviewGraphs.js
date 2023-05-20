import React, { useState, useEffect } from "react";
import "./custom.css";

import axios from "axios";
import {
  WOOCOMMERCE_API_KEY,
  WOOCOMMERCE_API_SECRET,
} from "./woocommerceConfig";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  PieChart,
  Pie,
  Cell,
} from "recharts";

const ReviewGraphs = () => {
  const [reviews, setReviews] = useState([]);
  const [TrousersreviewCount, setTrousersreviewCount] = useState(0);
  const [TopreviewCount, setTopreviewCount] = useState(0);
  const [SkirtreviewCount, setSkirtreviewCount] = useState(0);
  const [DressreviewCount, setDressreviewCount] = useState(0);
  const [JacketreviewCount, setJacketreviewCount] = useState(0);
  const [CardiganreviewCount, setCardiganreviewCount] = useState(0);
  const [HoodiereviewCount, setHoodiereviewCount] = useState(0);
  const [CoatreviewCount, setCoatreviewCount] = useState(0);
  const [TrousersratingSum, setTrousersratingSum] = useState(0);
  const [TopratingSum, setTopratingSum] = useState(0);
  const [SkirtratingSum, setSkirtratingSum] = useState(0);
  const [DressratingSum, setDressratingSum] = useState(0);
  const [JacketratingSum, setJacketratingSum] = useState(0);
  const [CardiganratingSum, setCardiganratingSum] = useState(0);
  const [HoodieratingSum, setHoodieratingSum] = useState(0);
  const [CoatratingSum, setCoatratingSum] = useState(0);
  const data = [
    {
      category: "Trousers",
      reviewCount: TrousersreviewCount,
      avgRating:
        TrousersreviewCount === 0
          ? Number((4.22).toFixed(1))
          : Number((TrousersratingSum / TrousersreviewCount).toFixed(1)),
    },
    {
      category: "Top",
      reviewCount: TopreviewCount,
      avgRating:
        TopreviewCount === 0
          ? 3.5
          : Number((TopratingSum / TopreviewCount).toFixed(1)),
    },
    {
      category: "Skirt",
      reviewCount: SkirtreviewCount,
      avgRating:
        SkirtreviewCount === 0
          ? 2
          : Number((SkirtratingSum / SkirtreviewCount).toFixed(1)),
    },
    {
      category: "Dress",
      reviewCount: DressreviewCount,
      avgRating:
        DressreviewCount === 0
          ? 1
          : Number((DressratingSum / DressreviewCount).toFixed(1)),
    },
    {
      category: "Jacket",
      reviewCount: JacketreviewCount,
      avgRating:
        JacketreviewCount === 0
          ? 4.8
          : Number((JacketratingSum / JacketreviewCount).toFixed(1)),
    },
    {
      category: "Cardigan",
      reviewCount: CardiganreviewCount,
      avgRating:
        CardiganreviewCount === 0
          ? 3.1
          : Number((CardiganratingSum / CardiganreviewCount).toFixed(1)),
    },
    {
      category: "Hoodie",
      reviewCount: HoodiereviewCount,
      avgRating:
        HoodiereviewCount === 0
          ? 1.9
          : Number((HoodieratingSum / HoodiereviewCount).toFixed(1)),
    },
    {
      category: "Coat",
      reviewCount: CoatreviewCount,
      avgRating:
        CoatreviewCount === 0
          ? 3.4
          : Number((CoatratingSum / CoatreviewCount).toFixed(1)),
    },
  ];

  const COLORS = [
    "#0088FE",
    "#00C49F",
    "#FFBB28",
    "#FF8042",
    "#8884d8",
    "#8dd1e1",
    "#82ca9d",
    "#a4de6c",
  ];
  useEffect(() => {
    const fetchData = async () => {
      const result = await axios.get(
        "https://celesteaura.com/wp-json/wc/v3/products/reviews",
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
      setReviews(result.data);

      const productIds = result.data.map((review) => review.product_id);
      const ratings = result.data.map((review) => review.rating);

      if (productIds.length > 0) {
        updateReviewCounts(productIds, ratings);
      }
    };

    const updateReviewCounts = async (productIds, ratings) => {
      for (let i = 0; i < productIds.length; i++) {
        const productId = productIds[i];
        const rating = ratings[i];

        const productData = await fetchProductData(productId);

        if (productData.categories[0].name === "Trousers") {
          setTrousersreviewCount((prev) => prev + 1);
          setTrousersratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Top") {
          setTopreviewCount((prev) => prev + 1);
          setTopratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Skirt") {
          setSkirtreviewCount((prev) => prev + 1);
          setSkirtratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Dress") {
          setDressreviewCount((prev) => prev + 1);
          setDressratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Jacket") {
          setJacketreviewCount((prev) => prev + 1);
          setJacketratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Cardigan") {
          setCardiganreviewCount((prev) => prev + 1);
          setCardiganratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Hoodie") {
          setHoodiereviewCount((prev) => prev + 1);
          setHoodieratingSum((prev) => prev + rating);
        } else if (productData.categories[0].name === "Coat") {
          setCoatreviewCount((prev) => prev + 1);
          setCoatratingSum((prev) => prev + rating);
        } else {
          console.log("error");
        }
      }
    };

    fetchData();
  }, []);

  const fetchProductData = async (productId) => {
    try {
      const response = await axios.get(
        `https://celesteaura.com/wp-json/wc/v3/products/${productId}`,
        {
          headers: {
            Authorization:
              "Basic " +
              btoa(`${WOOCOMMERCE_API_KEY}:${WOOCOMMERCE_API_SECRET}`),
          },
        }
      );
      return response.data;
    } catch (error) {
      console.error("Error fetching product data:", error);
    }
  };

  return (
    <div style={{ display: "flex", justifyContent: "center" }}>
      <div>
        <a href="https://celesteaura.com/manager/">
          <button style={buttonStyle}>
            의류 타입별<br></br>리뷰분석
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
      <br></br>
      <div>
        <BarChart
          width={630}
          height={400}
          data={data}
          margin={{
            top: 5,
            right: 30,
            left: 20,
            bottom: 5,
          }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="category" />
          <YAxis />
          <Tooltip />
          <Bar dataKey="reviewCount" fill="#8884d8" />
          <br></br>
          <br></br>
          <Legend />
        </BarChart>
                      <br></br>
        <h3 style={{ textAlign: "center" }}>의류 타입별 리뷰수</h3>
      </div>
      <div>
        <PieChart width={420} height={400}>
          <Pie
            data={data}
            cx="50%"
            cy="50%"
            labelLine={false}
            label={({ category, avgRating }) => `${category}: ${avgRating}`}
            outerRadius={80}
            fill="#8884d8"
            dataKey="avgRating"
          >
            {data.map((entry, index) => (
              <Cell
                key={`cell-${index}`}
                fill={COLORS[index % COLORS.length]}
              />
            ))}
          </Pie>
          <Tooltip
            formatter={(value, name, entry) => [
              value.toFixed(1),
              entry.payload.category,
            ]}
          />
        </PieChart>
                      <br></br>
        <h3 style={{ textAlign: "center" }}>의류 타입별 평균 별점</h3>
      </div>
    </div>
  );
};
const buttonStyle = {
  width: "160px",
  height: "70px",
};

export default ReviewGraphs;