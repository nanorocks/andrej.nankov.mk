function Spinner(props) {
  const size = props.size === "sm" ? "spinner-border-sm" : "";
  return (
    <div className={size !== "" ? "d-inline" : "d-flex justify-content-center"}>
      <div className={`spinner-border ${size}`} role="status">
        <span className="visually-hidden"></span>
      </div>
    </div>
  );
}

export default Spinner;
