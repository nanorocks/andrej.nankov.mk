import React from 'react'
import { CardPicasso, GoalsForm } from "./../_molecules/_index";

function Goals() {
    return (
      <>
        <CardPicasso title="Goals" subtitle="Last Update 2 Months Ago" content={<GoalsForm />} />
      </>
    );
}

export default Goals
