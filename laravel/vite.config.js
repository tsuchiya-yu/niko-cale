import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";
import path from "path";

// 指定されたディレクトリ内のすべてのファイルを再帰的に取得
function getFilesRecursively(directory) {
    const filesInDirectory = fs.readdirSync(directory);
    const files = [];

    for (const file of filesInDirectory) {
        const absolute = path.join(directory, file);
        if (fs.statSync(absolute).isDirectory()) {
            files.push(...getFilesRecursively(absolute));
        } else {
            files.push(absolute);
        }
    }
    return files;
}

// resources/css と resources/js ディレクトリ内のすべてのファイルを取得
const cssFiles = getFilesRecursively(path.resolve(__dirname, 'resources/css'))
    .filter(file => file.endsWith('.css'));
const jsFiles = getFilesRecursively(path.resolve(__dirname, 'resources/js'))
    .filter(file => file.endsWith('.js'));

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                ...jsFiles,
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        emptyOutDir: true,
    },
    base: 'https://nikocale.fly.dev/',
});
