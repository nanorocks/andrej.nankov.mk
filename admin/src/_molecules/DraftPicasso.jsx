import React, { useMemo, useState } from 'react'
import { createEditor } from 'slate'
import { Slate, Editable, withReact } from 'slate-react'
import { ButtonPicasso } from '../_atoms/_index'

function DraftPicasso() {

  const editor = useMemo(() => withReact(createEditor()), [])
  const [value, setValue] = useState([
    {
      type: 'html',
      children: [{ text: '' }],
    },
  ])
  // Render the Slate context.
  return (
    <>
      <Slate
        editor={editor}
        value={value}
        onChange={newValue => setValue(newValue)}
      >
        <div className="shadow-sm border-bottom p-2">
          <Editable placeholder="White something ..." />
        </div>
      </Slate>
      <ButtonPicasso name="Save" className="mt-2" color="success"/>
    </>
  )
}

export default DraftPicasso;
