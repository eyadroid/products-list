export class APIValidationError {
    public key:string;
    public errors:string[];

    constructor(
        key:string,
        errors:string[]
    ) {
        this.key = key;
        this.errors = errors;
    }
}

export class APIResponse {
    // only data
    // only errors
    // success with message
    public success:boolean;
    public data:object|null;
    public message:string|null;
    public errors:APIValidationError[];

    constructor(success:boolean, message:string|null, data:object|null, errors: APIValidationError[] = [])
     {
        this.success = success;
        this.data = data;
        this.message = message;
        this.errors = errors;
     }
}