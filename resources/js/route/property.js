const apiPrefix = '/api/' + process.env.MIX_API_VER + '/property';

export const Web = {
}

export const Api = {
  show: apiPrefix + '/show',
  store: apiPrefix + '/store',
  update: apiPrefix + '/update/',
  destroy: apiPrefix + '/destroy/',
}