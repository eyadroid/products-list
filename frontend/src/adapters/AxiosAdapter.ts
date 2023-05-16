import { APIResponse, APIValidationError } from "@/types/APIResponse";
import { AxiosResponse } from "node_modules/axios/index";

class APIErrorAdapter {
    private errors: any;

    constructor(errors:any) {
        this.errors = errors;
    }

    toValidationErrors() : APIValidationError[] {
        const errorsKeys = Object.keys(this.errors);
        const errorsArray: APIValidationError[] = errorsKeys.reduce<APIValidationError[]>((all, key) => [
            ...all, new APIValidationError(key, Object.values(this.errors[key]))
        ], []);

        return errorsArray;
    }
}

export class AxiosAdapter {
    private response: AxiosResponse;
    constructor(response: AxiosResponse) {
        this.response = response;
    }

    toAPIResponse(): APIResponse {
        const {status, data} = this.response;

        if (status == 200) {
            return new APIResponse(true, data.message, data.message ? null : data);
        }

        else if (status == 422) {
            const {errors} = this.response.data;
            if (errors) {
                const errorsArray = new APIErrorAdapter(errors).toValidationErrors();
                return new APIResponse(false, null, null, errorsArray);
            }
        }

        return new APIResponse(false, data.message, null);
    }

    // private parseErrorfromApiResponse(key:string, errors:): APIValidationError {
    //     return new APIValidationError(error);
    // }
}