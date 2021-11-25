import React from 'react'
import { CardPicasso, DraftPicasso } from "./../_molecules/_index";

function Work() {
    return (
      <>
        <CardPicasso title="Work" subtitle="Last Update 2 Months Ago" content={<DraftPicasso />}/>
      </>
    );
}

export default Work
