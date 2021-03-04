import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.min.css";
import { FaInfo } from "react-icons/fa";
import { AiFillStop, AiFillLike, AiFillFire } from "react-icons/ai";

function Alert(type, message) {
  toast.configure({
    position: "top-center",
    autoClose: 1500,
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
          <AiFillStop />
          {message}
        </div>
      );
    case "error":
      return toast.error(
        <div className="d-flex">
          <AiFillFire />
          {message}
        </div>
      );
    case "success":
      return toast.success(
        <div className="d-flex">
          <AiFillLike />
          {message}
        </div>
      );
    case "info":
      return toast.info(
        <div className="d-flex">
          <FaInfo />
          {message}
        </div>
      );
    case "dark":
      return toast.dark(<div> {message}</div>);
    default:
      return toast(message);
  }
}

export default Alert;
