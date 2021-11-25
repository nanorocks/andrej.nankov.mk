import React from 'react'
import { CardPicasso, DraftPicasso } from "./../_molecules/_index";

function Summary() {
    return (
      <>
        <CardPicasso title="Summary" subtitle="Last Update 2 Months Ago" content={<DraftPicasso />}/>
      </>
    );
}

export default Summary
