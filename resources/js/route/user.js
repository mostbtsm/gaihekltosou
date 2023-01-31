const apiPrefix = '/api/' + process.env.MIX_API_VER + '/user';
const favoritePrefix = apiPrefix + '/favorite';
const painterPrefix = apiPrefix + '/painter';
const examplePrefix = apiPrefix + '/example';
const columnPrefix = apiPrefix + '/column';
const chatPrefix = apiPrefix + '/chat';

export const Web = {
  painter: {
    id: id => '/user/painter/' + id,
  },

  example: {
    id: id => '/user/example/' + id,
    painter: id => '/user/example/painter/' + id,
  },

  column: {
    id: id => '/user/column/' + id,
    painter: id => '/user/column/painter/' + id,
  },

  chat: {
    id: id => '/user/chat/' + id,
    create: painter_id => '/user/chat/create/' + painter_id,
  },
}

export const Api = {
  entry: apiPrefix,
  login: apiPrefix + '/login',
  show: apiPrefix + '/show',
  update: apiPrefix + '/update',
  uploadImage: apiPrefix + '/upload_image',
  deleteImage: apiPrefix + '/delete_image',
  properties: apiPrefix + '/properties',
  search: apiPrefix + '/search',

  favorite: {
    index: favoritePrefix,
    id: id => favoritePrefix + '/' + id,
  },

  painter: {
    index: painterPrefix,
    id: id => painterPrefix + '/' + id,
    favorite: painterPrefix + '/favorite',
  },

  example: {
    index: examplePrefix,
    id: id => examplePrefix + '/' + id,
    painter: id => examplePrefix + '/painter/' + id,
  },

  column: {
    index: columnPrefix,
    id: id => columnPrefix + '/' + id,
    painter: id => columnPrefix + '/painter/' + id,
  },

  chat: {
    index: chatPrefix,
    id: id => chatPrefix + '/' + id,
    message: '/api/' + process.env.MIX_API_VER + '/chat',
  },

  examplelist: apiPrefix + '/examplelist',
  evaluationupdate: apiPrefix + '/evaluationupdate',
  painterprofileimage: apiPrefix + '/painterprofileimage',
  painterimages: apiPrefix + '/painterimages',
  painterimageurl: apiPrefix + '/painterimageurl',
  exampleimageurl: apiPrefix + '/exampleimageurl',
  getevaluation: apiPrefix + '/getevaluation',
  getevaluationcount: apiPrefix + '/getevaluationcount',

  addfavorite: apiPrefix + '/addfavorite',
  deletefavorite: apiPrefix + '/deletefavorite',
  inquiry: apiPrefix + '/inquiry',
  updatePassword: apiPrefix + '/update_password',
  withdraw: apiPrefix + '/withdraw',
  getcolumn: apiPrefix + '/getcolumn',
}