/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.tsx",
        "./resources/**/*.ts",
        "./resources/**/*.vue",
    ],
    safelist: [
        "bg-[#262b2c]",
        "border-[#262b2c]",
        "text-[#262b2c]",
        // 他のカラークラスを追加することも可能
    ],
    theme: {
        extend: {
            boxShadow: {
                custom: "0 0px 5px 0px rgba(4,0,0,0.15)",
                card: "0px 0px 10px -3px #cbc2a6",
            },
            width: {
                "sidebar-md": "calc(100% - 200px)",
            },
            backgroundImage: {
                footer: "url(https://xvideo-jp.com/img/body-bg-tmp.gif)",
                box_bg: "url(https://xvideo-jp.com/img/box-bg.gif)",
            },
            screens: {
                xs: "360px", // オリジナル
            },
        },
    },
    variants: {},
    plugins: [],
};
