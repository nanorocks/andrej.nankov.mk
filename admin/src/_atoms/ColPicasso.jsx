import React from "react";
import { Col } from "reactstrap";
function ColPicasso({ children, className, xs, sm, md, lg }) {
  return (
    <Col className={className} md={md} sm={sm} lg={lg} xs={xs}>
      {children}
    </Col>
  );
}

export default ColPicasso;
