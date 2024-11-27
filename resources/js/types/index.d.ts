export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    provider: string;
    theme: string;
    profile_pic_b64?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};
