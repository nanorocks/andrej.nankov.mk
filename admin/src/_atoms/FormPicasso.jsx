import React from "react";
import { Form } from "reactstrap";

function FormPicasso({ children, className }) {
  return <Form className={className}>{children}</Form>;
}

export default FormPicasso;
