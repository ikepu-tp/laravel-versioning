import React from "react";
import { describe, it, expect } from "vitest";
import { render, screen } from "@testing-library/react";
import "../../mocks.tsx";
import Index from "../../../Pages/Editor/Index";

const mockVersions = [
    { version: "1.0.0" },
    { version: "1.1.0" },
    { version: "2.0.0" },
];

describe("Editor/Index", () => {
    it("バージョン一覧が表示される", () => {
        render(<Index versions={mockVersions} />);
        expect(screen.getByText("バージョン一覧（編集）")).toBeInTheDocument();
        expect(screen.getByText("1.0.0")).toBeInTheDocument();
        expect(screen.getByText("1.1.0")).toBeInTheDocument();
        expect(screen.getByText("2.0.0")).toBeInTheDocument();
    });

    it("バージョンが空の場合でも表示される", () => {
        render(<Index versions={[]} />);
        expect(screen.getByText("バージョン一覧（編集）")).toBeInTheDocument();
    });

    it("各バージョンに編集ボタンが表示される", () => {
        render(<Index versions={mockVersions} />);
        const editButtons = screen.getAllByText("編集");
        expect(editButtons).toHaveLength(3);
    });

    it("各バージョンに詳細ボタンが表示される", () => {
        render(<Index versions={mockVersions} />);
        const detailButtons = screen.getAllByText("詳細");
        expect(detailButtons).toHaveLength(3);
    });

    it("新規追加ボタンが表示される", () => {
        render(<Index versions={mockVersions} />);
        expect(screen.getByText("新規追加")).toBeInTheDocument();
    });

    it("バージョン履歴リンクが表示される", () => {
        render(<Index versions={mockVersions} />);
        expect(screen.getByText("バージョン履歴")).toBeInTheDocument();
    });
});
