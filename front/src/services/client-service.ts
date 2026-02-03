import { api } from 'src/lib/api';
import type { ClientCreate, UpdateClient } from 'src/types/client';

export const clientService = {
  clients: async () => {
    const response = await api.get('/clients');
    return await response.data;
  },

  create_client: async (data: ClientCreate) => {
    const response = await api.post('/clients', data);
    return await response.data;
  },

  update: async (id: number, data: UpdateClient) => {
    return await api.patch(`/clients/${id}`, data);
  },

  delete: async (id: number) => {
    return await api.delete(`/clients/${id}`);
  },
};
