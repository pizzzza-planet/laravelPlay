import React, { useContext } from "react";
import styled from "styled-components";
import editorContext from "./EditorContext";

const TextArea = styled.textarea`
    width: 100%;
    height: 100%;
    resize: none;
    border: none;
    outline: none;
    font-size: 17px;
`;

export function MarkedInput(props) {
    const { setMarkdownText } = useContext(editorContext);

    const onInputChange = (e) => {
        const newValue = e.currentTarget.value;
        setMarkdownText(newValue);
    };

    return (
        <div className="h-full p-3 w-1/2">
            <div className="m-4 p-2 border-b-2 border-solid">
                <p className="text-sm font-semibold text-gray-500">
                    Markdown Text
                </p>
            </div>
            <TextArea rows={20} onChange={onInputChange} />
        </div>
    );
}
