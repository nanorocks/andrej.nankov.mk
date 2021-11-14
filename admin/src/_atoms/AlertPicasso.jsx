import React from "react";
import { Alert } from "reactstrap";

function AlertPicasso({ color, msg }) {
  return (
    <div>
      <Alert color={color}>{msg}</Alert>
    </div>
  );
}

export default AlertPicasso;
