import React from "react";
import { Link, useForm } from "@inertiajs/react";
import {
    Box,
    Button,
    Container,
    FormControl,
    FormControlLabel,
    FormLabel,
    IconButton,
    Paper,
    Radio,
    RadioGroup,
    TextField,
    Typography,
} from "@mui/material";
import AddIcon from "@mui/icons-material/Add";
import DeleteIcon from "@mui/icons-material/Delete";
import { z } from "zod";
import { Author, Version } from "../../types";

const AuthorSchema = z.object({
    name: z.string().optional(),
    homepage: z.string().url().optional().or(z.literal("")),
    email: z.string().email().optional().or(z.literal("")),
});

const VersionFormSchema = z.object({
    version_type: z.enum(["major", "minor", "patch"]).optional(),
    createdDate: z.string().min(1, "作成日は必須です"),
    releaseDate: z.string().min(1, "リリース日は必須です"),
    authors: z.array(AuthorSchema).optional(),
    url: z.array(z.string()).optional(),
    description: z.array(z.string()).optional(),
    newFeatures: z.array(z.string()).optional(),
    changedFeatures: z.array(z.string()).optional(),
    deletedFeatures: z.array(z.string()).optional(),
    notice: z.array(z.string()).optional(),
    security: z.array(z.string()).optional(),
    futurePlans: z.array(z.string()).optional(),
    note: z.array(z.string()).optional(),
});

type FormData = {
    version_type: "major" | "minor" | "patch";
    createdDate: string;
    releaseDate: string;
    authors: Author[];
    url: string[];
    description: string[];
    newFeatures: string[];
    changedFeatures: string[];
    deletedFeatures: string[];
    notice: string[];
    security: string[];
    futurePlans: string[];
    note: string[];
    [key: string]: unknown;
};

type Props = {
    version?: Version;
};

const today = new Date().toISOString().split("T")[0];

export default function Edit({ version }: Props) {
    const isNew = !version;
    const { data, setData, post, put, processing, errors } = useForm<FormData>({
        version_type: "patch",
        createdDate: version?.createdDate ?? today,
        releaseDate: version?.releaseDate ?? today,
        authors: version?.authors ?? [],
        url: version?.url ?? [],
        description: version?.description ?? [],
        newFeatures: version?.newFeatures ?? [],
        changedFeatures: version?.changedFeatures ?? [],
        deletedFeatures: version?.deletedFeatures ?? [],
        notice: version?.notice ?? [],
        security: version?.security ?? [],
        futurePlans: version?.futurePlans ?? [],
        note: version?.note ?? [],
    });

    const [zodErrors, setZodErrors] = React.useState<
        Partial<Record<string, string>>
    >({});

    function validate(): boolean {
        const result = VersionFormSchema.safeParse(data);
        if (!result.success) {
            const errs: Partial<Record<string, string>> = {};
            result.error.issues.forEach((issue) => {
                errs[issue.path.join(".")] = issue.message;
            });
            setZodErrors(errs);
            return false;
        }
        setZodErrors({});
        return true;
    }

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        if (!validate()) return;
        if (isNew) {
            post(route("version.editor.store"));
        } else {
            put(route("version.editor.update", { editor: version!.version }));
        }
    }

    function addItem(field: keyof FormData) {
        const current = data[field] as string[];
        setData(field, [...current, ""]);
    }

    function updateItem(field: keyof FormData, index: number, value: string) {
        const current = [...(data[field] as string[])];
        current[index] = value;
        setData(field, current);
    }

    function removeItem(field: keyof FormData, index: number) {
        const current = [...(data[field] as string[])];
        current.splice(index, 1);
        setData(field, current);
    }

    function addAuthor() {
        setData("authors", [
            ...data.authors,
            { name: "", homepage: "", email: "" },
        ]);
    }

    function updateAuthor(index: number, field: keyof Author, value: string) {
        const authors = [...data.authors];
        authors[index] = { ...authors[index], [field]: value };
        setData("authors", authors);
    }

    function removeAuthor(index: number) {
        const authors = [...data.authors];
        authors.splice(index, 1);
        setData("authors", authors);
    }

    const textFields: Array<{ key: keyof FormData; label: string }> = [
        { key: "description", label: "説明" },
        { key: "newFeatures", label: "新機能" },
        { key: "changedFeatures", label: "変更機能" },
        { key: "deletedFeatures", label: "削除機能" },
        { key: "notice", label: "注意事項" },
        { key: "security", label: "セキュリティ" },
        { key: "futurePlans", label: "今後の予定" },
        { key: "note", label: "お知らせ" },
    ];

    return (
        <Container maxWidth="md" sx={{ py: 4 }}>
            <Typography variant="h4" component="h1" gutterBottom>
                {isNew ? "新規追加" : version!.version}
            </Typography>
            <Button
                component={Link}
                href={route("version.editor.index")}
                variant="text"
                sx={{ mb: 2 }}
            >
                戻る
            </Button>

            <Paper sx={{ p: 3 }}>
                <Box component="form" onSubmit={handleSubmit} noValidate>
                    {isNew && (
                        <FormControl component="fieldset" sx={{ mb: 3 }}>
                            <FormLabel component="legend">
                                バージョンタイプ
                            </FormLabel>
                            <RadioGroup
                                row
                                name="version_type"
                                value={data.version_type}
                                onChange={(e) =>
                                    setData(
                                        "version_type",
                                        e.target.value as
                                            | "major"
                                            | "minor"
                                            | "patch"
                                    )
                                }
                            >
                                <FormControlLabel
                                    value="major"
                                    control={<Radio />}
                                    label="メジャー"
                                />
                                <FormControlLabel
                                    value="minor"
                                    control={<Radio />}
                                    label="マイナー"
                                />
                                <FormControlLabel
                                    value="patch"
                                    control={<Radio />}
                                    label="パッチ"
                                />
                            </RadioGroup>
                        </FormControl>
                    )}

                    <Box
                        sx={{
                            display: "flex",
                            gap: 2,
                            mb: 3,
                            flexWrap: "wrap",
                        }}
                    >
                        <TextField
                            label="作成日"
                            type="date"
                            name="createdDate"
                            value={data.createdDate}
                            onChange={(e) =>
                                setData("createdDate", e.target.value)
                            }
                            required
                            InputLabelProps={{ shrink: true }}
                            error={
                                !!(errors.createdDate || zodErrors.createdDate)
                            }
                            helperText={
                                errors.createdDate || zodErrors.createdDate
                            }
                        />
                        <TextField
                            label="リリース日"
                            type="date"
                            name="releaseDate"
                            value={data.releaseDate}
                            onChange={(e) =>
                                setData("releaseDate", e.target.value)
                            }
                            required
                            InputLabelProps={{ shrink: true }}
                            error={
                                !!(errors.releaseDate || zodErrors.releaseDate)
                            }
                            helperText={
                                errors.releaseDate || zodErrors.releaseDate
                            }
                        />
                    </Box>

                    {/* Authors */}
                    <Box sx={{ mb: 3 }}>
                        <Box
                            sx={{
                                display: "flex",
                                alignItems: "center",
                                mb: 1,
                            }}
                        >
                            <Typography variant="h6" sx={{ flexGrow: 1 }}>
                                執筆者
                            </Typography>
                            <Button
                                startIcon={<AddIcon />}
                                onClick={addAuthor}
                                variant="outlined"
                                size="small"
                            >
                                追加
                            </Button>
                        </Box>
                        {data.authors.map((author, i) => (
                            <Paper
                                key={i}
                                variant="outlined"
                                sx={{ p: 2, mb: 1 }}
                            >
                                <Box
                                    sx={{
                                        display: "flex",
                                        gap: 1,
                                        flexWrap: "wrap",
                                        alignItems: "flex-start",
                                    }}
                                >
                                    <TextField
                                        label="名前"
                                        value={author.name ?? ""}
                                        onChange={(e) =>
                                            updateAuthor(
                                                i,
                                                "name",
                                                e.target.value
                                            )
                                        }
                                        size="small"
                                    />
                                    <TextField
                                        label="ホームページ"
                                        value={author.homepage ?? ""}
                                        onChange={(e) =>
                                            updateAuthor(
                                                i,
                                                "homepage",
                                                e.target.value
                                            )
                                        }
                                        size="small"
                                    />
                                    <TextField
                                        label="メール"
                                        type="email"
                                        value={author.email ?? ""}
                                        onChange={(e) =>
                                            updateAuthor(
                                                i,
                                                "email",
                                                e.target.value
                                            )
                                        }
                                        size="small"
                                    />
                                    <IconButton
                                        onClick={() => removeAuthor(i)}
                                        color="error"
                                        size="small"
                                        aria-label="執筆者を削除"
                                    >
                                        <DeleteIcon />
                                    </IconButton>
                                </Box>
                            </Paper>
                        ))}
                    </Box>

                    {/* URL */}
                    <Box sx={{ mb: 3 }}>
                        <Box
                            sx={{
                                display: "flex",
                                alignItems: "center",
                                mb: 1,
                            }}
                        >
                            <Typography variant="h6" sx={{ flexGrow: 1 }}>
                                リンク
                            </Typography>
                            <Button
                                startIcon={<AddIcon />}
                                onClick={() => addItem("url")}
                                variant="outlined"
                                size="small"
                            >
                                追加
                            </Button>
                        </Box>
                        {data.url.map((u, i) => (
                            <Box
                                key={i}
                                sx={{
                                    display: "flex",
                                    gap: 1,
                                    mb: 1,
                                    alignItems: "center",
                                }}
                            >
                                <TextField
                                    fullWidth
                                    type="url"
                                    value={u}
                                    onChange={(e) =>
                                        updateItem("url", i, e.target.value)
                                    }
                                    size="small"
                                    label="URL"
                                />
                                <IconButton
                                    onClick={() => removeItem("url", i)}
                                    color="error"
                                    size="small"
                                    aria-label="URLを削除"
                                >
                                    <DeleteIcon />
                                </IconButton>
                            </Box>
                        ))}
                    </Box>

                    {/* Text fields */}
                    {textFields.map(({ key, label }) => (
                        <Box key={key} sx={{ mb: 3 }}>
                            <Box
                                sx={{
                                    display: "flex",
                                    alignItems: "center",
                                    mb: 1,
                                }}
                            >
                                <Typography
                                    variant="h6"
                                    sx={{ flexGrow: 1 }}
                                >
                                    {label}
                                </Typography>
                                <Button
                                    startIcon={<AddIcon />}
                                    onClick={() => addItem(key)}
                                    variant="outlined"
                                    size="small"
                                >
                                    追加
                                </Button>
                            </Box>
                            {(data[key] as string[]).map((item, i) => (
                                <Box
                                    key={i}
                                    sx={{
                                        display: "flex",
                                        gap: 1,
                                        mb: 1,
                                        alignItems: "flex-start",
                                    }}
                                >
                                    <TextField
                                        fullWidth
                                        multiline
                                        minRows={2}
                                        value={item}
                                        onChange={(e) =>
                                            updateItem(key, i, e.target.value)
                                        }
                                        size="small"
                                        label={label}
                                    />
                                    <IconButton
                                        onClick={() => removeItem(key, i)}
                                        color="error"
                                        size="small"
                                        aria-label={`${label}を削除`}
                                    >
                                        <DeleteIcon />
                                    </IconButton>
                                </Box>
                            ))}
                        </Box>
                    ))}

                    <Button
                        type="submit"
                        variant="contained"
                        color="primary"
                        disabled={processing}
                    >
                        登録
                    </Button>
                </Box>
            </Paper>
        </Container>
    );
}
