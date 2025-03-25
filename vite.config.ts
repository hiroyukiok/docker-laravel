import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react-refresh";

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/scss/app.scss",
                "resources/ts/index.tsx",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: "./public/build", // ビルド成果物の生成先
        emptyOutDir: false, // 出力ディレクトリを空にしない
        rollupOptions: {
            output: {
                // entry chunk assets それぞれの書き出し名の指定
                // entryFileNames: `assets/[name].js`,
                // chunkFileNames: `assets/[name].js`,
                // assetFileNames: `assets/[name].[ext]`,
                // ファイル名にハッシュを追加
                entryFileNames: `assets/[name].[hash].js`,
                chunkFileNames: `assets/[name].[hash].js`,
                assetFileNames: `assets/[name].[hash].[ext]`,
            },
        },
        cssCodeSplit: true,
    },
    server: {
        host: true,
        hmr: {
            host: "localhost",
        },
        watch: {
            usePolling: true,
        },
    },
});
