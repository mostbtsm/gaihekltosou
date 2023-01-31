<template>
 
    <table style="width:100%" class="trader-table">
        <tr>
            <th>ID</th>
            <th>会社名</th>
            <th>メールアドレス</th>            
            <th>ログイン履歴</th>
            <th></th>
        </tr>
        <tr>
            <td>
                <p>1</p>
            </td>
            <td><p>塗装太郎</p></td>
            <td><p>test@gmail.com</p></td>
            <td><p>2021/5/7</p></td>
            <td>
                <button class="btn-detail">詳細</button>
                <button class="btn-danger">削除</button>
            </td>
        </tr>      
    </table>

</template>

<script>
  import { mdbContainer, mdbCol, mdbRow, mdbIcon, mdbTabs, mdbJumbotron, mdbView, mdbMask, mdbBtn, mdbTextarea, mdbInput } from 'mdbvue';

  export default {
    name: 'TabPage',
    components: {
      mdbContainer,
      mdbCol,
      mdbRow,
      mdbIcon,
      mdbTabs,
      mdbJumbotron,
      mdbView,
      mdbMask,
      mdbBtn,
      mdbTextarea,
      mdbInput,
    }
  };
</script>