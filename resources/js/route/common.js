const apiPrefix = '/api/' + process.env.MIX_API_VER;

export const Web = {
}

export const Api = {
  config: apiPrefix + '/config',
  inquiry: apiPrefix + '/inquiry',
}