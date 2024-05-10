import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const showNotification = (type, message) => {
    switch (type) {
        case "success":
            toast.success(message);
            break;
        case "warning":
            toast.warning(message);
            break;
        case "error":
            toast.error(message);
            break;
        default:
            toast.info(message);
            break;
    }
};

export default showNotification;
