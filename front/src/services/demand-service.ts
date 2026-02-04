import { api } from 'src/lib/api';
import type { UpsertDemand } from 'src/types/demand';

export const demandService = {
  demands: async () => {
    const response = await api.get('/demands');
    return response.data;
  },

  create: async (data: UpsertDemand) => {
    const response = await api.post('/demands', data);
    return response.data;
  },

  update: async (id: number, data: UpsertDemand) => {
    const response = await api.patch(`/demands/${id}`, data);
    return response.data;
  },

  delete: async (id: number) => {
    return await api.delete(`/demands/${id}`);
  },

  updateStatus: async (id: number, status: string) => {
    return await api.patch(`/demands/${id}/status`, {
      status,
    });
  },
};
