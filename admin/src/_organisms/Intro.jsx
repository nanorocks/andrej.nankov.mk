import React from 'react'
import { CardPicasso, DraftPicasso } from "./../_molecules/_index";

function Intro() {
    return (
      <>
        <CardPicasso title="Intro" subtitle="Last Update 2 Months Ago" content={<DraftPicasso />}/>
      </>
    );
}

export default Intro
