export function readAsDataURL(file: File)
{
    return new Promise<string>(function (resolve){
        const fileReader = new FileReader();

        fileReader.onload = (event) => {
            if (event.target?.result && typeof event.target.result == 'string')
            {
                resolve(event.target.result)
            }
        }

        fileReader.readAsDataURL(file);
    })
}
