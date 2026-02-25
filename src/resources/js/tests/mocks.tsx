import React from "react";
import { vi } from "vitest";

// Mock @inertiajs/react
vi.mock("@inertiajs/react", () => ({
    Link: ({
        href,
        children,
        ...rest
    }: {
        href: string;
        children: React.ReactNode;
        [key: string]: unknown;
    }) => <a href={href}>{children}</a>,
    useForm: vi.fn(() => ({
        data: {
            version_type: "patch",
            createdDate: "2024-01-01",
            releaseDate: "2024-01-01",
            authors: [],
            url: [],
            description: [],
            newFeatures: [],
            changedFeatures: [],
            deletedFeatures: [],
            notice: [],
            security: [],
            futurePlans: [],
            note: [],
        },
        setData: vi.fn(),
        post: vi.fn(),
        put: vi.fn(),
        processing: false,
        errors: {},
    })),
}));

// Mock route function (Ziggy)
(
    globalThis as typeof globalThis & {
        route: (
            name: string,
            params?: Record<string, string>
        ) => string;
    }
).route = (name: string, params?: Record<string, string>) => {
    const paramStr = params ? "/" + Object.values(params).join("/") : "";
    return `/${name}${paramStr}`;
};
