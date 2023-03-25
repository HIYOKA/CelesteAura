import React from "react";
import Button from "react-bootstrap/Button";

function MyButton() {
  const buttontest = (
    <div>
      <Button variant="dark">검정</Button>
      <Button variant="light">Light</Button>
    </div>
  );

  return buttontest;
}

export default MyButton;
