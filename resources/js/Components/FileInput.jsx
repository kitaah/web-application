import { forwardRef, useRef } from 'react';

export default forwardRef(function FileInput({ className = '', ...props }, ref) {
    const inputRef = ref ? ref : useRef();

    return (
        <input
            {...props}
            className={
                'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' +
                className
            }
            ref={inputRef}
        />
    );
});
