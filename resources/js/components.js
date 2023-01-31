import Slider from 'js/components/Slider.vue';

import BusinessDiscussion from 'js/components/form/BusinessDiscussion.vue';
import ChatForm from 'js/components/form/ChatForm.vue';
import ChatBody from 'js/components/chat/ChatBody.vue';
import ChatFooter from 'js/components/chat/ChatFooter.vue';
import ChatCreateFooter from 'js/components/chat/ChatCreateFooter.vue';

import CommonInquiryForm from 'js/components/common/Inquiryform.vue';

import UserEntryForm from 'js/components/user/EntryForm.vue';
import UserLoginForm from 'js/components/user/LoginForm.vue';
import UserUpdateForm from 'js/components/user/UpdateForm.vue';
import UserProfileForm from 'js/components/user/ProfileImageForm.vue';
import UserPropertyList from 'js/components/user/PropertyList.vue';
import UserPainterListIndex from 'js/components/user/PainterListIndex.vue';
import UserPainterDetail from 'js/components/user/PainterDetail.vue';
import PainterSearchBar from 'js/components/user/PainterSearchBar.vue';
import UserFavoriteListIndex from 'js/components/user/FavoriteListIndex.vue';
import UserEvaluation from 'js/components/user/Evaluation.vue';
import UserInquiryForm from 'js/components/user/Inquiryform.vue';
import UserUpdatePasswordForm from 'js/components/user/UpdatePasswordForm.vue';
import UserWithdrawForm from 'js/components/user/WithdrawForm.vue';
import StarRatingEvaluate from 'js/components/user/StarRatingEvaluate.vue';
import BulkQuatationForm from 'js/components/user/BulkQuatationForm.vue';
import UserColumnList from 'js/components/user/ColumnList.vue';
import UserColumnPainter from 'js/components/user/ColumnPainter.vue';
import UserColumnDetail from 'js/components/user/ColumnDetail.vue';
import UserExampleList from 'js/components/user/ExampleList.vue';
import UserExamplePainter from 'js/components/user/ExamplePainter.vue';
import UserChatList from 'js/components/user/ChatList.vue';
import StarRatingTotal from 'js/components/user/StarRatingTotal.vue';
import StarRating from 'js/components/user/StarRating.vue';

import PainterEntryForm from 'js/components/painter/EntryForm.vue';
import PainterLoginForm from 'js/components/painter/LoginForm.vue';
import PainterUpdateForm from 'js/components/painter/UpdateForm.vue';
import PainterProfileForm from 'js/components/painter/ProfileImageForm.vue';
import PainterPropertyList from 'js/components/painter/PropertyList.vue';
import PainterInquiryForm from 'js/components/painter/Inquiryform.vue';
import PainterUpdatePasswordForm from 'js/components/painter/UpdatePasswordForm.vue';
import PainterWithdrawForm from 'js/components/painter/WithdrawForm.vue';
import Progress from 'js/components/painter/ProfileProgress.vue';
import PainterImages from 'js/components/painter/Images.vue';
import PainterExampleForm from 'js/components/painter/ExampleForm.vue';
import PainterExampleList from 'js/components/painter/ExampleList.vue';
import PainterColumnList from 'js/components/painter/ColumnList.vue';
import PainterColumnForm from 'js/components/painter/ColumnForm.vue';
import PainterDetail from 'js/components/painter/Detail.vue';
import PainterPreview from 'js/components/painter/Preview.vue';
import PainterChatList from 'js/components/painter/ChatList.vue';

import SideBar from 'js/components/admin/SideBar.vue';
import Pagination from 'js/components/admin/Pagination.vue';
import AdminList from 'js/components/admin/AdminList.vue';
import WorkerList from 'js/components/admin/WorkerList.vue';
import WorkerDetail from 'js/components/admin/WorkerDetail.vue';
import ClientList from 'js/components/admin/ClientList.vue';
import ClientDetail from 'js/components/admin/ClientDetail.vue';
import RequestItemDetail from 'js/components/admin/RequestItemDetail.vue';
import Columns from 'js/components/admin/ColumnList.vue';
import ColumnDetailAdmin from 'js/components/admin/ColumnDetailAdmin.vue';
import Examples from 'js/components/admin/ExampleList.vue';
import ConstructionCaseDetail from 'js/components/admin/ConstructionCaseDetail.vue';
import RankDetail from 'js/components/admin/RankDetail.vue';
import Evaluations from 'js/components/admin/EvaluationList.vue';
import NoticeList from 'js/components/admin/NoticeList.vue';
import NoticeCreate from 'js/components/admin/NoticeCreate.vue';
import NoticeEdit from 'js/components/admin/NoticeEdit.vue';
import NoticeShow from 'js/components/admin/NoticeShow.vue';
//import AlertModal from 'js/components/AlertModal.vue';

export const AppComponents = {
    'slider': Slider,
    'chat-form': ChatForm,
    'business-discussion': BusinessDiscussion,
    'chat-body': ChatBody,
    'chat-footer': ChatFooter,
    'chat-create-footer': ChatCreateFooter,

    'common-inquiry-form': CommonInquiryForm,

    'user-entry-form': UserEntryForm,
    'user-login-form': UserLoginForm,
    'user-update-form': UserUpdateForm,
    'user-profile-form': UserProfileForm,
    'user-property-list': UserPropertyList,
    'user-painter-list-index': UserPainterListIndex,
    'user-painter-detail': UserPainterDetail,
    'user-favorite-list-index': UserFavoriteListIndex,
    'starratingevaluate': StarRatingEvaluate,
    'bulk-quatation': BulkQuatationForm,
    'user-column-list': UserColumnList,
    'user-column-painter': UserColumnPainter,
    'user-column-detail': UserColumnDetail,
    'user-example-list': UserExampleList,
    'user-example-painter': UserExamplePainter,
    'user-chat-list': UserChatList,
    'overall-rating': StarRatingTotal,
    'starrating': StarRating,
    'user-evaluation': UserEvaluation,
    'user-inquiry-form': UserInquiryForm,
    'user-update-password-form': UserUpdatePasswordForm,
    'user-withdraw-form': UserWithdrawForm,

    'painter-entry-form': PainterEntryForm,
    'painter-login-form': PainterLoginForm,
    'painter-update-form': PainterUpdateForm,
    'painter-profile-form': PainterProfileForm,
    'painter-property-list': PainterPropertyList,
    'painter-example-form': PainterExampleForm,
    'painter-profile-progress': Progress,
    'painter-search-bar': PainterSearchBar,
    'painter-images': PainterImages,
    'painter-inquiry-form': PainterInquiryForm,
    'painter-update-password-form': PainterUpdatePasswordForm,
    'painter-withdraw-form': PainterWithdrawForm,
    'painter-example-list': PainterExampleList,
    'painter-column-list': PainterColumnList,
    'painter-column-form': PainterColumnForm,
    'painter-detail': PainterDetail,
    'painter-preview': PainterPreview,
    'painter-chat-list': PainterChatList,

    'adminsidebar': SideBar,
    'adminpagination': Pagination,
    'adminlist': AdminList,
    'workerlist': WorkerList,
    'workerdetail': WorkerDetail,
    'clientlist': ClientList,
    'clientdetail': ClientDetail,
    'requestitemdetail': RequestItemDetail,
    'columnlist': Columns,
    'columndetailadmin': ColumnDetailAdmin,
    'examplelist': Examples,
    'constructioncasedetail': ConstructionCaseDetail,
    'evaluationlist': Evaluations,
    'noticelist': NoticeList,
    'notice-create': NoticeCreate,
    'notice-edit': NoticeEdit,
    'notice-show': NoticeShow,
    'rankdetail': RankDetail,

    //'alert-modal':AlertModal,
}