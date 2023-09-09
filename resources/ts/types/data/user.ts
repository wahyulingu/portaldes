import { Permission } from "./authorization/permission"
import { Role } from "./authorization/role"

export type User = {
    id: number
    username: string
    name: string
    email: string
    email_verified_at?: string
    current_team_id?: string
    profile_photo_path?: string
    created_at: string
    updated_at?: string
    two_factor_confirmed_at?: string
    profile_photo_url: string
    permissions: Permission[],
    roles: Role[]
}
