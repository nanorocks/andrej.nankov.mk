import React from "react";
import {
  Card,
  CardBody,
  CardTitle,
  CardSubtitle,
  CardText,
} from "reactstrap";

import ButtonPicasso from "./../_atoms/ButtonPicasso";

function CardPicasso({ title, subtitle, text, btnColor, btnText, className }) {
  return (
    <div>
      <Card className={className}>
        <CardBody>
          <CardTitle tag="h5">{title}</CardTitle>
          <CardSubtitle className="mb-2 text-muted" tag="h6">
            {subtitle}
          </CardSubtitle>
          <CardText>{text}</CardText>
          <ButtonPicasso color={btnColor}>{btnText}</ButtonPicasso>
        </CardBody>
      </Card>
    </div>
  );
}

export default CardPicasso;
