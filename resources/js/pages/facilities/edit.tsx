import React from 'react';
import { Head } from '@inertiajs/react';
import { Link, usePage, useForm, router } from '@inertiajs/react';
import DeleteButton from '@/components/Button/DeleteButton';
import LoadingButton from '@/components/Button/LoadingButton';
import TextInput from '@/components/Form/TextInput';
import SelectInput from '@/components/Form/SelectInput';
import { Facility } from '@/types';
import FieldGroup from '@/components/Form/FieldGroup';

const Edit = () => {
  const { facility } = usePage<{ facility: Facility }>().props;

  const { data, setData, errors, post, processing } = useForm({
    name: facility.name || '',
    description: facility.description || '',
    type: facility.type || '',
    capacity: facility.capacity ?? 0,
    location: facility.location || '',

    // NOTE: When working with Laravel PUT/PATCH requests and FormData
    // you SHOULD send POST request and fake the PUT request like this.
    _method: 'patch'
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();

    // NOTE: We are using POST method here, not PUT/PATCH. See comment above.
    post(route('facilities.update', {facility: facility.id}));
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this facility?')) {
      router.delete(route('facilities.destroy', {facility: facility.id}));
    }
  }

  return (
    <div>
      <Head title={`${data.name} - ${data.type}`} />
      <div className="flex justify-start max-w-lg mb-8">
        <h1 className="text-3xl font-bold">
          <Link
            href={route('dashboard')}
            className="text-indigo-600 hover:text-indigo-700"
          >
            Facilities
          </Link>
          <span className="mx-2 font-medium text-indigo-600">/</span>
          {data.name} - {data.type}
        </h1>
      </div>
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="grid gap-8 p-8 lg:grid-cols-2">
            <FieldGroup
              label="Name"
              name="name"
              error={errors.name}
            >
              <TextInput
                name="name"
                error={errors.name}
                value={data.name}
                onChange={e => setData('name', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Description" name="description" error={errors.description}>
              <TextInput
                name="description"
                error={errors.description}
                value={data.description}
                onChange={e => setData('description', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Type" name="type" error={errors.type}>
              <SelectInput
                name="type"
                error={errors.type}
                value={data.type}
                onChange={e => setData('type', e.target.value)}
                options={[
                  { value: 'meetingRoom', label: 'Meeting Room' },
                  { value: 'sportsAndRec', label: 'Sports & Recreation' },
                  { value: 'entertainment', label: 'Entertainment' }
                ]}
              />
            </FieldGroup>

            <FieldGroup label="Capacity" name="capacity" error={errors.capacity}>
              <TextInput
                name="capacity"
                type="number"
                error={errors.capacity}
                value={data.capacity}
                onChange={e => setData('capacity', parseInt(e.target.value) || 0)}
              />
            </FieldGroup>

            <FieldGroup label="Location" name="location" error={errors.location}>
              <TextInput
                name="location"
                error={errors.location}
                value={data.location}
                onChange={e => setData('location', e.target.value)}
              />
            </FieldGroup>
          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!facility.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete Facility</DeleteButton>
            )}
            <LoadingButton
              loading={processing}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update Facility
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Edit;
