import React from "react";
import { Link } from "@inertiajs/react";
import {
    Box,
    Button,
    Container,
    List,
    ListItem,
    ListItemButton,
    ListItemText,
    Paper,
    Typography,
} from "@mui/material";
import { VersionSummary } from "../../types";

type Props = {
    versions: VersionSummary[];
};

export default function Index({ versions }: Props) {
    return (
        <Container maxWidth="md" sx={{ py: 4 }}>
            <Typography variant="h4" component="h1" gutterBottom>
                バージョン履歴
            </Typography>
            <Paper>
                <List>
                    {versions.map((v) => (
                        <ListItem key={v.version} disablePadding>
                            <ListItemButton
                                component={Link}
                                href={route("version.show", {
                                    version: v.version,
                                })}
                            >
                                <ListItemText primary={v.version} />
                            </ListItemButton>
                        </ListItem>
                    ))}
                </List>
            </Paper>
            <Box sx={{ mt: 2 }}>
                <Button
                    component={Link}
                    href={route("version.editor.index")}
                    variant="outlined"
                >
                    編集ページ
                </Button>
            </Box>
        </Container>
    );
}
