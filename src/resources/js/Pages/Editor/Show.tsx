import React from "react";
import { Link } from "@inertiajs/react";
import {
    Box,
    Button,
    Chip,
    Container,
    Divider,
    List,
    ListItem,
    ListItemText,
    Paper,
    Typography,
} from "@mui/material";
import { Version } from "../../types";

type Props = {
    version: Version;
};

function SectionList({
    title,
    items,
}: {
    title: string;
    items: string[] | null;
}) {
    if (!items || items.length === 0) return null;
    return (
        <Box sx={{ mb: 2 }}>
            <Typography variant="h6" gutterBottom>
                {title}
            </Typography>
            <List dense>
                {items.map((item, i) => (
                    <ListItem key={i}>
                        <ListItemText primary={item} />
                    </ListItem>
                ))}
            </List>
        </Box>
    );
}

export default function Show({ version }: Props) {
    return (
        <Container maxWidth="md" sx={{ py: 4 }}>
            <Typography variant="h4" component="h1" gutterBottom>
                バージョン {version.version}
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
                <Box sx={{ mb: 2 }}>
                    {version.createdDate && (
                        <Typography variant="body2" color="text.secondary">
                            作成日: {version.createdDate}
                        </Typography>
                    )}
                    {version.releaseDate && (
                        <Typography variant="body2" color="text.secondary">
                            リリース日: {version.releaseDate}
                        </Typography>
                    )}
                </Box>

                {version.authors && version.authors.length > 0 && (
                    <Box sx={{ mb: 2 }}>
                        <Typography variant="h6" gutterBottom>
                            執筆者
                        </Typography>
                        <Box
                            sx={{ display: "flex", flexWrap: "wrap", gap: 1 }}
                        >
                            {version.authors.map((author, i) => (
                                <Chip
                                    key={i}
                                    label={
                                        typeof author === "string"
                                            ? author
                                            : author.name ?? ""
                                    }
                                    variant="outlined"
                                />
                            ))}
                        </Box>
                    </Box>
                )}

                {version.url && version.url.length > 0 && (
                    <Box sx={{ mb: 2 }}>
                        <Typography variant="h6" gutterBottom>
                            リンク
                        </Typography>
                        <List dense>
                            {version.url.map((u, i) => (
                                <ListItem key={i}>
                                    <ListItemText
                                        primary={
                                            <a
                                                href={u}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                {u}
                                            </a>
                                        }
                                    />
                                </ListItem>
                            ))}
                        </List>
                    </Box>
                )}

                <Divider sx={{ my: 2 }} />

                <SectionList title="説明" items={version.description} />
                <SectionList title="新機能" items={version.newFeatures} />
                <SectionList
                    title="変更機能"
                    items={version.changedFeatures}
                />
                <SectionList
                    title="削除機能"
                    items={version.deletedFeatures}
                />
                <SectionList title="注意事項" items={version.notice} />
                <SectionList title="セキュリティ" items={version.security} />
                <SectionList title="今後の予定" items={version.futurePlans} />
                <SectionList title="お知らせ" items={version.note} />
            </Paper>
        </Container>
    );
}
