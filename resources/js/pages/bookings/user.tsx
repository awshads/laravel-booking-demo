import { usePage, Head } from '@inertiajs/react';
import FilterBar from '@/components/FilterBar/FilterBar';
import Pagination from '@/components/Pagination/Pagination';
import { PaginatedData, Booking } from '@/types';
import Table from '@/components/Table/Table';

const List = () => {
  const { bookings } = usePage<{ bookings: PaginatedData<Booking> }>().props;
  const {
    data,
    links
  } = bookings;

  return (
    <>
      <Head title="My Bookings" />
      <div className="flex items-center justify-between mb-6">
        <FilterBar />
      </div>
      <Table
        columns={[
          {
            label: 'Facility',
            name: 'facility.name',

            renderCell: row => (
              <>{row.facility.name}</>
            )
          },
          { label: 'Booked At', name: 'booked_at' },
          {
            label: 'Status',
            name: 'status',
            colSpan: 2,
            renderCell: row => (<>{row.status}</>)
          }
        ]}
        rows={data}
        getRowDetailsUrl={row => route('users.edit', {user: row.id})}
      />
      <Pagination links={links} />
    </>
  );
};

export default List;
