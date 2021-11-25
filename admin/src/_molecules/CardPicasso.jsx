/* eslint-disable react/jsx-no-duplicate-props */
import React from "react";
import { Card, CardBody, CardTitle, CardSubtitle, CardText } from "reactstrap";

import { RowPicasso, ColPicasso } from "./../_atoms/_index";

function CardPicasso({ title, subtitle, content, className }) {
  return (
    <RowPicasso>
      <ColPicasso>
        <Card className={`shadow border-0 mb-4 ${className}`} style={{ borderRadius: '12px'}}>
          <CardBody>
            <CardTitle tag="h5">{title}</CardTitle>
            <CardSubtitle className="mb-2 text-muted" tag="h6">
              {subtitle}
            </CardSubtitle>
            <CardText tag="div">{content}</CardText>
          </CardBody>
        </Card>
      </ColPicasso>
    </RowPicasso>
  );
}

export default CardPicasso;
