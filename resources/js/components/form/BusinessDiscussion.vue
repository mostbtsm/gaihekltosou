<template>
<div>
    <div class="tab">
      <a class="tab-l">
        個別相談中
      </a>
      <a class="tab-r">
        一括相談中
      </a>
    </div>
    <div v-if="userId == 0">
      <button onclick="location.href='/api/proposal'">新規相談確認</button>
    </div>

    <div v-if="userId > 0">
        <select v-model="property_id" name="property_id" @change="selectProperty()" class="w-100">
            <option v-for="data in property_data" :key="data.id" :value="data.id">{{ data.name ? data.name : '物件ID：' + data.id }}</option>
        </select>  
    </div>

    <div class="mt-2">
      <mdb-tabs
        :active="0"
        default
        :links="[
          { text: '相談中', class:'item1'},
          { text: '商談中', class: 'item2'}
      ]">
      <template :slot="'相談中'">  
        <div class="consultation">
          <div  @click="chatForm(data.painter_id, data.request_id)" v-for="(data, index) in data1" :key="index" class="row mb-2">
              <div class="data">
                <div class="data-img">
                  <img class="card-img-top" alt="Card image cap" src="/image/mypageimg.PNG">
                </div>
                <div class="data-body">
                  <div class="data-name">
                    <div class="data-name-text">
                      {{data.name}}
                    </div>
                    <div class="data-date">
                      10:23
                    </div>
                  </div>
                  <div class="data-content">
                    <div class="data-content-text">
                      {{ data.contents }}
                    </div>
                    <a href="">2</a>
                  </div>
                  <a class="data-link" href="">
                    ここに「メモ」の一行目が表示
                  </a>
                </div>
                <a href="">非表示</a>
              </div>
           </div> 
        </div>
      </template>    
      <template :slot="'商談中'">
         <div class="negotiation">
         
          <div v-for="(data, index) in data2" :key="index" class="row mb-2">
              <div class="data">
                <div class="data-img">
                  <img class="card-img-top" alt="Card image cap" src="/image/mypageimg.PNG">
                </div>
                <div class="data-body">
                  <div class="data-name">
                    <div class="data-name-text">
                      {{data.name}}
                    </div>
                    <div class="data-date">
                      10:23
                    </div>
                  </div>
                  <div class="data-content">
                    <div class="data-content-text">
                      {{ data.contents }}
                    </div>
                    <a href="">2</a>
                  </div>
                  <a class="data-link" href="">
                    ここに「メモ」の一行目が表示
                  </a>
                </div>
                <a  v-on:click="visible">非表示</a>
                
              </div>
           </div> 
        </div>
      </template>
  
    </mdb-tabs>
  </div>






<!--
    <div v-if="left" key="left">
      <div class="row justify-content-center">
        <table>
          <tr>
            <td>
              <p style="color:red;">相談中</p>
            </td>
            <td>
              <p>｜</p>
            </td>
            <td>
              <div v-on:click="watchRight"><p>商談中</p></div>
            </td>
          </tr>
        </table>
      </div>

      <div class="row justify-content-center">
        <table>
          <tr v-for="(data, index) in data1" :key="index">
            <td>
              <p>{{ data.name }}</p>
              <p>{{ data.contents }}</p>
            </td>
            <td>
              <button class="row blockquote">詳細</button>
            </td>
            <td>
              <button @click="chatForm(data.painter_id, data.request_id)" class="row blockquote">チャット</button>
            </td>
          </tr>
        </table>
      </div>
    </div>
 
    <div v-else-if="right" key="right">
      <div class="row justify-content-center">
        <table>
          <tr>
            <td>
              <div v-on:click="watchLeft"><p>相談中</p></div>
            </td>
            <td>
              <p>｜</p>
            </td>
            <td>
              <p style="color:red;">商談中</p>
            </td>
          </tr>
        </table>
      </div>

      <div class="row justify-content-center">
        <table>
          <tr v-for="(data, index) in data2" :key="index">
            <td>
              <p>{{ data.name }}</p>
              <p>{{ data.contents }}</p>
            </td>
            <td>
              <button class="row blockquote" v-on:click="visible">非表示</button>
            </td>
            <td>
              <button class="row blockquote" v-on:click="del">削除</button>
            </td>
          </tr>
        </table>
      </div>
    </div>

-->
</div>
</template>

<script>
import { mdbTabs} from 'mdbvue';
export default {
    props: ['userId'],
    data() {
      return {
        left: true,
        right: false,
        request_id: null,
        property_id: null,
        property_data: {},
        data1: {},
        data2: {},
      };
    },
    methods: {
      watchLeft: function () {
        this.left = true;
        this.right = false;
      },
      watchRight: function () {
        this.left = false;
        this.right = true;
      },
      selectProperty: function() {
        for (var i = 0; i < this.property_data.length; i++) {
            var data = this.property_data[i];

            if (data.id == this.property_id) {
                this.request_id = data.request_id;
                break;
            }
        }

        axios.get('/api/messages/' + this.request_id + '/0').then(response => {
          this.data1 = response.data;
        });
        axios.get('/api/messages/' + this.request_id + '/1').then(response => {
          this.data2 = response.data;
        });
      },
      chatForm: function(painter_id, request_id) {
        if (this.userId > 0) {
          location.href = '/user/chat/' + painter_id + '/' + request_id;
        } else {
          location.href = '/painter/chat/' + request_id;
        }
      },
    },
    mounted() {
      if (this.userId > 0) {
        axios.get('/api/properties/1/' + this.userId).then(response => {
          this.property_data = response.data;
          this.request_id = this.property_data[0].request_id;

          this.selectProperty();
        });
      } else {
        this.request_id = 0;
        this.selectProperty();
      }
    },
    components: {
     mdbTabs
    },

};
</script>
