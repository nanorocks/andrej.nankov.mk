import React from "react";
import { Row } from "reactstrap";

function RowPicasso({ className, children }) {
  return <Row className={className}>{children}</Row>;
}

export default RowPicasso;
