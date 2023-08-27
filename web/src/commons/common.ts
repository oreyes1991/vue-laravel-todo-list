export type Task = {
  name: string;
  description: string;
  completed_at: string;
  id: number;
};

export const apiURL = process.env.VUE_APP_API_URL as string;
