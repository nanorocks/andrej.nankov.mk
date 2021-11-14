import React from 'react'
import { Container } from "reactstrap";

function ContainerPicasso({children, className, fluid}) {
  return (
    <Container className={className} fluid={fluid}>
      {children}
    </Container>
  );
}

export default ContainerPicasso;
