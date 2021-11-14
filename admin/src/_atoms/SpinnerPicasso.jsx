import React from "react";
import { Spinner } from "reactstrap";

function SpinnerPicasso({color, size, type}) {
  return (
    <Spinner color={color} size={size} type={type}>
      Loading...
    </Spinner>
  );
}

export default SpinnerPicasso;
