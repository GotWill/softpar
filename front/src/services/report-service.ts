import { api } from 'src/lib/api';

export const reportService = {
  get: async ({ client_id, month }: { client_id: number | undefined; month: string }) => {
    const response = await api.get(`/reports/client/${client_id}`, {
      params: {
        month,
      },
    });

    return response.data;
  },
};
