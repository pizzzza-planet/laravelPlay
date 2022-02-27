import React from "react";

export default function Label({ forInput, value, className, children }) {
    return (
        <label
            htmlFor={forInput}
            className={`block font-bold text-sm text-pink-100 ` + className}
        >
            {value ? value : children}
        </label>
    );
}
