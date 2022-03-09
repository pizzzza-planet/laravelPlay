import React, { useState } from "react";
import { MarkedInput } from "./markedInput";
import { Result } from "./result";
import EditorContext from "./EditorContext";

const MarkdownEditor = () => {
    const [markdownText, setMarkdownText] = useState("");
    const contextValue = {
        markdownText,
        setMarkdownText,
    };

    return (
        <EditorContext.Provider value={contextValue}>
            <div className="flex items-center bg-white h-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <div className="w-full h-full flex">
                    <MarkedInput />
                    <Result />
                </div>
            </div>
        </EditorContext.Provider>
    );
};

export default MarkdownEditor;
