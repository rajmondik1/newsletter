import axios from "axios";

export function getList(params) {
  return axios.get('http://localhost', {
    params: {
      ...params
    }
  }).then(res => {
    return res;
  })
  // return request({
  //   url: '/vue-admin-template/table/list',
  //   method: 'get',
  //   params
  // })
}

export function getCategories(params) {
  return axios.get('http://localhost/categories', {
    params: {
      ...params
    }
  }).then(res => {
    return res;
  })
}

export function getSubscription(id) {
  return axios.get('http://localhost/' + id).then(res => {
    return res;
  })
}

export function putSubscription(data) {
  return axios.put('http://localhost', data).then(res => {
    return res;
  })
}

export function removeSubscription(id) {
  return axios.delete('http://localhost/' + id).then(res => {
    return res;
  })
}
