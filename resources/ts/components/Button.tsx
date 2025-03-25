import { FC, ButtonHTMLAttributes } from "react";

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {}

const Button: FC<ButtonProps> = ({}) => {
    return (
        <span className="w-full bg-red-400 text-white border-spacing-1 border-s-orange-50 p-8">
            asdfasdfa
        </span>
    );
};

export default Button;
