import React from "react";

function ErrorsHandler(props) {
  return (
    <React.Fragment>
      {props.errors.length !== 0 && (
        <div className="alert alert-danger mt-3 rounded-0 border-left" role="alert">
          <ul className="list-unstyled mb-0">
            {Object.values(props.errors).map((error, index) => (
              <li key={index}>{error[0]}</li>
            ))}
          </ul>
        </div>
      )}
    </React.Fragment>
  );
}

export default ErrorsHandler;
