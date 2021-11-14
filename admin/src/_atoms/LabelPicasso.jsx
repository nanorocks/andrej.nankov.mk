import React from "react";
import { Label } from "reactstrap";

function LabelPicasso({ forInput, text }) {
  return (
    <Label for={forInput} hidden>
      {text}
    </Label>
  );
}

export default LabelPicasso;
