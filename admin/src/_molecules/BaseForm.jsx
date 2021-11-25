import React from "react";

import {
  FormPicasso,
  FormGroupPicasso,
  LabelPicasso,
  InputPicasso,
  ButtonPicasso,
  RowPicasso,
  ColPicasso,
} from "./../_atoms/_index";

function BaseForm() {
  return (
    <>
      <FormPicasso>
        <RowPicasso>
          <ColPicasso xs={12} sm={12} md={6} lg={6}>
            <FormGroupPicasso>
              <LabelPicasso text="Email" />
              <InputPicasso />
            </FormGroupPicasso>
          </ColPicasso>
          <ColPicasso xs={12} sm={12} md={6} lg={6}>
            <FormGroupPicasso>
              <LabelPicasso text="Name" />
              <InputPicasso />
            </FormGroupPicasso>
          </ColPicasso>
        </RowPicasso>
        <RowPicasso>
          <ColPicasso xs={12} sm={12} md={6} lg={6}>
            <FormGroupPicasso>
              <LabelPicasso text="Address" />
              <InputPicasso />
            </FormGroupPicasso>
          </ColPicasso>
          <ColPicasso xs={12} sm={12} md={6} lg={6}>
            <FormGroupPicasso>
              <LabelPicasso text="Phone" />
              <InputPicasso />
            </FormGroupPicasso>
          </ColPicasso>
        </RowPicasso>
        <RowPicasso>
          <ColPicasso xs={6} sm={6} md={6} lg={6}>
            <FormGroupPicasso>
              <LabelPicasso text="Photo" />
              <InputPicasso />
            </FormGroupPicasso>
          </ColPicasso>
        </RowPicasso>
        <ButtonPicasso name="Save" color="danger"/>
      </FormPicasso>
    </>
  );
}

export default BaseForm;
