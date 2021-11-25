import React from 'react'
import { CardPicasso, ListForm } from "./../_molecules/_index";

function Quotes() {
  return (
    <>
      <CardPicasso
        title="Quotes"
        subtitle="Last Update 2 Months Ago"
        content={
        <ListForm
          header="New quote"
          btnName="New quote"
          label="Add"
          addNew="Add new"
        />} />
    </>
  );
}

export default Quotes
