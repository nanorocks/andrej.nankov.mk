import React from 'react'
import { CardPicasso, BaseForm } from "./../_molecules/_index";

function Base() {
    return (
      <>
        <CardPicasso title="Base" subtitle="Last Update 2 Months Ago" content={<BaseForm />} />
      </>
    );
}

export default Base
