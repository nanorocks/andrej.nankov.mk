import React from "react";
import {
  RowPicasso,
  ColPicasso,
  ListGroupPicasso,
  ListGroupItemPicasso,
  InputPicasso,
  LabelPicasso,
  FormGroupPicasso,
  FormPicasso,
  ButtonPicasso
} from "./../_atoms/_index";

function GoalsForm() {
  return (
    <>
      <RowPicasso>
        <ColPicasso xs={12} sm={12} md={6} lg={6}>
          <FormPicasso>
            <FormGroupPicasso>
              <LabelPicasso text="Goal" />
              <InputPicasso />
            </FormGroupPicasso>
          </FormPicasso>
          <ButtonPicasso name="Add new" />
        </ColPicasso>
        <ColPicasso xs={12} sm={12} md={6} lg={6}>
          <ListGroupPicasso>
            <ListGroupItemPicasso text="aaaa" />
            <ListGroupItemPicasso text="aaaa" />
            <ListGroupItemPicasso text="aaaa" />
            <ListGroupItemPicasso text="aaaa" />
          </ListGroupPicasso>
        </ColPicasso>
      </RowPicasso>
    </>
  );
}

export default GoalsForm;
