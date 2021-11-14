import React from "react";
import { Input } from "react-scripts";

function InputPicasso({ bsSize = "", type, className }) {
  return <Input bsSize={bsSize} type={type} className={className} />;
}

export default InputPicasso;
