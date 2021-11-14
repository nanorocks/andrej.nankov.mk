import React from "react";
import { ListGroupItem } from "reactstrap";

function ListGroupItemPicasso({ text, url }) {
  return (
    <ListGroupItem href={url} tag="a">
      {text}
    </ListGroupItem>
  );
}

export default ListGroupItemPicasso;
