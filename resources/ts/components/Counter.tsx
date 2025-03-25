import React, { useState } from "react";
import Button from "./Button";
const Counter = () => {
    const [count, setCount] = useState(0);

    const addCount = () => {
        setCount((count) => count + 1);
    };

    return (
        <>
            <h2>Counter</h2>
            <p>Count:{count}</p>
            <Button onClick={addCount} />
        </>
    );
};

export default Counter;
