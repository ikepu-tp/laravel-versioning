import React from "react";
import { describe, it, expect } from "vitest";
import { render, screen } from "@testing-library/react";
import "../../mocks.tsx";
import Index from "../../../Pages/Version/Index";

const mockVersions = [
    { version: "1.0.0" },
    { version: "1.1.0" },
    { version: "2.0.0" },
];

describe("Version/Index", () => {
    it("バージョン一覧が表示される", () => {
        render(<Index versions={mockVersions} />);
        expect(screen.getByText("バージョン履歴")).toBeInTheDocument();
        expect(screen.getByText("1.0.0")).toBeInTheDocument();
        expect(screen.getByText("1.1.0")).toBeInTheDocument();
        expect(screen.getByText("2.0.0")).toBeInTheDocument();
    });

    it("バージョンが空の場合でも表示される", () => {
        render(<Index versions={[]} />);
        expect(screen.getByText("バージョン履歴")).toBeInTheDocument();
    });

    it("各バージョンがリンクになっている", () => {
        render(<Index versions={mockVersions} />);
        const links = screen.getAllByRole("link");
        expect(links.length).toBeGreaterThanOrEqual(3);
    });
});
