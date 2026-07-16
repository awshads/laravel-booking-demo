export type PaginatedData<T> = {
  data: T[];
  links: {
      url: null | string;
      label: string;
      active: boolean;
    }[];
};