import { Link, usePage, Head } from '@inertiajs/react';
import FilterBar from '@/components/FilterBar/FilterBar';
import Pagination from '@/components/Pagination/Pagination';
import { PaginatedData, User } from '@/types';
import Table from '@/components/Table/Table';
import { Trash2 } from 'lucide-react';
import { dashboard, users } from '@/routes';

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
              <>
                <>{row.name}</>
                {row.deleted_at && (
                  <Trash2 size={16} className="ml-2 text-gray-400" />
                )}
              </>
            )
          },
          { label: 'Email', name: 'email' },
          {
            label: 'Role',
            name: 'owner',
            colSpan: 2,
            renderCell: row => (row.owner ? 'Owner' : 'User')
          }
        ]}
        rows={data}
        // getRowDetailsUrl={row => route('users.edit', row.id)}
      />
      <Pagination links={links} />
    </>
  );
};

List.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
        {
            title: 'Users',
            href: users(),
        }
    ],
};

export default List;
