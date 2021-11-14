import React, { useState } from "react";
import { EditorState } from "draft-js";
import { Editor } from "react-draft-wysiwyg";

function DraftPicasso() {
  const [editorState, setEditorState] = useState(EditorState.createEmpty());

  const onEditorStateChange = (editorState) => {
    setEditorState({
      editorState,
    });
  }

  const handleKeyCommand = () => {

  }

  return (
    <div>
      <Editor
        editorState={editorState}
        handleKeyCommand={handleKeyCommand}
        onEditorStateChange={onEditorStateChange}
      />
    </div>
  );
}

export default DraftPicasso;
