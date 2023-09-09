import { Variant } from "../variant"
import { Master } from "./master"

export type Detile = {
    id: number
    created_at: string
    updated_at?: string
    master: Master
    product: Variant
    quantity: number
    price: number
}
