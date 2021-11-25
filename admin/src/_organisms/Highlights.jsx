import React from 'react'
import { CardPicasso, KeyValueListForm } from "./../_molecules/_index";

function Highlights() {
  return (
    <>
      <CardPicasso
        title="Highlights"
        subtitle="Last Update 2 Months Ago"
        content={
          <KeyValueListForm
            header="New Highlight"
            btnName="New Highlight"
            label="Add"
            addNew="Add new" />}
      />
    </>
  );
}

export default Highlights
