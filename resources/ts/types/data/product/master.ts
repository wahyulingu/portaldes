import { Moderation } from "@res/ts/enums/moderation"
import { Category } from "../category"
import { Owner } from "../profile/owner"

export type Master = {
    id: number
    created_at: string
    updated_at?: string
    owner: Owner
    category: Category
    status: Moderation
    slug: string
    name: string
    description: string
}
