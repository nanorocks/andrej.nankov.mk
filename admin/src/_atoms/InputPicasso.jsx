import React from "react";
import { Input } from "reactstrap";

function InputPicasso({ bsSize = "", type, className }) {
  return <Input bsSize={bsSize} type={type} className={`border-0 border-bottom shadow-sm ${className}`} />;
}

export default InputPicasso;
