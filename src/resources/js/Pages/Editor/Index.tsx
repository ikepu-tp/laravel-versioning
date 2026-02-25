import React from "react";
import { Link } from "@inertiajs/react";
import {
    Box,
    Button,
    Container,
    Paper,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
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
                バージョン一覧（編集）
            </Typography>
            <TableContainer component={Paper}>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell>バージョン</TableCell>
                            <TableCell align="right">操作</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {versions.map((v) => (
                            <TableRow key={v.version}>
                                <TableCell>{v.version}</TableCell>
                                <TableCell align="right">
                                    <Box
                                        sx={{
                                            display: "flex",
                                            gap: 1,
                                            justifyContent: "flex-end",
                                        }}
                                    >
                                        <Button
                                            component={Link}
                                            href={route(
                                                "version.editor.show",
                                                { editor: v.version }
                                            )}
                                            variant="outlined"
                                            size="small"
                                        >
                                            詳細
                                        </Button>
                                        <Button
                                            component={Link}
                                            href={route(
                                                "version.editor.edit",
                                                { editor: v.version }
                                            )}
                                            variant="contained"
                                            size="small"
                                        >
                                            編集
                                        </Button>
                                    </Box>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
            <Box
                sx={{
                    mt: 2,
                    display: "flex",
                    justifyContent: "space-between",
                }}
            >
                <Button
                    component={Link}
                    href={route("version.index")}
                    variant="text"
                >
                    バージョン履歴
                </Button>
                <Button
                    component={Link}
                    href={route("version.editor.create")}
                    variant="contained"
                    color="success"
                >
                    新規追加
                </Button>
            </Box>
        </Container>
    );
}
