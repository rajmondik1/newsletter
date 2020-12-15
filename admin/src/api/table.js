import request from '@/utils/request'
import axios from "axios";

export function getList(params) {
  return axios.get('http://localhost').then( res => {
    return res;
  })
  // return request({
  //   url: '/vue-admin-template/table/list',
  //   method: 'get',
  //   params
  // })
}
