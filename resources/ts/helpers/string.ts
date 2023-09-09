export function limit(string: string, length: number, suffix: string = '...') {
    const sliced = string.slice(0, length).trim()

    if (string.length > length) {
        return sliced.concat(suffix)
    }

    return sliced
}

export function statusType(status: string) {
    for (const [_i, value] of ['active', 'accepted', 'approved', 'success'].entries()) {

        if (value == status) return "success"
    }

    for (const [_i, value] of ['draft', 'suspended', 'pending'].entries()) {

        if (value == status) return "warning"
    }

    return "danger";
}