export function rupiah(number: number) {
    const formater = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    })

    return formater.format(number);
}
