import { Payment } from "@res/ts/enums/payment"
import { Customer } from "../../profile/customer"

export type Master = {
    id: number
    total: number
    created_at: string
    updated_at?: string
    customer: Customer
    payment: Payment
    invoice: string
    description: string
}
