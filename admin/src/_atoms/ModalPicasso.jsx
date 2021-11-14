import React, { useState } from "react";
import { ModalBody, Modal, ModalHeader } from "reactstrap";
import { ButtonPicasso } from "../_atoms/_index";

function ModalPicasso({ header, body, btnColor, btnName, btnClassName }) {
  const [modal, setModal] = useState(false);
  const [fade, setFade] = useState(true);

  const toggleState = (e) => {
    setModal(!modal);
    setFade(!fade);
  };

  return (
    <>
      <ButtonPicasso
        color={btnColor}
        name={btnName}
        className={`btn-sm mb-2 ${btnClassName}`}
        click={() => toggleState()}
      />
      <Modal
        centered
        fullscreen="md"
        size=""
        toggle={() => toggleState()}
        isOpen={modal}
        fade={fade}
        className="z-index-1"
      >
        <ModalHeader toggle={() => toggleState()}>{header}</ModalHeader>
        <ModalBody>{body}</ModalBody>
      </Modal>
    </>
  );
}

export default ModalPicasso;
