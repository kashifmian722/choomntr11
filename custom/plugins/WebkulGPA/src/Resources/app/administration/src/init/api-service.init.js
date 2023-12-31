const Application = Shopware.Application;   
import GpaApiService from '../../src/core/service/api/gpa-api.service';

Application.addServiceProvider('GpaApiService', (container) => {
    const initContainer = Application.getContainer('init');
    return new GpaApiService(initContainer.httpClient, container.loginService);
});
