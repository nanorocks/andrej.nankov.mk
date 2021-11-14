import React from "react";
import { Button } from "reactstrap";
function ButtonPicasso({ color, name, className, click }) {
  return (
    <Button className={className} color={color} onClick={click}>
      {name}
    </Button>
  );
}

export default ButtonPicasso;
