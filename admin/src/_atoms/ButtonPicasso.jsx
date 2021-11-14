import React from "react";
import { Button } from "reactstrap";
function ButtonPicasso({ color, name, className }) {
  return (
    <Button className={className} color={color}>
      {name}
    </Button>
  );
}

export default ButtonPicasso;
