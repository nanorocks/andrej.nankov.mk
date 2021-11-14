/* eslint-disable react/jsx-no-duplicate-props */
import React from "react";
import { Card, CardBody, CardTitle, CardSubtitle, CardText } from "reactstrap";

import { ButtonPicasso, RowPicasso, ColPicasso } from "./../_atoms/_index";

function CardPicasso({ title, subtitle, content, btnColor, btnText, className }) {
  return (
    <RowPicasso>
      <ColPicasso>
        <Card className={className} className="shadow border-0 mb-4">
          <CardBody>
            <CardTitle tag="h5">{title}</CardTitle>
            <CardSubtitle className="mb-2 text-muted" tag="h6">
              {subtitle}
            </CardSubtitle>
            <CardText>{content}</CardText>
            <ButtonPicasso color={btnColor}>{btnText}</ButtonPicasso>
          </CardBody>
        </Card>
      </ColPicasso>
    </RowPicasso>
  );
}

export default CardPicasso;
