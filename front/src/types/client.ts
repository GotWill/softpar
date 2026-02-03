export interface Client {
  id?: number | undefined;
  name: string;
  email: string;
  whatsapp: string;
  observation: string;
  warning_email: boolean;
  warning_whatsapp: boolean;
}

export type ClientCreate = Partial<Pick<Client, 'warning_email' | 'warning_whatsapp' | 'observation'>>;

export type UpdateClient = Partial<Client>
