@include('visit.top')
<h1>Меню</h1>
<div style="width: 500px">
@foreach($menu as $category)
  <h2>{{ $category['name']}}</h2>
    <div>
        @foreach($category['dishes'] as $dish)
            <div>
                <table width="100%">
                    <tr><td>{{$dish['name']}}</td><td width="100px">{{$dish['price']}}</td></tr>
                    <tr><td colspan="2">{{$dish['description']}}</td></tr>
                </table>
            </div>
        @endforeach
    </div>
@endforeach
</div>
@include('visit.bottom')
