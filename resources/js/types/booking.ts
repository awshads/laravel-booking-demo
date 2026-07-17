import type { Facility } from './facility';
import type { User } from './auth';

export type Booking = {
    id: number;
    facility_id: number;
    booked_at: string;
    booked_by_id: number;
    status: string;
    reviewed_at: string;
    reviewed_by_id: number;
    facility: Facility;
    user: User;
    reviewer: User;
    [key: string]: unknown;
};