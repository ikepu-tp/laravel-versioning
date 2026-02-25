import React from "react";
import { describe, it, expect } from "vitest";
import { render, screen } from "@testing-library/react";
import "../../mocks.tsx";
import Edit from "../../../Pages/Editor/Edit";

describe("Editor/Edit - 新規作成", () => {
    it("新規追加フォームが表示される", () => {
        render(<Edit />);
        expect(screen.getByText("新規追加")).toBeInTheDocument();
    });

    it("バージョンタイプの選択肢が表示される（新規時）", () => {
        render(<Edit />);
        expect(screen.getByText("メジャー")).toBeInTheDocument();
        expect(screen.getByText("マイナー")).toBeInTheDocument();
        expect(screen.getByText("パッチ")).toBeInTheDocument();
    });

    it("作成日・リリース日の入力欄が表示される", () => {
        render(<Edit />);
        expect(screen.getByLabelText(/作成日/)).toBeInTheDocument();
        expect(screen.getByLabelText(/リリース日/)).toBeInTheDocument();
    });

    it("登録ボタンが表示される", () => {
        render(<Edit />);
        expect(
            screen.getByRole("button", { name: "登録" })
        ).toBeInTheDocument();
    });

    it("戻るリンクが表示される", () => {
        render(<Edit />);
        expect(screen.getByText("戻る")).toBeInTheDocument();
    });
});

describe("Editor/Edit - 既存バージョン編集", () => {
    const existingVersion = {
        version: "1.2.3",
        releaseDate: "2024-06-01",
        createdDate: "2024-05-01",
        authors: [{ name: "test author", homepage: "", email: "" }],
        url: ["https://example.com"],
        description: ["テスト説明"],
        newFeatures: ["新機能1"],
        changedFeatures: [],
        deletedFeatures: [],
        notice: [],
        security: [],
        futurePlans: [],
        note: [],
    };

    it("編集フォームにバージョンが表示される", () => {
        render(<Edit version={existingVersion} />);
        expect(screen.getByText("1.2.3")).toBeInTheDocument();
    });

    it("既存バージョン編集時にバージョンタイプ選択肢が表示されない", () => {
        render(<Edit version={existingVersion} />);
        expect(screen.queryByText("メジャー")).toBeNull();
        expect(screen.queryByText("マイナー")).toBeNull();
        expect(screen.queryByText("パッチ")).toBeNull();
    });

    it("作成日・リリース日の入力欄が表示される", () => {
        render(<Edit version={existingVersion} />);
        expect(screen.getByLabelText(/作成日/)).toBeInTheDocument();
        expect(screen.getByLabelText(/リリース日/)).toBeInTheDocument();
    });

    it("登録ボタンが表示される", () => {
        render(<Edit version={existingVersion} />);
        expect(
            screen.getByRole("button", { name: "登録" })
        ).toBeInTheDocument();
    });
});
