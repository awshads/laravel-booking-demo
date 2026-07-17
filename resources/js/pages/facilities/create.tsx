import { Link, useForm } from '@inertiajs/react';
import LoadingButton from '@/components/Button/LoadingButton';
import TextInput from '@/components/Form/TextInput';
import SelectInput from '@/components/Form/SelectInput';
import FieldGroup from '@/components/Form/FieldGroup';

const Create = () => {
  const { data, setData, errors, post, processing } = useForm({
    name: '',
    description: '',
    type: '',
    capacity: 0,
    location: '',
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post(route('facilities.store'));
  }

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">
        <Link
          href={route('dashboard')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Facilities
        </Link>
        <span className="font-medium text-indigo-600"> /</span> Create
      </h1>
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="grid gap-8 p-8 lg:grid-cols-2">
            <FieldGroup label="Name" name="name" error={errors.name}>
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
          <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
            <LoadingButton
              loading={processing}
              type="submit"
              className="btn-indigo"
            >
              Create Facility
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Create;
