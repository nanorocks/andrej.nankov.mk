import React from 'react'
import { CardPicasso, KeyValueListForm } from "./../_molecules/_index";

function SocMedia() {
  return (
    <>
      <CardPicasso
        title="SocMedia"
        subtitle="Last Update 2 Months Ago"
        content={<KeyValueListForm
          header="New goal"
          btnName="New goal"
          label="Add"
          addNew="Add new"
        />
        } />
    </>
  );
}

export default SocMedia
