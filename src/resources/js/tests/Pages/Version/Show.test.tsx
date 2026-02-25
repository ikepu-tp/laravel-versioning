import React from "react";
import { describe, it, expect } from "vitest";
import { render, screen } from "@testing-library/react";
import "../../mocks.tsx";
import Show from "../../../Pages/Version/Show";

const fullVersion = {
    version: "1.2.3",
    releaseDate: "2024-06-01",
    createdDate: "2024-05-01",
    authors: [{ name: "Author One" }],
    url: ["https://example.com"],
    description: ["説明テキスト"],
    newFeatures: ["新機能A", "新機能B"],
    changedFeatures: ["変更機能A"],
    deletedFeatures: ["削除機能A"],
    notice: ["注意事項A"],
    security: ["セキュリティ情報"],
    futurePlans: ["今後の計画"],
    note: ["お知らせコンテンツ"],
};

describe("Version/Show", () => {
    it("バージョン詳細が表示される", () => {
        render(<Show version={fullVersion} />);
        expect(screen.getByText("バージョン 1.2.3")).toBeInTheDocument();
    });

    it("作成日・リリース日が表示される", () => {
        render(<Show version={fullVersion} />);
        expect(screen.getByText(/作成日/)).toBeInTheDocument();
        expect(screen.getByText(/リリース日/)).toBeInTheDocument();
    });

    it("執筆者が表示される", () => {
        render(<Show version={fullVersion} />);
        expect(screen.getByText("Author One")).toBeInTheDocument();
    });

    it("各セクションヘッダが表示される", () => {
        render(<Show version={fullVersion} />);
        expect(screen.getByText("説明")).toBeInTheDocument();
        expect(screen.getByText("新機能")).toBeInTheDocument();
        expect(screen.getByText("変更機能")).toBeInTheDocument();
        expect(screen.getByText("削除機能")).toBeInTheDocument();
        expect(screen.getByText("注意事項")).toBeInTheDocument();
        expect(screen.getByText("セキュリティ")).toBeInTheDocument();
        expect(screen.getByText("今後の予定")).toBeInTheDocument();
        expect(screen.getByText("お知らせ")).toBeInTheDocument();
    });

    it("空のフィールドがある場合でも表示される", () => {
        const minimalVersion = {
            version: "0.1.0",
            releaseDate: null,
            createdDate: null,
            authors: null,
            url: null,
            description: null,
            newFeatures: null,
            changedFeatures: null,
            deletedFeatures: null,
            notice: null,
            security: null,
            futurePlans: null,
            note: null,
        };
        render(<Show version={minimalVersion} />);
        expect(screen.getByText("バージョン 0.1.0")).toBeInTheDocument();
    });

    it("URLリンクが表示される", () => {
        render(<Show version={fullVersion} />);
        expect(screen.getByText("リンク")).toBeInTheDocument();
        expect(
            screen.getByRole("link", { name: "https://example.com" })
        ).toBeInTheDocument();
    });
});
