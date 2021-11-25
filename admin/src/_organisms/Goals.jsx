import React from 'react'
import { CardPicasso, ListForm } from "./../_molecules/_index";

function Goals() {
  return (
    <>
      <CardPicasso
        title="Goals"
        subtitle="Last Update 2 Months Ago"
        content={<ListForm
          header="New goal"
          btnName="New goal"
          label="Add"
          addNew="Add new"
        />}
      />
    </>
  );
}

export default Goals
