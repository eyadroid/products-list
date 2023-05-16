import axios from "axios";
import { APIResponse } from "@/types/APIResponse";
import { AxiosAdapter } from "@/adapters/AxiosAdapter";
import { AxiosResponse } from "node_modules/axios/index";

class ApiService {
    get(path:string, params:object = {}) : Promise<APIResponse> {
        return this.parseResponse(axios.get(path, {
            params,
        }));
    }
    
    delete(path:string, params:object = {}) : Promise<APIResponse> {
        return this.parseResponse(axios.delete(path, {
            data: params,
        }));
    }

    post(path:string, boday:object) : Promise<APIResponse> {
        return this.parseResponse(axios.post(path, boday));
    }

    private parseResponse(respPromise:Promise<AxiosResponse>): Promise<APIResponse> {
        return new Promise<APIResponse>(async (resolve) => {
            try {
                const resp = await respPromise;
                const adapter = new AxiosAdapter(resp);
                resolve(adapter.toAPIResponse());
            } catch(e:any) {
                if (e.response) {
                    const adapter = new AxiosAdapter(e.response);
                    resolve(adapter.toAPIResponse());
                } else {
                    throw e;
                }
            }
        })
    }
}

export const apiService: ApiService = new ApiService();