export type Facility = {
    id: number;
    name: string;
    description: string;
    type: string;
    capacity: number;
    location: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};