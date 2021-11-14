import React from "react";
import { FormGroup } from "reactstrap";

function FormGroupPicasso({ children, className }) {
  return <FormGroup className={className}>{children}</FormGroup>;
}

export default FormGroupPicasso;
