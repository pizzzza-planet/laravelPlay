import React, { useContext } from "react";
import styled from "styled-components";
import ReactMarkdown from "react-markdown";
import editorContext from "./EditorContext";

const ResultArea = styled.div`
    width: 100%;
    height: 100%;
    border: none;
    font-size: 17px;
    padding: 0.5rem;
    word-break: break-all;
`;

export function Result(props) {
    const { markdownText } = useContext(editorContext);

    return (
        <div className="h-full p-3 w-1/2">
            <div className="m-4 p-2 border-b-2 border-solid">
                <p className="text-sm font-semibold text-gray-500">
                    Convert Text
                </p>
            </div>
            <ResultArea>
                <ReactMarkdown children={markdownText} />
            </ResultArea>
        </div>
    );
}
