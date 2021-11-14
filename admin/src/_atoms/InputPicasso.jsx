import React from "react";
import { Input } from "reactstrap";

function InputPicasso({ bsSize = "", type, className }) {
  return <Input bsSize={bsSize} type={type} className={className} />;
}

export default InputPicasso;
