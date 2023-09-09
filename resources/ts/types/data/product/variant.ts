import { Moderation } from "@res/ts/enums/moderation"
import { Category } from "../category"
import { Master } from "./master"

export type Variant = {
    id: number
    created_at: string
    updated_at?: string
    master: Master
    price: number
    stock: number
    code: string
    category: Category
    status: Moderation
    slug: string
    name: string
    description: string
}
