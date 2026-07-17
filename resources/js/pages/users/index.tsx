import { usePage, Head } from '@inertiajs/react';
import FilterBar from '@/components/FilterBar/FilterBar';
import Pagination from '@/components/Pagination/Pagination';
import { PaginatedData, User } from '@/types';
import Table from '@/components/Table/Table';

const List = () => {
  const { users } = usePage<{ users: PaginatedData<User> }>().props;
  const {
    data,
    links
  } = users;

  return (
    <>
      <Head title="Users" />
      <div className="flex items-center justify-between mb-6">
        <FilterBar />
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
          { label: 'Email', name: 'email' },
          {
            label: 'Role',
            name: 'role',
            colSpan: 2,
            renderCell: row => (<>{row.role}</>)
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
