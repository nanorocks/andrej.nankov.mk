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

function ListForm({ header, btnName, label, addNew }) {
  return (
    <>
      <RowPicasso>
        <ColPicasso xs={12} sm={12} md={12} lg={12}>
          <ModalPicasso
            header={header}
            btnName={btnName}
            body={
              <>
                <FormPicasso>
                  <FormGroupPicasso>
                    <LabelPicasso text={label} />
                    <InputPicasso />
                  </FormGroupPicasso>
                </FormPicasso>
                <ButtonPicasso name={addNew}/>
              </>
            }
          />
        </ColPicasso>
        <ColPicasso xs={12} sm={12} md={12} lg={12}>
          <ListGroupPicasso>
            <ListGroupItemPicasso
              content={
                <div className="d-flex justify-content-between">
                  <div className="">aaaa</div>
                  <div>
                    <ModalPicasso
                      header="Edit Goal"
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

export default ListForm;
