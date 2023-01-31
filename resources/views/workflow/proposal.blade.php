<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            @if ($errors->any())
            <div>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            <h1>新規相談一覧</h1>
            @foreach ($proposal as $data)
            <div>
                <p>{{ $data->bulk_flg == 0 ? '個別見積' : '一括見積' }}</p>
                <p>{{ date('Y年m月d日', strtotime($data->created_at)) }}に送信された見積依頼</p>
            </div>
            <button @click="showEstimate({{ $data->request_id }})">詳細を確認</button>
            <button @click="setProposal({{ $data->id }})">相談に進む</button>
            @endforeach
            <div style="margin-top:10px;">
                <a href="/api/workflow/painter">相談・商談一覧</a><br />
                <a href="/painter/mypage">マイページ</a><br />
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
        <script>

            new Vue({
                el: '#app',
                data: {
                },
                methods: {
                    showEstimate: function(id) {
                    },
                    setProposal: function(id) {
                        axios.post('/api/proposal', {proposal_id : id}).then(function(){
                            location.href = '/api/proposal';
                        });
                    },
                }
            });

        </script>
    </body>
</html>
