import React from "react";
import { Label } from "reactstrap";

function LabelPicasso({ forInput, text }) {
  return (
    <Label for={forInput}>
      {text}
    </Label>
  );
}

export default LabelPicasso;
