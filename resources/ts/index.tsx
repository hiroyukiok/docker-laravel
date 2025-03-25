import "../js/bootstrap.js";
import "../css/app.css";
import React from "react";
// import ReactDOM from "react-dom/client";
import Counter from "./components/Counter";
import { createRoot } from "react-dom/client";

const App = () => {
    const title: string = "This is React × Laravel App";

    return (
        <>
            <h1 className="bg-blue-300 text-orange-700 w-full">{title}</h1>
            <Counter />
        </>
    );
};
const container = document.getElementById("app") as HTMLInputElement;
const root = createRoot(container);
root.render(<App />);
