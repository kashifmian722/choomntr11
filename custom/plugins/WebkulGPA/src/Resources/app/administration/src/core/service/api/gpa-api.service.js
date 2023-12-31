import ApiService from 'src/core/service/api.service';

class GpaApiService extends ApiService 
{
    constructor(httpClient, loginService, apiEndpoint = 'gpa') {
        super(httpClient, loginService, apiEndpoint);
    }

    saveConfig(config) {
        const apiRoute = `${this.getApiBasePath()}/save/config`
        return this.httpClient.post(
            apiRoute, {
                config: config
            }, {
                headers: this.getBasicHeaders()
            }
        ).then((response) => {
            return ApiService.handleResponse(response);
        });
    }
}

export default GpaApiService;
