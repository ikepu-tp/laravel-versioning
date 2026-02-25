export type Author = {
    name?: string;
    homepage?: string;
    email?: string;
};

export type Version = {
    version: string;
    releaseDate: string | null;
    createdDate: string | null;
    authors: Author[] | null;
    url: string[] | null;
    description: string[] | null;
    newFeatures: string[] | null;
    changedFeatures: string[] | null;
    deletedFeatures: string[] | null;
    notice: string[] | null;
    security: string[] | null;
    futurePlans: string[] | null;
    note: string[] | null;
};

export type VersionSummary = {
    version: string;
    path?: string;
};
