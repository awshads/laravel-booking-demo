import { usePage, Head, Link } from '@inertiajs/react';
import FilterBar from '@/components/FilterBar/FilterBar';
import Pagination from '@/components/Pagination/Pagination';
import Table from '@/components/Table/Table';
import { PaginatedData, Facility, Auth } from '@/types';

export default function Dashboard() {
    const { facilities, auth } = usePage<{ facilities: PaginatedData<Facility>, auth: Auth }>().props;
    const {
        data,
        links
    } = facilities;
    
    return (
        <>
            <Head title="Dashboard" />
            <div className="flex items-center justify-between mb-6">
                <FilterBar />
                {auth.user.role === 'admin' && (
                    <Link
                        className="btn-indigo focus:outline-none"
                        href={route('facilities.create')}
                    >
                        <span>Create</span>
                        <span className="hidden md:inline"> Facility</span>
                    </Link>
                )}
            </div>
            <Table
                columns={[
                    {
                        label: 'Name',
                        name: 'name',

                        renderCell: row => (
                            <>{row.name}</>
                        )
                    },
                    { label: 'Type', name: 'type' },
                    { label: 'Capacity', name: 'capacity' },
                    {
                        label: 'Location',
                        name: 'location',
                        colSpan: 2,
                        renderCell: row => (<>{row.location}</>)
                    }
                ]}
                rows={data}
                getRowDetailsUrl={row => route('facilities.edit', {facility: row.id})}
            />
            <Pagination links={links} />
        </>
    );
}
