export type Category = {
    id: number
    created_at: string
    updated_at?: string
    parent?: Category
    status: string
    type: string
    slug: string
    name: string
    description: string
}
