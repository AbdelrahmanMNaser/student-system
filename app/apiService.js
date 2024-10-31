app.factory('apiService', ['$http', 'apiConfig', function($http, apiConfig) {
  
  function buildUrl(endpoint) {
    const [main, sub] = endpoint.split('.');
    
    if (!main || !sub) {
      console.error('Invalid endpoint format:', endpoint);
      return '';
    }
    const url = apiConfig.baseUrl + apiConfig.endpoints[main][sub];
    return url;
  }

  function request(method, url, data) {
    if (!url) {
      return Promise.reject('Invalid URL');
    }
    return $http({
      method: method,
      url: url,
      data: data
    });
  }

  return {
    fetchData: function(endpoint) {
      const url = buildUrl(endpoint);
      return request('GET', url);
    },
    fetchDataById: function(endpoint, id) {
      const url = buildUrl(endpoint) + '/' + id;
      return request('GET', url);
    },
    insertData: function(endpoint, data) {
      const url = buildUrl(endpoint);
      return request('POST', url, data);
    },
    updateData: function(endpoint, id, data) {
      const url = buildUrl(endpoint) + '/' + id;
      return request('PUT', url, data);
    },
    deleteData: function(endpoint, id) {
      const url = buildUrl(endpoint) + '/' + id;
      return request('DELETE', url);
    }
  };
}]);