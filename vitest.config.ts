import { defineConfig } from "vitest/config";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [react()],
    test: {
        globals: true,
        environment: "jsdom",
        setupFiles: ["src/resources/js/tests/setup.ts"],
        include: ["src/resources/js/tests/**/*.test.{ts,tsx}"],
    },
});
