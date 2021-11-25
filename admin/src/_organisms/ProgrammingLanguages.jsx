import React from 'react'
import { CardPicasso, ListForm } from "./../_molecules/_index";

function ProgrammingLanguages() {
  return (
    <>
      <CardPicasso
        title="ProgrammingLanguages"
        subtitle="Last Update 2 Months Ago"
        content={
          <ListForm
            header="New language"
            btnName="New"
            label="Add"
            addNew="Add new"
          />} 
        />
    </>
  );
}

export default ProgrammingLanguages
