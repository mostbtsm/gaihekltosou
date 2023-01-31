const apiPrefix = '/api/' + process.env.MIX_API_VER + '/painter';
const columnPrefix = apiPrefix + '/column';
const examplePrefix = apiPrefix + '/example';
const chatPrefix = apiPrefix + '/chat';

export const Web = {
  column: {
    edit: id => '/painter/column/edit/' + id,
  },
  example: {
    edit: id => '/painter/example/edit/' + id,
  },
  chat: {
    id: id => '/painter/chat/' + id,
  },
}

export const Api = {
  entry: apiPrefix,
  login: apiPrefix + '/login',
  show: apiPrefix + '/show',
  update: apiPrefix + '/update',
  uploadImage: apiPrefix + '/upload_image',
  deleteImage: apiPrefix + '/delete_image',
  store: apiPrefix + '/store',
  inquiry: apiPrefix + '/inquiry',

  column: {
    index: columnPrefix,
    id: id => columnPrefix + '/' + id,
  },

  example: {
    index: examplePrefix,
    id: id => examplePrefix + '/' + id,
  },

  chat: {
    index: chatPrefix,
    id: id => chatPrefix + '/' + id,
    message: '/api/' + process.env.MIX_API_VER + '/chat',
  },

  images: apiPrefix + '/images',
  imageurl: apiPrefix + '/imageurl',
  exampleentry: apiPrefix + '/exampleentry',
  inquiry: apiPrefix + '/inquiry',
  updatePassword: apiPrefix + '/update_password',
  withdraw: apiPrefix + '/withdraw',
  columnstore: apiPrefix + '/columnstore',
  getpainterinfo: apiPrefix + '/getpainterinfo',
  getexampleentrylink: apiPrefix + '/getexampleentrylink',
  getevaluation: apiPrefix + '/getevaluation',
  getcolumnlink: apiPrefix + '/getcolumnlink',
  examplelist: apiPrefix + '/examplelist',
  exampleupload: apiPrefix + '/exampleupload',
  deleteexample: apiPrefix + '/deleteexample',
  getcolumn: apiPrefix + '/getcolumn',
  columnupload: apiPrefix + '/columnupload',
  deletecolumn: apiPrefix + '/deletecolumn',
}