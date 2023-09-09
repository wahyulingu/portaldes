import { Moderation } from "@res/ts/enums/moderation"
import { User } from "../user"

export type Customer = {
    id: number
    created_at: string
    updated_at?: string
    user: User
    status: Moderation
    name: string
    bio: string
    address: string
    phone: string
    email: string
}
