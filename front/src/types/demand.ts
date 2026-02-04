export type Prority = 'Baixa' | 'Média' | 'Alta' | 'Urgente';
export type Status =
  | 'Backlog'
  | 'Autorização'
  | 'Fila'
  | 'Em desenvolvimento'
  | 'Teste'
  | 'Deploy'
  | 'Concluído';

export type Demand = {
  id: number;
  client_id: null | number;
  title: string;
  priority: Prority;
  sector: string;
  responsible: string;
  who_should_test: string;
  description: string;
  midia: string;
  customer_charged: boolean;
  estimated_time: number;
  time_spent: number;
  status: Status;
  return: boolean;
};

type RequiredFields = Omit<
  Demand,
  'id' | 'midia' | 'customer_charged' | 'estimated_time' | 'time_spent' | 'status' | 'return'
>;

export type UpsertDemand = RequiredFields & {
  id?: number;
  midia?: string;
  customer_charged?: boolean;
  estimated_time?: number;
  time_spent?: number;
  status?: Status;
  return?: boolean;
};

