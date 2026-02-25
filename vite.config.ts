import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [react()],
    build: {
        outDir: "src/resources/js/dist",
        lib: {
            entry: "src/resources/js/Pages",
            formats: ["es"],
        },
        rollupOptions: {
            external: [
                "react",
                "react-dom",
                "@inertiajs/react",
                "@mui/material",
                "@mui/icons-material",
                "zod",
            ],
        },
    },
});
