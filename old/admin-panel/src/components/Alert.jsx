import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.min.css";
import { ImFrustrated, ImSad, ImGrin, ImBaffled } from "react-icons/im";

function Alert(type, message) {
  toast.configure({
    position: "top-center",
    autoClose: 2000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
    progress: undefined,
  });

  switch (type) {
    case "warning":
      return toast.warning(
        <div className="d-flex">
          <strong>
            <ImFrustrated />
          </strong>
          <div className="pl-2">{message}</div>
        </div>
      );
    case "error":
      return toast.error(
        <div className="d-flex">
          <strong>
            <ImSad />
          </strong>
          <div className="pl-2">{message}</div>
        </div>
      );
    case "success":
      return toast.success(
        <div className="d-flex">
          <strong>
            <ImGrin />
          </strong>
          <div className="pl-2">{message}</div>
        </div>
      );
    case "info":
      return toast.info(
        <div className="d-flex">
          <strong>
            <ImBaffled />
          </strong>
          <div className="pl-2">{message}</div>
        </div>
      );
    case "dark":
      return toast.dark(<div>{message}</div>);
    default:
      return toast(message);
  }
}

export default Alert;
