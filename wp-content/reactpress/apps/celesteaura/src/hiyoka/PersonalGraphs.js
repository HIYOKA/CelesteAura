import React, { useState, useEffect } from "react";
import "./hiyoka.css";

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
  const [spring_pastelcount, setspring_pastelcount] = useState(0);
  const [spring_brightcount, setspring_brightcount] = useState(0);
  const [summer_lightcount, setsummer_lightcount] = useState(0);
  const [summer_mutecount, setsummer_mutecount] = useState(0);
  const [fall_deepcount, setfall_deepcount] = useState(0);
  const [fall_mutecount, setfall_mutecount] = useState(0);
  const [winter_deepcount, setwinter_deepcount] = useState(0);
  const [winter_mutedcount, setwinter_mutedcount] = useState(0);
  const [spring_pastelratingSum, setspring_pastelratingSum] = useState(0);
  const [spring_brightratingSum, setspring_brightratingSum] = useState(0);
  const [summer_lightratingSum, setsummer_lightratingSum] = useState(0);
  const [summer_muteratingSum, setsummer_muteratingSum] = useState(0);
  const [fall_deepratingSum, setfall_deepratingSum] = useState(0);
  const [fall_muteratingSum, setfall_muteratingSum] = useState(0);
  const [winter_deepratingSum, setwinter_deepratingSum] = useState(0);
  const [winter_mutedratingSum, setwinter_mutedratingSum] = useState(0);
  const data = [
    {
      category: "spring_pastel",
      reviewCount: spring_pastelcount,
      avgRating:
        spring_pastelcount === 0
          ? Number((4.22).toFixed(1))
          : Number((spring_pastelratingSum / spring_pastelcount).toFixed(1)),
    },
    {
      category: "spring_bright",
      reviewCount: spring_brightcount,
      avgRating:
        spring_brightcount === 0
          ? Number((3.5).toFixed(1))
          : Number((spring_brightratingSum / spring_brightcount).toFixed(1)),
    },
    {
      category: "summer_light",
      reviewCount: summer_lightcount,
      avgRating:
        summer_lightcount === 0
          ? Number((3.5).toFixed(1))
          : Number((summer_lightratingSum / summer_lightcount).toFixed(1)),
    },
    {
      category: "summer_mute",
      reviewCount: summer_mutecount,
      avgRating:
        summer_mutecount === 0
          ? Number((3.5).toFixed(1))
          : Number((summer_muteratingSum / summer_mutecount).toFixed(1)),
    },
    {
      category: "fall_deep",
      reviewCount: fall_deepcount,
      avgRating:
        fall_deepcount === 0
          ? Number((3.5).toFixed(1))
          : Number((fall_deepratingSum / fall_deepcount).toFixed(1)),
    },
    {
      category: "fall_mute",
      reviewCount: fall_mutecount,
      avgRating:
        fall_mutecount === 0
          ? Number((3.5).toFixed(1))
          : Number((fall_muteratingSum / fall_mutecount).toFixed(1)),
    },
    {
      category: "winter_deep",
      reviewCount: winter_deepcount,
      avgRating:
        winter_deepcount === 0
          ? Number((3.5).toFixed(1))
          : Number((winter_deepratingSum / winter_deepcount).toFixed(1)),
    },
    {
      category: "winter_bright",
      reviewCount: winter_mutedcount,
      avgRating:
        winter_mutedcount === 0
          ? Number((3.5).toFixed(1))
          : Number((winter_mutedratingSum / winter_mutedcount).toFixed(1)),
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

        var category = productData.tags[1]?.name;

        if (category === "spring_pastel") {
          setspring_pastelcount((prev) => prev + 1);
          setspring_pastelratingSum((prev) => prev + rating);
        } else if (category === "spring_bright") {
          setspring_brightcount((prev) => prev + 1);
          setspring_brightratingSum((prev) => prev + rating);
        } else if (category === "summer_light") {
          setsummer_lightcount((prev) => prev + 1);
          setsummer_lightratingSum((prev) => prev + rating);
        } else if (category === "summer_mute") {
          setsummer_mutecount((prev) => prev + 1);
          setsummer_muteratingSum((prev) => prev + rating);
        } else if (category === "fall_deep") {
          setfall_deepcount((prev) => prev + 1);
          setfall_deepratingSum((prev) => prev + rating);
        } else if (category === "fall_mute") {
          setfall_mutecount((prev) => prev + 1);
          setfall_muteratingSum((prev) => prev + rating);
        } else if (category === "winter_deep") {
          setwinter_deepcount((prev) => prev + 1);
          setwinter_deepratingSum((prev) => prev + rating);
        } else if (category === "winter_bright") {
          setwinter_mutedcount((prev) => prev + 1);
          setwinter_mutedratingSum((prev) => prev + rating);
        } else {
          category = productData.tags[0]?.name;
          if (category === "spring_pastel") {
            setspring_pastelcount((prev) => prev + 1);
            setspring_pastelratingSum((prev) => prev + rating);
          } else if (category === "spring_bright") {
            setspring_brightcount((prev) => prev + 1);
            setspring_brightratingSum((prev) => prev + rating);
          } else if (category === "summer_light") {
            setsummer_lightcount((prev) => prev + 1);
            setsummer_lightratingSum((prev) => prev + rating);
          } else if (category === "summer_mute") {
            setsummer_mutecount((prev) => prev + 1);
            setsummer_muteratingSum((prev) => prev + rating);
          } else if (category === "fall_deep") {
            setfall_deepcount((prev) => prev + 1);
            setfall_deepratingSum((prev) => prev + rating);
          } else if (category === "fall_mute") {
            setfall_mutecount((prev) => prev + 1);
            setfall_muteratingSum((prev) => prev + rating);
          } else if (category === "winter_deep") {
            setwinter_deepcount((prev) => prev + 1);
            setwinter_deepratingSum((prev) => prev + rating);
          } else if (category === "winter_bright") {
            setwinter_mutedcount((prev) => prev + 1);
            setwinter_mutedratingSum((prev) => prev + rating);
          } else {
            console.log("No category found for product:", productData);
          }
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
    <div
      style={{
        display: "flex",
        justifyContent: "center",
      }}
    >
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
      <div style={{ flexDirection: "column", alignItems: "center" }}>
        <div>
          <BarChart
            width={1000}
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
                    <h3 style={{ textAlign: "center" }}>퍼스널컬러별 리뷰수</h3>
        </div>
        <div
          id="personalpiechart"
          style={{
            display: "flex",
            justifyContent: "center",
            flexDirection: "column",
            alignItems: "center",
          }}
        >
          <PieChart width={500} height={400}>
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
          <h3 style={{ textAlign: "center" }}>퍼스널컬러별 평균 별점</h3>
        </div>
      </div>
    </div>
  );
};
const buttonStyle = {
  width: "160px",
  height: "70px",
};

export default ReviewGraphs;