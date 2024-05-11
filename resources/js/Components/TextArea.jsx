import { forwardRef, useRef } from "react";

export default forwardRef(function TextArea({ className = "", ...props }, ref) {
    const textareaRef = ref ? ref : useRef();

    return (
        <textarea
            {...props}
            style={{ border: "1.5px solid rgb(209 213 219)" }}
            className={
                "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm " +
                className
            }
            ref={textareaRef}
        />
    );
});
