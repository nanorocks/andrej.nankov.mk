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
  ButtonPicasso,
  ModalPicasso,
} from "../_atoms/_index";

import { GoPencil, GoTrashcan } from "react-icons/go";

function KeyValueListForm({ header, btnName, label, addNew }) {
  return (
    <>
      <RowPicasso>
        <ColPicasso xs={12} sm={12} md={12} lg={12}>
          <ModalPicasso
            header={header}
            btnName={btnName}
            btnColor="dark"
            body={
              <>
                <FormPicasso>
                  <FormGroupPicasso>
                    <LabelPicasso text="Date" />
                    <InputPicasso type="date" />
                  </FormGroupPicasso>
                  <FormGroupPicasso>
                    <LabelPicasso text="Key" />
                    <InputPicasso />
                  </FormGroupPicasso>
                  <FormGroupPicasso>
                    <LabelPicasso text="Value" />
                    <InputPicasso />
                  </FormGroupPicasso>
                </FormPicasso>
                <ButtonPicasso name={addNew} />
              </>
            }
          />
        </ColPicasso>
        <ColPicasso xs={12} sm={12} md={12} lg={12}>
          <ListGroupPicasso>
            <ListGroupItemPicasso
              content={
                <div className="d-flex justify-content-between">
                  <div className="">2020 | aaaa | aaaaa</div>
                  <div>
                    <ModalPicasso
                      header={`Edit ${header}`}
                      btnName={<GoPencil />}
                      btnClassName="border-0 bg-secondary-custom border-0"
                    />
                    <ButtonPicasso
                      name={<GoTrashcan />}
                      className="btn-sm mb-2 ms-2 bg-primary-custom border-0"
                    />
                  </div>
                </div>
              }
            />
          </ListGroupPicasso>
        </ColPicasso>
      </RowPicasso>
    </>
  );
}

export default KeyValueListForm;
