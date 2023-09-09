import { Permission } from "./permission"

export type Role = {
    name: string
    guard: string
    permissions: Permission[]
}
