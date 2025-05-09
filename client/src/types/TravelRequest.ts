export interface TravelRequest {
  id: number;
  user_id: number;
  requester_name: string;
  destination: string;
  start_date: string; // ISO date string
  end_date: string;   // ISO date string
  status: string;
  created_at: string; // ISO date string
  updated_at: string; // ISO date string
}
